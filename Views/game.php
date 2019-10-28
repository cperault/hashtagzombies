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
</head>

<body>
    <div class="zombies_body_gameplay_container">
        <p class="center_text">This is the gameplay view.</p>
    </div>
    <footer class="logout_footer">
        <form action="." method="POST">
            <input type="submit" value="Logout">
            <input type="hidden" name="action" value="logout">
        </form>
    </footer>
</body>


</html>