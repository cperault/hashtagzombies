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

//function to be called when an inventory item is picked up during gameplay
function pickupInventoryItem(item, value) {
  //initial item ID value
  inventoryToIncrement = 0;
  switch (item) {
    case "med":
      //get value of the med
      let medicineValue = value;
      if (medicineValue === 20) {
        //item is aspirin
        inventoryToIncrement = 12; //item_id in inventory table for aspirin is 12
      } else if (medicineValue === 50) {
        //item is a first aid kit
        inventoryToIncrement = 13; //item_id in inventory table for first aid kit is 13
      }
      //add med to inventory
      let url = "/add_picked_up_item";
      let method = "post";
      //set up request parameters
      let params = { itemID: inventoryToIncrement };
      axios({
        method: method,
        url: url,
        data: params,
        headers: {
          "Content-Type": "application/json"
        },
        withCredentials: true,
        credentials: "same-origin"
      }).then(response => {
        // //update the inventory item quantity value
        let key = response.data.incremented_item;
        document.getElementById(`item_qty_value_${key}`).innerText =
          response.data.new_value;
      });
  }
}

//function to use item in inventory
//param @id is used to apply item to gameplay whether it's increasing weapon damage,
//      health, or energy and also gets passed to `discardItem()` method after
//      applying item effect
//param @category will be used to determine how to use the item
function useItem(id, category, description) {
  //variable to store which type of item is being used
  let item_type = "";
  //categories: 1, 2  => 1 = weapon, 2 = health
  switch (category) {
    case 1:
      item_type = "weapon";
      break;
    case 2:
      item_type = "health";
      //get health increment value of item
      let itemValue = parseInt(description);
      let health = document.getElementById("healthText");
      let healthStatus = health.innerText;
      let healthParts = healthStatus.split("/");
      //the current health will be healthParts[0] and total health is healthParts[1]
      let currentHealth = parseInt(healthParts[0]);
      let maxHealth = 100;
      //add health to current health
      let updatedHealth = currentHealth + itemValue;
      //make sure health doesn't exceed max
      if (updatedHealth > 100) {
        updatedHealth = 100;
      }
      //update health text based on result of using the item
      let newHealthLevel = updatedHealth + "/" + maxHealth;
      health.innerText = newHealthLevel;
      break;
  }
  //update the quantity in the DB when a user uses their item by calling our `discardItem()` method below
  discardItem(id);
}

//function to discard item in inventory
function discardItem(item) {
  let count = document.getElementById(`item_qty_value_${item}`).innerText;
  //user cannot discard item if qty less than or equal to zero
  if (count >= 1) {
    let url = "/discard_inventory_item";
    let method = "post";
    //set up request parameters
    let params = { itemID: item };
    axios({
      method: method,
      url: url,
      data: params,
      headers: {
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
