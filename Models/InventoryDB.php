<?php

/******************************************************************************************************************\
 *File:    InventoryDB.php                                                                                         *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 25th, 2019                                                                                     *
 *Purpose: This class will handle all DB queries pertaining to inventory per character                             *
\******************************************************************************************************************/

class InventoryDB
{
    //query to get all inventory by character ID
    public static function get_all_inventory($player_id)
    {
        $db = Database::getDB();
        $query = "SELECT inventory.item_id, inventory.item_qty, items.item_name, items.item_description
                  FROM inventory
                  INNER JOIN Players ON inventory.player_id=Players.playerID
                  INNER JOIN items ON inventory.item_id=items.item_id
                  WHERE player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $items = $statement->fetchAll();
        $stuff = [];
        if ($statement->rowCount() >= 1) {
            foreach ($items as $i) {
                $stuff[] = $i;
            }
        }
        $statement->closeCursor();
        return $stuff;
    }
}
