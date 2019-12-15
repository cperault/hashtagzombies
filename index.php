<?php session_start();

/******************************************************************************************************************\
 *File:    index.php                                                                                               *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
 *Purpose: This is the controller.                                                                                 *
\******************************************************************************************************************/

////import the PHPMailer classes installed from Composer
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
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

////instantiate PHPMailer object
//$mail = new PHPMailer(true); //true enables exception handling
//
////SMTP server settings setup as shown in the library's documentation
////$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
//$mail->isSMTP();                                            // Send using SMTP
//$mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
//$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//$mail->Username   = 'hashtagzombies.development@gmail.com'; // SMTP username
//$mail->Password   = 'uodzpufieenhtdzt';                 // SMTP password
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
//$mail->Port       = 587;


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
if ($request_path === "index.php/discard_inventory_item") {
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
        exit($message);
        break;
    case 'change_map':
        exit;
        break;
}
