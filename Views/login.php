<?php

/******************************************************************************************************************\
 *File:    login.php                                                                                               *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
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
            echo "<p class='thank_you_message'>" . $message . "</p>";
        } elseif (isset($login_result)) {
            echo "<p class='login_error'>" . $login_result . "</p>";
        } ?>
        <form method="POST" autocomplete="off" action=".">
            <label>Username </label><input type="text" name="username" class="textbox"><br>
            <label>Password </label><input type="password" name="password" class="textbox"><br>
            <input type='hidden' name="action" value="submit_login">
            <br>
            <button type="submit">Login</button>
        </form>
        <br>
        <div class="zombies_div_login_alternatives">
            <p class="zombies_div_login_separator">or login through</p>
            <p class="zombies_div_login_facebook">
                <img class="facebook_icon" alt="Facebook login icon" src="Media/facebook.png" height="30" width="30" />
                <img class="facebook_icon" alt="Facebook login icon" src="Media/google.jpg" height="30" width="30" />
                <p>Don't have Facebook or Google?</p>
                <form action="index.php" method="POST">
                    <input type="submit" value="Register using our form">
                    <input type="hidden" name="action" value="register">
                </form>
            </p>
        </div>
    </div>

</body>


</html>