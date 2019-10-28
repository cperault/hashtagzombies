<?php

/******************************************************************************************************************\
 *File:    PlayerDB.php                                                                                            *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 27th, 2019                                                                                      *
 *Purpose: This class will handle all DB queries pertaining to the player                                          *
\******************************************************************************************************************/

class PlayerDB
{

    //query to add new user to the Players table
    public static function add_new_user($username, $first_name, $last_name, $email_address, $player_password)
    {
        $db = Database::getDB();
        $query = 'INSERT INTO Players (playerUsername,playerFirstName,playerLastName,playerEmailAddress,playerPassword)
                  VALUES (:username,:first_name,:last_name,:email_address,:player_password)';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email_address', $email_address);
        $statement->bindValue(':player_password', $player_password);
        $statement->execute();
        $statement->closeCursor();
    }
    //query to get the password of a user by their email address
    public static function get_player_password($username)
    {
        $db = Database::getDB();
        $query = 'SELECT playerPassword FROM Players WHERE playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $password = $statement->fetch();
        $statement->closeCursor();
        return $password['playerPassword'];
    }

    //query to get the player ID by username
    public static function get_player_ID($username)
    {
        $db = Database::getDB();
        $query = 'SELECT playerID FROM Players where playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $player_id = $statement->fetch();
        $statement->closeCursor();
        return $player_id['playerID'];
    }

    //query to get all information on the user by username; returns player object to controller
    public static function get_player_object($player_id)
    {
        $db = Database::getDB();
        $query = 'SELECT playerUsername, playerFirstName, playerLastName, playerEmailAddress, playerPassword
                  FROM Players WHERE playerID = :player_id';
        $statement = $db->prepare($query);
        $statement->bindValue('player_id', $player_id);
        $statement->execute();
        $player = [];

        foreach ($player as $p) {
            $player[] = new Player($p['playerID'], $p['playerUsername'], $p['playerFirstName'], $p['playerLastName'], $p['playerEmailAddress'], $p['playerPassword']);
        }
        $statement->closeCursor();
        return $player;
    }
}
