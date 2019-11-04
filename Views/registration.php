<?php

/******************************************************************************************************************\
 *File:    registration.php                                                                                       *
 *Project: #ZOMBIES                                                                                               *
 *Date:    October 27th, 2019                                                                                     *
 *Purpose: This is the registration page through which a player can register if they don't have FB or Google      *
\******************************************************************************************************************/
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <h1 class="zombies_header_registration"><img src="Media/logo.jpeg" alt="Zombies bloody logo in all caps" height="150" width="500" /></h1>
    </header>
    <div class="zombies_div_registration">
        <form method="POST" autocomplete="off" action=".">
            <label>Username</label>
            <input type="text" name="username" class="textbox" <?php if (isset($username)) {
                                                                    echo "value='$username'";
                                                                } ?>><br>
            <label>First Name</label>
            <input type="text" name="first_name" class="textbox" <?php if (isset($first_name)) {
                                                                        echo "value='$first_name'";
                                                                    } ?>><br>
            <label>Last Name</label>
            <input type="text" name="last_name" class="textbox" <?php if (isset($last_name)) {
                                                                    echo "value='$last_name'";
                                                                } ?>><br>
            <label>Email Address</label>
            <input type="text" name="email_address" class="textbox" <?php if (isset($email_address)) {
                                                                        echo "value='$email_address'";
                                                                    } ?>><br>
            <label>Password</label>
            <input type="password" name="password" class="textbox" <?php if (isset($password)) {
                                                                        echo "value='$password'";
                                                                    } ?>><br>
            <label>Invite Code</label>
            <input type="text" name="invite_code" class="textbox">
            <input type='hidden' name="action" value="submit_registration">
            <br>
            <button type="submit">Register</button>
        </form>
        <br>
        <?php if (isset($validation_result)) {
            if (count($validation_result) > 1) {
                echo "<p class='error_text_header'>" . "Please correct the following errors: " . "</p>";
            } else {
                echo "<p class='error_text_header'>" . "Please correct the following error: " . "</p>";
            }
            foreach ($validation_result as $error) {
                echo "<p class='error_text'>" . $error . "</p>";
            }
        } elseif (isset($no_invite)) {
            echo "<p class='invite_code_invalid'>" . $no_invite . "</p>";
        } ?>
    </div>

</body>


</html>