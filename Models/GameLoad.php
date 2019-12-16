<?php
if(!isset($_SESSION)) {
session_start();}
/******************************************************************************************************************\
 *File:    GameLoad.php                                                                                            *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This function will load all necessary data before the user is redirected to the game.php view. This     *
           will decrease the amount of repeated code in the index. This class will use login session data.         *
\******************************************************************************************************************/
class GameLoad
{
    //function to load gameplay page for non-admins
    public static function load_game_data()
    {
        //get the player object from username saved in the session at login
        $player = PlayerDB::get_player_object(PlayerDB::get_player_id($_SESSION["username"]))[0];
        //check to see if the user currently has a character
        $has_character = PlayerDB::has_character($_SESSION["player_id"]);
        //if user has a character selected, get the character ID and character object
        if ($has_character) {
            //get player's character ID
            $character_id = CharacterDB::get_character_id($_SESSION["player_id"]);
            $character_object = CharacterDB::get_character_object($character_id)[0];
        }
        //get all inventory for the logged in user
        $items = InventoryDB::get_all_inventory($_SESSION["player_id"]);
        $gamestate = PlayerDB::load_game($_SESSION["player_id"]);
        if (!isset($gamestate) || $gamestate == NULL || $gamestate == '') {
            $gamestate = '{"level":1, "exp":0,"inventory":[]}';
        }
        include('Views/game.php');
    }

    //function to load admin page
    public static function load_admin_page()
    {
        $admin_object = PlayerDB::get_player_object(PlayerDB::get_player_id($_SESSION["username"]))[0];
        include("Views/admin_view.php");
    }
}
