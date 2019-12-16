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
        $query = "SELECT inventory.inventory_id, inventory.item_id, inventory.player_id, inventory.item_qty, items.item_name, items.item_category, items.item_description
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

    //query to get item quantity by inventory ID
    public static function get_item_quantity($inventory_id)
    {
        $db = Database::getDB();
        $query = "SELECT item_qty FROM inventory WHERE inventory_id = :inventory_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':inventory_id', $inventory_id);
        $statement->execute();
        $quantity = $statement->fetch();
        $statement->closeCursor();
        return $quantity["item_qty"];
    }

    //query to get item quantity of specific user by item_id
    public static function get_item_quantity_of_user_item($item_id, $player_id)
    {
        $db = Database::getDB();
        $query = "SELECT item_qty FROM inventory WHERE item_id = :item_id AND player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $quantity = $statement->fetch();
        $statement->closeCursor();
        return $quantity["item_qty"];
    }

    //query to update item quantity by inventory ID
    public static function update_inventory($inventory_id, $new_quantity)
    {
        $db = Database::getDB();
        $query = "UPDATE inventory SET item_qty = :new_quantity WHERE inventory_id = :inventory_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':new_quantity', $new_quantity);
        $statement->bindValue(':inventory_id', $inventory_id);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to update item quantity by player ID and item ID
    public static function update_inventory_item($player_id, $item_id, $new_quantity)
    {
        $db = Database::getDB();
        $query = "UPDATE inventory SET item_qty = :new_quantity WHERE item_id = :item_id AND player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':new_quantity', $new_quantity);
        $statement->bindValue(':item_id', $item_id);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $statement->closeCursor();
    }

    //query to retrieve inventory ID of item by player ID and item ID
    public static function get_inventory_id($player_id, $item_id)
    {
        $db = Database::getDB();
        $query = "SELECT inventory_id FROM inventory WHERE item_id = :item_id AND player_id = :player_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->bindValue(':player_id', $player_id);
        $statement->execute();
        $id = $statement->fetch();
        $statement->closeCursor();
        return $id["inventory_id"];
    }
}
