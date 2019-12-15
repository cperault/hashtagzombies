/* this file will handle all inventory actions in JS*/

function viewInventory() {
  //change modal display from `none` to `block` to display
  //get the modal container element
  let modalContainer = (document.getElementById(
    "inventory_modal_container_div"
  ).style.display = "block");
  pauseGame();
}

//function to close modal
function closeInventory() {
  //change modal display from `block` to `none` to close it
  let modalContainer = (document.getElementById(
    "inventory_modal_container_div"
  ).style.display = "none");
  resumeGame();
}

//function to use item in inventory
//param @id is used to apply item to gameplay whether it's increasing weapon damage,
//      health, or energy and also gets passed to `discardItem()` method after
//      applying item effect
//param @category will be ued to determine how to use the item
function useItem(id, category) {
  //variable to store which type of item is being used
  let item_type = "";
  //categories: 1, 2, 3 => 1 = weapon, 2 = energy, 3 = health
  switch (category) {
    case 1:
      item_type = "weapon";
      break;
    case 2:
      item_type = "energy";
      break;
    case 3:
      item_type = "health";
      //check health, if health is less than
      break;
  }
  console.log("using item ID " + id + " which is a(n) " + item_type + " item");
  //update the quantity in the DB when a user uses their item by calling our `discardItem()` method below
  discardItem(id);
}

//function to discard item in inventory
function discardItem(item) {
  let count = document.getElementById(`item_qty_value_${item}`).innerText;
  //user cannot discard item if qty less than or equal to zero
  if (count >= 1) {
    console.log("Discarding item: " + item);
    let url = "/discard_inventory_item";
    let method = "post";
    //set up request parameters
    let params = { action: "discard", itemID: item };
    axios({
      method: method,
      url: url,
      data: params,
      headers: {
        Host: "https://hashtagzombies.herokuapp.com",
        Accept: "application/json",
        "Content-Type": "application/json"
      },
      withCredentials: true,
      credentials: "same-origin"
    }).then(response => {
      //update the quantity value
      document.getElementById(`item_qty_value_${item}`).innerText =
        response.data.new_value;
    });
  }
  //else, do nothing
}
