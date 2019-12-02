<?php

/******************************************************************************************************************\
 *File:    game.php                                                                                                *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
 *Purpose: This is the view where all gameplay is displayed.                                                       *
\******************************************************************************************************************/
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>#ZOMBIES</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/processing.js/1.4.8/processing.min.js"></script>
    <script src="Models/JS/map.js" type="text/javascript"></script>
    <script src="Models/JS/inventory.js"></script>
    <div id="inventory_modal_container_div" class="inventory_modal">

        <span onclick="closeInventory();" id="inventory_close_button">&times;</span>
        <?php if (isset($items) && count($items) > 0) { ?>
            <table class="inventory_table">
                <tr>
                    <th class="th_item">Item</th>
                    <th class="th_desc">Description</th>
                    <th class="th_qty">Quantity</th>
                    <th class="th_action">Action</th>
                </tr>

                <?php foreach ($items as $item) : { ?>
                        <tr id='<?php echo htmlspecialchars($item["inventory_id"]) ?>'>
                            <td><?php echo htmlspecialchars($item["item_name"]); ?></td>
                            <td><?php echo htmlspecialchars($item["item_description"]); ?></td>
                            <td><?php echo htmlspecialchars($item["item_qty"]); ?></td>
                            <td>
                                <input type="submit" value="Use" onclick="useItem()" id="btnUseInventory" />
                                <input type="submit" value="Drop" onclick="dropItem()" id="btnDropInventory" />
                            </td>
                        </tr>
                <?php }
                    endforeach; ?>
            </table> <?php
                        } else {
                            //echo "<span onclick='closeInventory();' id='inventory_close_button'>&times;</span>";
                            echo "<p class='no-items-message'>You don't have any items yet. :(</p>";
                        }
                        ?>

    </div>
<div id='inventory_placeholder'>
    XXX
</div>
    <?php include("Models/JS/map.html"); ?>
    <div class="game_outer_interface_div_left">

        <table class="game_profile_table">
            <tr>
                <th>Username</th>
                <?php if (isset($character_object)) {
                    echo "<th>Character</th>";
                    echo "<th>Character Level</th>";
                } else {
                    echo "<th>Character</th>";
                } ?>
                <th>Health</th>
                <th>Inventory</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($player->username); ?></td>
                <?php if (isset($character_object)) {
                    echo "<td>" . htmlspecialchars($character_object->character_name) . "</td>";
                    echo "<td>" . htmlspecialchars($character_object->character_level) . "</td>";
                } else {
                    echo "<form action='.' method='POST'><td class='create_character_button'><input type='submit' value='Create character'/><input type='hidden' name='action' value='create_character'/></form></td>";
                } ?>
                <td id="character_health_status"></td>
                <!--default 100; this will need to be dynamically updated throughout gameplay by targeting the `element by id` selector and changing innerText-->
                <!--Would be cool to setup different colors for health ranges; green for 100-90, orange 89-70, yellow 69-50, etc. I will set that up. :) -->
                <td><input type="submit" value="View inventory" onclick="viewInventory()" id="btnViewInventory" /></td>
            </tr>
        </table>
    </div>

    <footer class="logout_footer">
        <form action="." method="POST">
            <input type="submit" value="Logout">
            <input type="hidden" name="action" value="logout">
        </form>
    </footer>


    </html>
