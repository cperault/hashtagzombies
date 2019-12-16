<?php

/******************************************************************************************************************\
 *File:    admin_view.php                                                                                          *
 *Project: #ZOMBIES                                                                                                *
 *Date:    December 15th, 2019                                                                                     *
 *Purpose: This is the admin page where admins can reset user passwords or restart users back to default state.    *
\******************************************************************************************************************/
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>#ZOMBIES</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
</head>

<body class="login_body">
    <header>
        <h1 class="zombies_header_login"><img src="Media/logo.jpeg" alt="Zombies bloody logo in all caps" height="150" width="500" /></h1>
    </header>
    <div class="admin_div">
        <?php if (isset($admin_object)) {
            echo "<h1 class='admin_header'>Hello, $admin_object->first_name";
        }
        ?>
        <br />
        <br />
        <form action="." method="POST">
            <input id="admin_main_button" type="submit" value="Reset a player's password">
            <input type="hidden" name="action" value="reset_player_password">
        </form>
        <?php if (isset($player_password_reset_form) && $player_password_reset_form) {
            //show from to reset password for a player
            echo "<div class='password_reset_admin_div'>";
            echo "<form action='.' method='POST'>";
            echo "<label for='player_username'>Player's username</label>";
            echo "<input type='text' name='player_username' class='textbox'>";
            echo "<br/>";
            echo "<label for='player_username'>Player's new password</label>";
            echo "<input type='text' name='player_new_password' class='textbox'>";
            echo "<br/>";
            echo "<input type='submit' value='Reset password'>";
            echo "<input type='hidden' name='action' value='submit_player_password_reset'>";
            echo "</form>";
            echo "</div>";
        } ?>
        <br />
        <br />
        <form action="." method="POST">
            <input id="admin_main_button" type="submit" value="Reset a player's state">
            <input type="hidden" name="action" value="reset_player_state">
        </form>
        <?php if (isset($player_state_reset_form) && $player_state_reset_form) {
            //show from to reset state for a player
            echo "<div class='state_reset_admin_div'>";
            echo "<form action='.' method='POST'>";
            echo "<label for='player_username'>Player's username</label>";
            echo "<input type='text' name='player_username' class='textbox'>";
            echo "<br/>";
            echo "<input type='submit' value='Reset state'>";
            echo "<input type='hidden' name='action' value='submit_player_state_reset'>";
            echo "</form>";
            echo "</div>";
        } ?>
        <br />
        <br />
        <form action="." method="POST">
            <input id="admin_main_button" type="submit" value="Delete a player">
            <input type="hidden" name="action" value="delete_player">
        </form>
        <?php if (isset($player_delete_form) && $player_delete_form) {
            //show from to reset state for a player
            echo "<div class='delete_player_admin_div'>";
            echo "<form action='.' method='POST'>";
            echo "<label for='player_username'>Player's username</label>";
            echo "<input type='text' name='player_username' class='textbox'>";
            echo "<br/>";
            echo "<input type='submit' value='Delete player'>";
            echo "<input type='hidden' name='action' value='submit_player_delete'>";
            echo "</form>";
            echo "</div>";
        } ?>
        <?php if (isset($message)) {
            echo "<p class='admin_result_message'>" . $message . "</p>";
        } ?>
    </div>
</body>
<footer class="logout_footer">
    <form action="." method="POST">
        <input type="submit" value="Logout">
        <input type="hidden" name="action" value="logout">
    </form>
</footer>

</html>