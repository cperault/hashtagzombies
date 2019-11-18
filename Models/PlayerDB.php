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
    public static function add_new_user($username, $first_name, $last_name, $email_address, $player_password, $activation_secret)
    {
        $db = Database::getDB();
        $query = 'INSERT INTO Players (playerUsername,playerFirstName,playerLastName,playerEmailAddress,playerPassword,activationSecret)
                  VALUES (:username,:first_name,:last_name,:email_address,:player_password,:activation_secret)';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email_address', $email_address);
        $statement->bindValue(':player_password', $player_password);
        $statement->bindValue(':activation_secret', $activation_secret);
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
        $query = 'SELECT playerUsername, playerFirstName, playerLastName, playerEmailAddress
                  FROM Players WHERE playerID = :player_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $player = $statement->fetchAll();
        $playerArray = [];

        foreach ($player as $p) {
            $playerArray[] = new Players($p['playerID'], $p['playerUsername'], $p['playerFirstName'], $p['playerLastName'], $p['playerEmailAddress']);
        }
        $statement->closeCursor();
        return $playerArray;
    }

    //query to check if the email being used to register is already being used
    public static function is_registered($email_address)
    {
        $db = Database::getDB();
        $query = 'SELECT playerUsername FROM Players WHERE playerEmailAddress = :email_address';
        $statement = $db->prepare($query);
        $statement->bindValue(':email_address', $email_address);
        $statement->execute();

        $user_exists = false;
        //check if record found, return true or false
        if ($statement->rowCount() >= 1) {
            $user_exists = true;
        }
        $statement->closeCursor();
        return $user_exists;
    }

    //query to retrieve activation secret by user username
    public static function get_activation_secret($username)
    {
        $db = Database::getDB();
        $query = 'SELECT activationSecret FROM Players WHERE playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $secret = $statement->fetch();
        return $secret['activationSecret'];
    }

    //query to check if user account is activated
    public static function is_activated($username)
    {
        $db = Database::getDB();
        $query = 'SELECT playerUsername FROM Players WHERE playerUsername = :username AND isActiveAccount = 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();

        $account_activated = false;
        if ($statement->rowCount() >= 1) {
            $account_activated = true;
        }
        return $account_activated;
    }

    //query to activate account after successful verification via email
    public static function activate_user_account($username)
    {
        $db = Database::getDB();
        $query = 'UPDATE Players SET isActiveAccount = 1 WHERE playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to update activation secret for user in instances of password reset/resending of confirmation code
    public static function change_secret($username, $new_secret)
    {
        $db = Database::getDB();
        $query = 'UPDATE Players SET activationSecret = :new_secret WHERE playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':new_secret', $new_secret);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to retrieve user's email address for username specified
    public static function get_email_address($username)
    {
        $db = Database::getDB();
        $query = 'SELECT playerEmailAddress FROM Players where playerUsername = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $player_email_address = $statement->fetch();
        $statement->closeCursor();
        return $player_email_address['playerEmailAddress'];
    }

    //query to check if the user has a character created
    public static function has_character($player_id)
    {
        $db = Database::getDB();
        $query = 'SELECT playerUsername FROM Players WHERE hasCharacter = 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();

        $character_created = false;
        //check if record found, return true or false
        if ($statement->rowCount() >= 1) {
            $character_created = true;
        }
        $statement->closeCursor();
        return $character_created;
    }
}
