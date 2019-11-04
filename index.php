<?php session_start();

/******************************************************************************************************************\
 *File:    index.php                                                                                               *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
 *Purpose: This is the controller.                                                                                 *
\******************************************************************************************************************/

//get the value of the POST or GET data from form actions
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'login';
    }
}

//load CSS into all pages
require("Views/styling.php");
//load the files from Models
require_once('Models/Database.php');
require_once('Models/PlayerDB.php');
require_once('Models/Players.php');
require_once('Models/Validation.php');

//decide what to do based on the action(s) received from gameplay/forms
switch ($action) {
    case 'login':
        include("Views/login.php");
        die();
        break;
    case 'submit_login':
        //get the username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        //get the password
        $password = filter_input(INPUT_POST, 'password');
        //retrieve the hashed password from the users table by username
        $hash_from_db = PlayerDB::get_player_password($username);
        //check the entered password against the hashed password received from the Players table
        if (!password_verify($password, $hash_from_db)) {
            //password does not match--exit script and redirect to login
            $login_result = "Incorrect login. Please try again.";
            include("Views/login.php");
        } else {
            //password matches--save the logged-in player in the session and then proceed to the gameplay page
            $_SESSION["authenticated"] = "true";
            //get the player ID
            $player_id = PlayerDB::get_player_id($username);
            $_SESSION["current_player"] = $player_id;
            $player = PlayerDB::get_player_object($player_id);
            require('Views/game.php');
        }
        die();
        break;
    case 'register':
        //get the form data
        include('Views/registration.php');
        die();
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
            $no_invite = "You don't have permission to be registering. Get on outta here.";
            include('Views/registration.php');
            exit();
        }
        //create associative array for all input
        $input_array = array('Username' => $username, 'First Name' => $first_name, 'Last Name' => $last_name, 'Email Address' => $email_address, 'Password' => $password);
        //validate input before proceeding
        //variable to store result of validation
        $validation_result = Validation::is_valid($input_array);
        if (count($validation_result) > 0) {
            //there's something wrong with the form input
            include('Views/registration.php');
            die();
            break;
        } else {
            //salt
            $options = [
                'cost' => 14,
            ];
            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
            //add the user to the Players database
            PlayerDB::add_new_user($username, $first_name, $last_name, $email_address, $hash);
            $player_id = PlayerDB::get_player_id($username);
            $_SESSION["current_player"] = $player_id;
            //redirect the player to the login screen
            $message = "Thank you for registering! Let's get you signed in now.";
            include("Views/login.php");
            die();
            break;
        }
    case 'logout';
        session_destroy();
        include("Views/login.php");
        die();
        break;
}
