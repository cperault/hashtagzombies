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
//load the files from Models
require_once('Models/Database.php');
require_once('Models/Characters.php');
require_once('Models/Players.php');
require_once('Models/PlayerDB.php');
require_once('Models/Validation.php');
require_once('Models/Confirmation.php');
require_once('Models/CharacterDB.php');
require_once('Models/InventoryDB.php');
require_once('Models/GameLoad.php');
require_once('Models/Register.php');
require_once('Models/UserLogin.php');
require_once('Models/AdminDB.php');

//define the headers to be hit by frontend requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

////instantiate PHPMailer object
$mail = new PHPMailer(true); //true enables exception handling

//SMTP server settings setup as shown in the library's documentation
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'hashtagzombies.development@gmail.com'; // SMTP username
$mail->Password   = 'uodzpufieenhtdzt';                     // SMTP password
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

//store JavaScript Axios request data into $post_body
$post_body = json_decode(file_get_contents("php://input"), TRUE);
//set up filter for additional POST/GET to handle data coming from JS HTTP instead form submissions from frontend
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//assign `$action` to appropriate endpoint from JS requests which will designate which case below to hit
if ($request_path === "/discard_inventory_item") {
    $action = "discard_inventory_item";
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
        //send data to the Login model
        UserLogin::process_login($username, $password);
        die;
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
        $invite_code = trim(filter_input(INPUT_POST, 'invite_code'));

        //send data to the Register model
        Register::process_registration($username, $first_name, $last_name, $email_address, $password, $invite_code, $mail);
        die;
        break;
    case 'confirm_registration':
        //get the username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        //get the confirmation security code
        $security_code = htmlspecialchars(filter_input(INPUT_POST, 'confirmation_code'));
        //send data to the Register model
        Register::confirm_registration($username, $security_code);
        die;
        break;
    case 'resend_verification_code':
        //get current username and email address of user needing to be reverified
        $email_to_verify = $_SESSION['user_email_needing_verified'];
        $username_of_email_to_verify = $_SESSION['user_needing_verified'];

        //send data to the Register model
        Register::resend_verification($email_to_verify, $username_of_email_to_verify, $mail);
        die;
        break;
    case 'create_character':
        //go to the character creation view
        include("Views/character_create.php");
        die;
        exit();
    case 'save_character':
        //get the character info
        $character_name = htmlspecialchars(trim(filter_input(INPUT_POST, 'character_name')));
        $character_image = htmlspecialchars(trim(filter_input(INPUT_POST, 'character_image')));
        //save character to the database per user ID
        CharacterDB::save_character($_SESSION["player_id"], $character_name, $character_image);
        //get character id
        $character_id = CharacterDB::get_character_id($_SESSION["player_id"]);
        $character_object = CharacterDB::get_character_object($character_id)[0];
        //update has_character field in Players for player ID
        PlayerDB::update_player_after_character_creation($_SESSION["player_id"], $character_id);
        GameLoad::load_game_data();
        die;
        break;
    case 'dashboard':
        GameLoad::load_game_data();
        include("Views/game.php");
        die;
        break;
    case 'logout':
        session_destroy();
        //redirect to the login view
        include("Views/login.php");
        die;
        break;
    case "discard_inventory_item":
        //retrieve the item ID received from the Axios request
        $inventory_item_id = $post_body["itemID"];
        //get quantity of item ID
        $item_quantity = InventoryDB::get_item_quantity($inventory_item_id);
        //deduct 1 from quantity of item in user's inventory
        InventoryDB::update_inventory($inventory_item_id, ($item_quantity - 1));
        $remaining_quantity = $item_quantity - 1;
        //serve the new quantity value now that the server has updated the quantity server-side
        $message = json_encode(array("new_value" => $remaining_quantity), JSON_PRETTY_PRINT);
        die($message);
        break;
    case 'change_map':
        die;
        break;
    case 'reset_password':
        //load the password reset view
        include("Views/password_reset.php");
        die;
        break;
    case 'submit_password_reset':
        //get username
        $username = htmlspecialchars(trim(filter_input(INPUT_POST, 'username')));
        UserLogin::reset_password($username, $mail);
        die;
        break;
    case 'confirm_password_resubmit':
        //get new password and email address
        $email_address = $_SESSION["email_for_password_reset"];
        $new_password = filter_input(INPUT_POST, 'new_password');

        //hash the new password
        $options = [
            'cost' => 14,
        ];
        $hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
        //save new password
        PlayerDB::update_password($email_address, $hash);
        $login_result = "Your password has been reset! Please log in.";
        //redirect to login view
        include("Views/login.php");
        die($message);
        break;
    case 'reset_player_password':
        $player_password_reset_form = true;
        include("Views/admin_view.php");
        die;
        break;
    case 'submit_player_password_reset':
        //get username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'player_username'));
        //get new password
        $new_password = filter_input(INPUT_POST, 'player_new_password');
        //hash the new password
        $options = [
            'cost' => 14,
        ];
        $hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
        //save the new password
        AdminDB::reset_player_password($username, $hash);
        $message = "Password has been reset for " . $username . ".";
        //hide the password reset form
        $player_password_reset_form = false;
        include("Views/admin_view.php");
        die($message);
        break;
    case 'reset_player_state':
        $player_state_reset_form = true;
        include("Views/admin_view.php");
        die;
        break;
    case 'submit_player_state_reset':
        //get username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'player_username'));
        //get ID of user by username
        $player_id = PlayerDB::get_player_ID($username);
        //reset the player's state
        AdminDB::reset_player_state($player_id);
        //set message for admin view
        $message = "Player state has been reset for " . $username . ".";
        //hide the state reset form
        $player_state_reset_form = false;
        include("Views/admin_view.php");
        die($message);
        break;
    case 'delete_player':
        $player_delete_form = true;
        include("Views/admin_view.php");
        die;
        break;
    case 'submit_player_delete':
        //get username
        $username = htmlspecialchars(filter_input(INPUT_POST, 'player_username'));
        //get ID of user by username
        $player_id = PlayerDB::get_player_ID($username);
        //delete the player
        AdminDB::delete_player($player_id);
        //set message for admin view
        $message = $username . " has been deleted.";
        //hide the player delete form
        $player_delete_form = false;
        include("Views/admin_view.php");
        die($message);
        break;
}
