let characterName = "";
let characterImage = "";

function hidePreviewDiv() {
  //hide image element outline until user has chosen their survivor
  let previewDiv = (document.getElementById("character_selected").className =
    "hidden");
}

function updateImage(element) {
  //unhide the image element
  document.getElementById("character_selected").removeAttribute("class");
  //variable to store value of image src (which is the relative image file path)
  let name = element.getAttribute("src");
  //update global variable to keep track of which image to load
  characterImage = name;
  //add src of image clicked to the image element based on which character is selected
  let imageElement = document.getElementById("character_selected");
  //get preview text element (paragraph #preview_text)
  let previewHeaderText = document.getElementById("preview_text");
  //check if innerText already set to avoid unnecessary re-rendering
  if (previewHeaderText.innerText !== "Preview:") {
    //add the label text
    previewHeaderText.innerText = "Preview:";
  }

  imageElement.setAttribute("src", name);
  imageElement.style.cssText = "border: 2px solid lightgray";
}

function updateName() {
  if (document.getElementById("character_selected").className === "hidden") {
    alert("Please select a survivor before choosing their name.");
  } else if (document.getElementById("character_text").value === "") {
    alert("Please enter a name for your survivor.");
  } else {
    //get text from the text field and remove whitespace
    let text = document.getElementById("character_text").value.trim();
    //update the global variable for character's name
    characterName = text;
    //update the preview label
    document.getElementById("character_name_chosen").innerText = text;
    //clear the text from the text field element
    document.getElementById("character_text").value = "";
    //remove the "name your survivor" input area
    document.getElementById("selection_div").className = "hidden";
    //create the form for the final save button
    let form = document.createElement("form");
    form.setAttribute("action", ".");
    form.setAttribute("method", "POST");
    //create the save buttoon
    let saveButton = document.createElement("input");
    saveButton.setAttribute("type", "submit");
    saveButton.setAttribute("value", "Save character");
    //create the hidden input for the submit button to send to the controller
    let saveButtonHidden = document.createElement("input");
    saveButtonHidden.setAttribute("type", "hidden");
    saveButtonHidden.setAttribute("name", "action");
    saveButtonHidden.setAttribute("value", "save_character");
    //create the hidden data to send in POST request
    let characterNameInput = document.createElement("input");
    characterNameInput.setAttribute("type", "hidden");
    characterNameInput.setAttribute("name", "character_name");
    characterNameInput.setAttribute("value", characterName);

    let characterImageInput = document.createElement("input");
    characterImageInput.setAttribute("type", "hidden");
    characterImageInput.setAttribute("name", "character_image");
    characterImageInput.setAttribute("value", characterImage);

    //add the input to the form element
    form.appendChild(saveButton);
    form.appendChild(saveButtonHidden);
    form.appendChild(characterNameInput);
    form.appendChild(characterImageInput);
    //put it all together now
    document.getElementById("save_selected_character_input").appendChild(form);
  }
}
