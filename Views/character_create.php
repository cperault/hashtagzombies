<?php

/******************************************************************************************************************\
 *File:    character_create.php                                                                                    *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 13th, 2019                                                                                     *
 *Purpose: This is the view where the user can create their character for the first time after registering         *
\******************************************************************************************************************/
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>#ZOMBIES</title>
    <link href="styling.css" rel="stylesheet" type="text/css" />
    <script src="Models/JS/characterSelect.js"></script>
</head>

<body onload="hidePreviewDiv();">
    <div class="character_creation_container_div">
        <div class="character_creation_details_div">
            <span style="font-size:20px;font-weight:bold;">Choose your survivor:</span>
            <!--scrolling gridbox of vector/bitmap images can go here-->
            <div class="scrollable_avatar_selector">
                <div class="avatar_item"><img id="character_image" src="Media/character_one.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_two.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_three.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_four.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_five.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_six.png" onclick="updateImage(this)"></div>
            </div>
            <div id="selection_div">
                <span style="font-size:20px;font-weight:bold;">Name your survivor:</span>
                <input type="text" id="character_text" value="" />
                <input type="submit" value="Save" onclick="updateName()" />
            </div>
        </div>
        <div class="character_creation_preview_div">
            <span id="preview_text" style="font-size:20px;font-weight:bold;"></span>
            <div class="character_preview_display_div">
                <img id="character_selected">
            </div>
            <p id="character_name_chosen"></p>
            <div id="save_selected_character_input"></div>
        </div>

    </div>
    <footer class=" logout_footer">
        <form action="." method="POST">
            <input type="submit" value="Logout">
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Dashboard">
            <input type="hidden" name="action" value="dashboard">
        </form>
    </footer>
</body>

</html>