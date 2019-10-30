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
        <?php if (isset($validation_result)) {
            $count = 0;
            foreach ($validation_result as $error) {
                $count++;
            }
            echo $count;
        } ?>
        <form method="POST" autocomplete="off" action=".">
            <label>Username </label><input type="text" name="username" class="textbox"><br>
            <label>First Name </label><input type="text" name="first_name" class="textbox"><br>
            <label>Last Name </label><input type="text" name="last_name" class="textbox"><br>
            <label>Email Address </label><input type="text" name="email_address" class="textbox"><br>
            <label>Password </label><input type="password" name="password" class="textbox"><br>
            <input type='hidden' name="action" value="submit_registration">
            <br>
            <button type="submit">Register</button>
        </form>
        <br>
    </div>

</body>


</html>