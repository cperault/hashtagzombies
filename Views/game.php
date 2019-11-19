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
    <?php include("Models/JS/map.html"); ?>
    <div class="game_outer_interface_div_left">
        <table class="game_profile_table">
            <tr>
                <th>Username</th>
                <th>Character</th>
                <th>Character Level</th>
                <th>Health</th>
                <th>Inventory</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($player->username); ?></td>
                <td><?php echo htmlspecialchars($character_object->character_name); ?></td>
                <td><?php echo htmlspecialchars($character_object->character_level); ?></td>
                <td id="character_health_status">100</td>
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