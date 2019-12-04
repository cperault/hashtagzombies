/* this file will be used to handle game state changes such as pausing and resuming */

//function to pause the game
function pauseGame() {
  //change value of btnGameState
  let gameStateButton = document.getElementById("btnGameState");
  gameStateButton.setAttribute("value", "Resume Game");
  gameStateButton.setAttribute("onclick", "resumeGame()");
  clearTimeout(gameArea.interval, 900000);
}

//function to resume the game
function resumeGame() {
  //check if modal is open, if it is, close it
  let modalContainer = document.getElementById("inventory_modal_container_div");
  if (modalContainer.style.display === "block") {
    modalContainer.style.display = "none";
  }
  //change value of btnGameState
  let gameStateButton = document.getElementById("btnGameState");
  gameStateButton.setAttribute("value", "Pause Game");
  gameStateButton.setAttribute("onclick", "pauseGame()");
  gameArea.interval = setInterval(updateGameArea, 20);
}
