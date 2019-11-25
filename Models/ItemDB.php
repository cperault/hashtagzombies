<?php

/******************************************************************************************************************\
 *File:    ItemDB.php                                                                                              *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This class will handle all DB queries pertaining to the items for inventory                             *
\******************************************************************************************************************/

class ItemDB
{

    //query to get item info based on item_id passed in from the user's inventory
    public static function get_item_info($item_id)
    {
        $db = Database::getDB();
        $query = "SELECT item_name, item_category, item_description
                  FROM items 
                  INNER JOIN inventory ON items.item_id=inventory.item_id
                  WHERE item_id = :item_id";
    }
}
