<?php
if(!isset($_SESSION)) {
session_start();}
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
                        //password matches--save the logged-in player in the session and then proceed to the gameplay page
                        GameLoad::load_game_data();
                        die;
                    }
                }
            }
        }
    }
}
