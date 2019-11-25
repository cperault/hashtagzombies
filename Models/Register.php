<?php
session_start();
/******************************************************************************************************************\
 *File:    Register.php                                                                                            *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This class will handle the registration process and be called in the controller.                        *
\******************************************************************************************************************/

class Register
{

    //function to resent verification code
    public static function resend_verification($email_to_verify, $username_of_email_to_verify, $mail)
    {
        //generation new activation secret for user
        $activation_secret = generate_security_code();
        //update user record
        PlayerDB::change_secret($username_of_email_to_verify, $activation_secret);
        //resend confirmation code to user in session
        try {
            //lets the user know we are the ones emailing
            $mail->setFrom('hashtagzombies.development@gmail.com', '#ZOMBIES Developers');
            //who will receiving the email
            $mail->addAddress($email_to_verify);
            //create reply-to email address
            $mail->addReplyTo('hashtagzombies.development@gmail.com', '#ZOMBIES Developers');
            //set up email content
            $mail->isHTML(true);
            $mail->Subject = 'Please confirm your registration.';
            $mail->Body = "Thank you for allowing us to secure your account. In order to log in, we require you to confirm the email address provided at registration. Your new security code is " . $activation_secret . ". If you did not authorize this, please reply to this email and we will be in touch.";
            $mail->AltBody = 'This is the email body in plain text.';
            $mail->send();
            $sent = "success";
        } catch (Exception $exception) {
            $email_result = "Uh oh. " . $mail->ErrorInfo;
        }
        if ($sent !== "success") {
            $email_send_error = "I'm sorry, there was an error in sending your verification email. Please try again in a few minutes";
            include("Views/registration.php");
            die;
        } else {
            $message = "We have resent your verification code. Please check your email and enter it here.";
            include("Views/login_confirmation.php");
            die;
        }
    }
    //function to confirm registration data
    public static function confirm_registration($username, $security_code)
    {
        //check if entered code matches that stored in the database for the username entered
        $stored_secret = PlayerDB::get_activation_secret($username);
        if ($security_code !== $stored_secret) {
            //password does not match--exit script and redirect to login
            $message = "Verification failed. Please verify you have entered the code we emailed you and try again.";
            include("Views/login_confirmation.php");
        } else {
            $message = "Thank you for confirming your email address! Please log in.";
            //activate the user's account
            PlayerDB::activate_user_account($username);
            include("Views/login.php");
        }
    }

    //function to process registration data
    public static function process_registration($username, $first_name, $last_name, $email_address, $password, $invite_code, $mail)
    {
        //if user has not entered an invite code, exit script; this will prevent spam registrations while site is live
        if ($invite_code !== "green_teamis_awesome!") {
            $no_invite_error = "You don't have permission to be registering. Get on outta here.";
            include('Views/registration.php');
            die;
        }

        //create associative array for all input
        $input_array = array('Username' => $username, 'First Name' => $first_name, 'Last Name' => $last_name, 'Email Address' => $email_address, 'Password' => $password);
        //validate input before proceeding
        //variable to store result of validation
        $validation_result = Validation::is_valid($input_array);
        if (count($validation_result, 1) > 0) {
            //there's something wrong with the form input
            include('Views/registration.php');
            die;
        } else {
            //salt
            $options = [
                'cost' => 14,
            ];
            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
            //get activation secret using function in Confirmation.php
            $activation_secret = generate_security_code();
            try {
                //lets the user know we are the ones emailing
                $mail->setFrom('hashtagzombies.development@gmail.com', '#ZOMBIES Developers');
                //who will receiving the email
                $mail->addAddress($email_address);
                //create reply-to email address
                $mail->addReplyTo('hashtagzombies.development@gmail.com', '#ZOMBIES Developers');
                //set up email content
                $mail->isHTML(true);
                $mail->Subject = 'Please confirm your registration.';
                $mail->Body = 'Thank you for registering, ' . $first_name . ". In order to activate your account, we require you to confirm the email address provided. Your security code is " . $activation_secret . ". If you did not authorize this, please reply to this email and we will be in touch.";
                $mail->AltBody = 'This is the email body in plain text.';
                $mail->send();
            } catch (Exception $exception) {
                $email_result = "Uh oh. " . $mail->ErrorInfo;
            }
            //add the user to the Players database
            PlayerDB::add_new_user($username, $first_name, $last_name, $email_address, $hash, $activation_secret);
            $player_id = PlayerDB::get_player_id($username);
            $_SESSION["current_player"] = $player_id;
            //redirect the player to the login screen and inform them to return with confirmation code
            $message = "Thank you for registering! A confirmation code has been sent to " . $email_address . ". Please enter that code below.";
            include("Views/login_confirmation.php");
            die;
        }
    }
}
