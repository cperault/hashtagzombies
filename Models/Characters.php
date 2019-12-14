<?php

/******************************************************************************************************************\
 *File:    Characters.php                                                                                          *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 13th, 2019                                                                                     *
 *Purpose: This class will represent the character objects                                                         * 
\******************************************************************************************************************/
class Characters
{
    public $character_id, $character_name, $character_level, $character_image;

    function __construct($character_id, $character_name, $character_level, $character_image)
    {
        $this->character_id = $character_id;
        $this->character_name = $character_name;
        $this->character_level = $character_level;
        $this->character_image = $character_image;
    }
    function getCharacterID()
    {
        return $this->character_id;
    }
    function getCharacterName()
    {
        return $this->character_name;
    }
    function getCharacterLevel()
    {
        return $this->character_level;
    }
    function getCharacterImage()
    {
        return $this->character_image;
    }
    function setCharacterID($character_id)
    {
        $this->character_id = $character_id;
    }
    function setCharacterName($character_name)
    {
        $this->character_name = $character_name;
    }
    function setCharacterLevel($character_level)
    {
        $this->character_level = $character_level;
    }
    function setCharacterImage($character_image)
    {
        $this->character_image = $character_image;
    }
}
