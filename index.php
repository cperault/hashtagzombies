<?php session_start();

/******************************************************************************************************************\
 *File:    index.php                                                                                               *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
 *Purpose: This is the controller.                                                                                 *
\******************************************************************************************************************/

//import the PHPMailer classes installed from Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//load the autoloader from Composer
require_once('vendor/autoload.php');
//load CSS into all pages
require_once("Views/styling.php");
//load the files from Models
require_once('Models/Database.php');
require_once('Models/Characters.php');
require_once('Models/Players.php');
require_once('Models/PlayerDB.php');
require_once('Models/Validation.php');
require_once('Models/Confirmation.php');

//instantiate PHPMailer object
$mail = new PHPMailer(true); //true enables exception handling

//SMTP server settings setup as shown in the library's documentation
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'hashtagzombies.development@gmail.com'; // SMTP username
$mail->Password   = 'zyrhoj-4vuqxi-xYkvuj';                 // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
$mail->Port       = 587;

//get the value of the POST or GET data from form actions
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'login';
    }
}

if (isset($_SESSION["current_player"])) {
    //check to see if user has created a character yet
    $has_character = PlayerDB::has_character($player_id);
    if ($has_character) {
        $character = PlayerDB::get_character_object($player_id)[0];
    }
}

//decide what to do based on the action(s) received from gameplay/forms
switch ($action) {
    case 'login':
        include("Views/login.php");
        die;
        break;
    case 'submit_login':
        //get the username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        //get the password
        $password = filter_input(INPUT_POST, 'password');
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
                        //password matches--save the logged-in player in the session and then proceed to the gameplay page
                        $_SESSION["authenticated"] = "true";
                        //get the player ID
                        $player_id = PlayerDB::get_player_id($username);
                        $_SESSION["current_player"] = $player_id;
                        $player = PlayerDB::get_player_object($player_id)[0];
                        //store player object in session
                        $_SESSION["logged_in_player"] = $player;
                        //check to see if user has created a character yet
                        $has_character = PlayerDB::has_character($player_id);
                        if ($has_character) {
                            $character = PlayerDB::get_character_object($player_id)[0];
                        }
                        $character_id = PlayerDB::get_character_id($player_id);
                        $player = PlayerDB::get_player_object($player_id)[0];
                        $character_object = PlayerDB::get_character_object($character_id)[0];
                        //TODO: dummy user with five items, health bar, username; login and show on
                        //TODO: interface for user information/stats (profile, username, character name, inventory, health, etc.)
                        include('Views/game.php');
                    }
                }
            }
        }
        break;
    case 'register':
        //get the form data
        include('Views/registration.php');
        die;
        break;
    case 'submit_registration':
        //get data from the form
        $username = htmlspecialchars(trim(filter_input(INPUT_POST, 'username')));
        $first_name = htmlspecialchars(trim(filter_input(INPUT_POST, 'first_name')));
        $last_name = htmlspecialchars(trim(filter_input(INPUT_POST, 'last_name')));
        $email_address = htmlspecialchars(trim(filter_input(INPUT_POST, 'email_address')));
        $password = filter_input(INPUT_POST, 'password');
        $invite_code = htmlspecialchars(trim(filter_input(INPUT_POST, 'invite_code')));

        //if user has not entered an invite code, exit script; this will prevent spam registrations while site is live
        if ($invite_code !== "green_teamis_awesome!") {
            $no_invite_error = "You don't have permission to be registering. Get on outta here.";
            include('Views/registration.php');
            die;
        }

        //check to make sure that the user hasn't already registered
        if (PlayerDB::is_registered($email_address)) {
            $email_in_use_error = "That email address has already been used for registration.";
            include('Views/registration.php');
            die;
        }

        //create associative array for all input
        $input_array = array('Username' => $username, 'First Name' => $first_name, 'Last Name' => $last_name, 'Email Address' => $email_address, 'Password' => $password);
        //validate input before proceeding
        //variable to store result of validation
        $validation_result = Validation::is_valid($input_array);
        if (count($validation_result) > 0) {
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

            //variable to store if message was sent; will be "success" or specific error information
            $sent = "";

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
                $sent = "success";
            } catch (Exception $exception) {
                $email_result = "Uh oh. " . $mail->ErrorInfo;
            }

            if ($sent !== "success") {
                $email_send_error = "I'm sorry, there was an error in finishing your registration. Please try again in a few minutes";
                include("Views/registration.php");
                die;
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
        break;
    case 'confirm_registration':
        //get the username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        //get the confirmation security code
        $security_code = htmlspecialchars(filter_input(INPUT_POST, 'confirmation_code'));
        //check if entered code matches that stored in the database for the username entered
        $stored_secret = PlayerDB::get_activation_secret($username);
        if ($security_code !== $stored_secret) {
            //password does not match--exit script and redirect to login
            $message = "Verification failed. Please verify you have entered the code we emailed you and try again.";
            include("Views/login_confirmation.php");
        } else {
            $message = "Your email address was confirmed. Thank you! Please log in.";
            //activate the user's account
            PlayerDB::activate_user_account($username);
            include("Views/login.php");
        }
        die;
        break;
    case 'resend_verification_code':
        //get current username and email address of user needing to be reverified
        $email_to_verify = $_SESSION['user_email_needing_verified'];
        $username_of_email_to_verify = $_SESSION['user_needing_verified'];
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
        break;
    case 'create_character':
        include("Views/character_create.php");
        die;
        exit();
    case 'save_character':
        $player_id = $_SESSION["current_player"];
        $player = PlayerDB::get_player_object($player_id)[0];
        //get the character info
        $character_name = htmlspecialchars(trim(filter_input(INPUT_POST, 'character_name')));
        $character_image = htmlspecialchars(trim(filter_input(INPUT_POST, 'character_image')));
        //save character to the database per user ID
        PlayerDB::save_character($player_id, $character_name, $character_image);
        //get character id
        $character_id = PlayerDB::get_character_id($player_id);
        $character_object = PlayerDB::get_character_object($character_id)[0];
        //update has_character field in Players for player ID
        PlayerDB::update_player_after_character_creation($player_id, $character_id);
        include("Views/game.php");
        die;
        break;
    case 'dashboard':
        $player_id = $_SESSION["current_player"];
        $player = PlayerDB::get_player_object($player_id)[0];
        include("Views/game.php");
        die;
        break;
    case 'logout';
        session_destroy();
        include("Views/login.php");
        die;
        break;
}
