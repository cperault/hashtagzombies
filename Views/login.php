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

<body class="login_body">
    <header>
        <h1 class="zombies_header_login"><img src="Media/logo.jpeg" alt="Zombies bloody logo in all caps" height="150" width="500" /></h1>
    </header>
    <div class="zombies_div_login">
        <form method="POST" autocomplete="off" action=".">
            <label for="username">Username </label>
            <input type="text" name="username" class="textbox" <?php if (isset($username)) {
                                                                    echo "value='$username'";
                                                                } ?>><br>
            <label for="password">Password </label>
            <input type="password" name="password" class="textbox" <?php if (isset($password)) {
                                                                        echo "value='$password'";
                                                                    } ?>><br>
            <input type='hidden' name="action" value="submit_login">
            <br>
            <button type="submit">Login</button>
        </form>
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