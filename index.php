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

//decide what to do based on the action(s) received from gameplay/forms
switch ($action) {
    case 'login':
        include("Views/login.php");
        die();
        break;
    case 'facebook_login_api':
        //TODO: make method call(s) to the model file in which Facebook authentication is done
        //TODO: gather any necessary data pertaining to the user based on some sort of associated information (email address more than likely); store that locally for the session
        //TODO: send logged-inuser to the game view so that they can start playing
        die();
        break;
    case 'google_login_api':
        //TODO: make method call(s) to the model file in which Google authentication is done
        //TODO: gather any necessary data pertaining to the user based on some sort of associated information (email address more than likely); store that locally for the session
        //TODO: send logged-in user to the game view so that they can start playing
        die();
        break;
}
