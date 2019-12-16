<?php

/******************************************************************************************************************\
 *File:    AdminDB.php                                                                                            *
 *Project: #ZOMBIES                                                                                               *
 *Date:    December 15th, 2019                                                                                    *
 *Purpose: This class will handle all DB queries pertaining admin functions                                       *
\******************************************************************************************************************/

class AdminDB
{

    //query to reset player's password
    public static function reset_player_password($username, $new_password)
    {
        $db = Database::getDB();
        $query = "UPDATE Players SET playerPassword = :new_password WHERE playerUsername = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':new_password', $new_password);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to reset player to default state
    public static function reset_player_state($player_id)
    {
        $db = Database::getDB();

        //reset character
        $query = "UPDATE Characters SET characterLevel = 1 WHERE playerID = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();

        //reset inventory
        $query = "UPDATE inventory SET item_qty = 0 WHERE player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to delete player
    public static function delete_player($player_id)
    {
        $db = Database::getDB();

        //delete inventory
        $query = "DELETE FROM inventory WHERE player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();

        //delete character
        $query = "DELETE FROM Characters WHERE playerID = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();

        //delete player
        $query = "DELETE FROM Players WHERE playerID = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();
    }
}
