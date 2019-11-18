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
    <script src="characterSelect.js"></script>
    <div class="character_creation_container_div">
        <div class="character_creation_details_div">
            <span style="font-size:20px;font-weight:bold;">Choose your hero:</span>
            <!--scrolling gridbox of vector/bitmap images can go here-->
            <div class="scrollable_avatar_selector">
                <div class="avatar_item"><img id="character_image" src="Media/character_one.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_two.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_three.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_four.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_five.png" onclick="updateImage(this)"></div>
                <div class="avatar_item"><img id="character_image" src="Media/character_six.png" onclick="updateImage(this)"></div>
            </div>
            <span style="font-size:20px;font-weight:bold;">Name your hero:</span>
            <input type="text" id="character_text" value="" />
            <input type="submit" value="Save" onclick="updateName()" />
        </div>
        <div class="character_creation_preview_div">
            <span style="font-size:20px;font-weight:bold;">Preview:</span>
            <div class="character_preview_display_div">
                <img id="character_selected">
            </div>
            <p id="character_name_chosen"></p>
        </div>

    </div>
    <footer class="logout_footer">
        <form action="." method="POST">
            <input type="submit" value="Logout">
            <input type="hidden" name="action" value="logout">
        </form>
    </footer>
    <script>
        function updateImage(element) {
            //variable to store value of image src (which is the relative image file path)
            let name = "";
            //get src of the image clicked
            name = element.getAttribute("src");
            //add src of image clicked to the image element based on which character is selected
            imageElement = document.getElementById("character_selected");
            imageElement.setAttribute("src", name);
            nameLabel = document.getElementById("character_name_chosen");
        }

        function updateName() {
            //get text from the text field and remove whitespace
            let text = document.getElementById("character_text").value.trim();
            //get the name preview element
            let previewName = document.getElementById("character_name_chosen");
            //update the preview name
            previewName.innerText = text;
            //get text field element
            let textfield = document.getElementById("character_text");
            //clear the text from the text field element
            textfield.value = "";
        }
    </script>

    </html>