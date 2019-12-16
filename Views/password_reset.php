<?php

/******************************************************************************************************************\
 *File:    password_reset.php                                                                                      *
 *Project: #ZOMBIES                                                                                                *
 *Date:    December 15th, 2019                                                                                     *
 *Purpose: This is the password reset page.                                                                        *
\******************************************************************************************************************/
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>#ZOMBIES</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
</head>

<body class="login_body">
    <header>
        <h1 class="zombies_header_login"><img src="Media/logo.jpeg" alt="Zombies bloody logo in all caps" height="150" width="500" /></h1>
    </header>
    <div class="zombies_div_login">
        <?php if (isset($has_reset_secret)) {
            echo "<h5>Please enter a new password and provide the secret hash you received</h5>";
            echo "<form method='POST' autocomplete='off' action='.'>";
            echo "<label for='new_password'>New password</label>";
            echo "<input type='password' name='new_password' class='textbox'>";
            echo "<br/>";
            echo "<label for='reset_secret'>Secret hash</label>";
            echo "<input type='password' name='reset_secret' class='textbox'>";
            echo "<br/>";
            echo "<input type='hidden' name='action' value='confirm_password_resubmit'>";
            echo "<input type='submit' value='Reset'>";
            echo "</form>";
        } else {
            echo "<h5>Please enter the username for which you're needing to reset your password</h5>";
            echo "<form method='POST' autocomplete='off' action='.'>";
            echo "<label for='username'>Username</label>";
            echo "<input type='text' name='username' class='textbox'>";
            echo "<br/>";
            echo "<input type='hidden' name='action' value='submit_password_reset'>";
            echo "<input id='password_reset_button' type='submit' value='Submit password reset'>";
            echo "</form>";
        } ?>
        <br>
        <?php if (isset($validation_result) && !empty($validation_result)) {
            if (count($validation_result) > 1) {
                echo "<p class='error_text_header'>" . "Please correct the following errors: " . "</p>";
            } else {
                echo "<p class='error_text_header'>" . "Please correct the following error: " . "</p>";
            }
            foreach ($validation_result as $validation_error) {
                echo "<p class='error_text'>" . $validation_error . "</p>";
            }
        } elseif (isset($message)) {
            echo "<p class='thank_you_message'>" . $message . "</p>";
        } elseif (isset($login_result)) {
            echo "<p class='login_error'>" . $login_result . "</p>";
        } ?>
    </div>
</body>


</html>