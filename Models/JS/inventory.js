/* this file will handle all inventory actions in JS*/

function viewInventory() {
  //change modal display from `none` to `block` to display
  //get the modal container element
  let modalContainer = (document.getElementById(
    "inventory_modal_container_div"
  ).style.display = "block");
}

//function to close modal
function closeInventory() {
  //change modal display from `block` to `none` to close it
  let modalContainer = (document.getElementById(
    "inventory_modal_container_div"
  ).style.display = "none");
}
