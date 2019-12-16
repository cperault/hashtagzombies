<?php
session_start();
/******************************************************************************************************************\
 *File:    UserLogin.php                                                                                           *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This class will handle the login process and be called in the controller.                               *
\******************************************************************************************************************/


class UserLogin
{
    //function to process the login
    public static function process_login($username, $password)
    {
        //create associative array for all input
        $input_array = array('Login username' => $username, 'Login password' => $password);
        //validate input before proceeding
        //variable to store result of validation
        $validation_result = Validation::is_valid($input_array);
        if (count($validation_result) > 0) {
            //there's something wrong with the form input
            include('Views/login.php');
            die;
        } else {
            //check to make sure that the user hasn't already registered
            $email_address = PlayerDB::get_email_address($username);

            if (!PlayerDB::is_registered($email_address)) {
                $login_result = "Incorrect login. Please try again.";
                include('Views/login.php');
                die;
            } else {
                //while a user should not be able to login without an active account, prevent them from being able to login prior to verifying (URL hijacking to /login.php or them going back to login without verifying)
                $activated = PlayerDB::is_activated($username);
                if (!$activated) {
                    $message = "Your email address was never verified upon registering. For security reasons, you must first confirm your email address.";
                    $resend = true;
                    $_SESSION['user_needing_verified'] = $username;
                    $_SESSION['user_email_needing_verified'] = PlayerDB::get_email_address($username);
                    include('Views/login_confirmation.php');
                    die;
                } else {
                    //retrieve the hashed password from the users table by username
                    $hash_from_db = PlayerDB::get_player_password($username);
                    //check the entered password against the hashed password received from the Players table
                    if (!password_verify($password, $hash_from_db)) {
                        //password does not match--exit script and redirect to login
                        $login_result = "Incorrect login. Please try again.";
                        include("Views/login.php");
                        die;
                    } else {
                        $_SESSION["username"] = $username;
                        //set session authenticated to true
                        $_SESSION["authenticated"] = "true";
                        //store player ID in session
                        $_SESSION["player_id"] = PlayerDB::get_player_id($username);
                        //check if admin or player logging in--if admin, take to admin page, otherwise proceed to gameplay
                        $is_admin = PlayerDB::is_admin($email_address);
                        if ($is_admin) {
                            //get the player object from username saved in the session at login
                            GameLoad::load_admin_page();
                            die;
                        } else {
                            $_SESSION["username"] = $username;
                            //set session authenticated to true
                            $_SESSION["authenticated"] = "true";
                            //store player ID in session
                            $_SESSION["player_id"] = PlayerDB::get_player_id($username);
                            //password matches--save the logged-in player in the session and then proceed to the gameplay page
                            GameLoad::load_game_data();
                            die;
                        }
                    }
                }
            }
        }
    }

    //function to reset login password password
    public static function reset_password($username, $mail)
    {
        //validate the username input
        $username_input = array('Password reset username' => $username);
        $validation_result = Validation::is_valid($username_input);
        if (count($validation_result) > 0) {
            //there's something wrong on the password reset form
            include("Views/password_reset.php");
            die;
        } else {
            //check to make sure that the user exists already in our records
            $email_address = PlayerDB::get_email_address($username);

            if (!PlayerDB::is_registered($email_address)) {
                $login_result = "Incorrect username. Please try again.";
                include('Views/password_reset.php');
                die;
            } else {
                //check if user has activated their account/confirmed their email
                $activated = PlayerDB::is_activated($username);
                if (!$activated) {
                    $message = "Your email address was never verified upon registering. For security reasons, you must first confirm your email address.";
                    $resend = true;
                    $_SESSION['user_needing_verified'] = $username;
                    $_SESSION['user_email_needing_verified'] = PlayerDB::get_email_address($username);
                    //send them to the login page where it shows their resend button to activate their account
                    include('Views/login_confirmation.php');
                    die;
                } else {
                    //email user with secret code and then redirect them to the password reset page where they'll enter a new password and the secret code received via email
                    //get activation secret using function in Confirmation.php
                    $reset_secret = generate_security_code();
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
                        $mail->Body = "In order to reset your password, you must copy your uniquely generated secret hash, " . $reset_secret . ", and then paste it into the form.";
                        $mail->AltBody = 'This is the email body in plain text.';
                        $mail->send();
                    } catch (Exception $exception) {
                        $email_result = "Uh oh. " . $mail->ErrorInfo;
                    }
                    $message = "We have sent a secret hash to your email. Retreive it and return here to reset your password.";
                    $has_reset_secret = true;
                    include("Views/password_reset.php");
                    $_SESSION["email_for_password_reset"] = $email_address;
                    die;
                }
            }
        }
    }
}
