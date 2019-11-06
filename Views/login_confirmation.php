<?php

/******************************************************************************************************************\
 *File:    login_confirmation.php                                                                                  *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 6th, 2019                                                                                      *
 *Purpose: This is the main login page.                                                                            *
\******************************************************************************************************************/
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>#ZOMBIES</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <h1 class="zombies_header_login"><img src="Media/logo.jpeg" alt="Zombies bloody logo in all caps" height="150" width="500" /></h1>
    </header>
    <div class="zombies_div_login">
        <?php if (isset($message)) {
            if (isset($resend)) {
                echo "<p class='login_error'>" . $message . "</p>";
                echo "<div class='div_code_resend'>";
                echo "<form action='.' method='POST'>";
                echo "<input type='submit' value='Resend verification code'>";
                echo "<input type='hidden' name='action' value='resend_verification_code'>";
                echo "</form>";
                echo "</div><br/>";
            } else {
                echo "<p class='thank_you_message'>" . $message . "</p>";
            }
        } ?>
        <form method="POST" autocomplete="off" action=".">
            <label for="username">Username </label>
            <input type="text" name="username" class="textbox"><br>
            <label for="password">Verification Code </label>
            <input type="password" name="confirmation_code" class="textbox"><br>
            <input type='hidden' name="action" value="confirm_registration">
            <br>
            <input type="submit" value="Confirm registration">
        </form>
        <br>
    </div>
</body>


</html>