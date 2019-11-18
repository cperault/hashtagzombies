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
    <?php include("Models/JS/map.html"); ?>
    <div class="game_outer_interface_div_left">
        <?php foreach ($left_panel_headers as $header) {
            echo "<ul><li>" . $header . "</li></ul";
        } ?>
    </div>
    <footer class="logout_footer">
        <form action="." method="POST">
            <input type="submit" value="Logout">
            <input type="hidden" name="action" value="logout">
        </form>
    </footer>


    </html>