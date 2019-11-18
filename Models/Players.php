<?php

/******************************************************************************************************************\
 *File:    Players.php                                                                                             *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 27th, 2019                                                                                      *
 *Purpose: This class will represent the player objects                                                            * 
\******************************************************************************************************************/
class Players
{
    public $player_id, $username, $first_name, $last_name, $email_address;

    function __construct($player_id, $username, $first_name, $last_name, $email_address)
    {
        $this->player_id = $player_id;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;
    }
    function getPlayerID()
    {
        return $this->player_id;
    }
    function getUsername()
    {
        return $this->username;
    }
    function getFirstName()
    {
        return $this->first_name;
    }
    function getLastName()
    {
        return $this->last_name;
    }
    function getEmailAddress()
    {
        return $this->email_address;
    }
    function setUserID($player_id)
    {
        $this->player_id = $player_id;
    }
    function setUsername($username)
    {
        $this->username = $username;
    }
    function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }
}
