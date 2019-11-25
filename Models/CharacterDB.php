<?php

/******************************************************************************************************************\
 *File:    CharacterDB.php                                                                                         *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This class will handle all DB queries pertaining to the character                                       *
\******************************************************************************************************************/
class CharacterDB
{

    //query to save character selected by player id
    public static function save_character($player_id, $character_name, $character_image)
    {
        $db = Database::getDB();
        $query = 'INSERT INTO Characters (playerID,characterName,characterImage)
                  VALUES (:player_id,:character_name,:character_image)';
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->bindValue(':character_name', $character_name);
        $statement->bindValue(':character_image', $character_image);
        $statement->execute();
        $statement->closeCursor();;
    }

    //query to get all information on the user by username; returns player object to controller
    public static function get_character_object($character_id)
    {
        $db = Database::getDB();
        $query = 'SELECT characterID, playerID, characterName, characterLevel, characterImage
              FROM Characters WHERE characterID = :character_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':character_id', $character_id);
        $statement->execute();
        $character = $statement->fetchAll();
        $characterArray = [];

        foreach ($character as $c) {
            $characterArray[] = new Characters($c['characterID'], $c['characterName'], $c['characterLevel']);
        }
        $statement->closeCursor();
        return $characterArray;
    }

    //query to get character ID
    public static function get_character_id($player_id)
    {
        $db = Database::getDB();
        $query = 'SELECT characterID from Characters WHERE playerID = :player_id';
        $statement = $db->prepare($query);
        $statement->bindValue('player_id', $player_id);
        $statement->execute();
        $character_id = $statement->fetch();
        $statement->closeCursor();
        return $character_id['characterID'];
    }
}
