<?php

$data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");
$total_cost = 00.00;
$total_quantity = 0;

//Prints out the cart database in table format
function printUsersCart($university_id) {
  global $data_base;
  $queryID = $data_base->quote($university_id);
  $query = "SELECT * FROM cart WHERE university_id = ".$university_id;
  try {
    $rows = $data_base->query($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while building the cart customer</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
  if($rows->rowCount() > 0) {
  echo "<table><tr><th>Title</th><th>Price</th><th>Quantity</th><th>Add</th><th>Remove</th><th>Delete</th></tr>";
  foreach($rows as $row) {
    global $total_cost;
    global $total_quantity;
    //Make sure that there is enough stock. If not delete from cart
    if($row["quantity"] <= 0) {
      deleteAll($row["product_name"]);
      header("Location: ../Shopping_Basket.php");
    }
    //Remove a book if the add will take it over the limit
    $stock = enoughProductStock($row["product_name"], $row["quantity"]);
    if($stock < $row["quantity"]) {
      removeOne($row["product_name"]);
      header("Location: ../Shopping_Basket.php");
      echo "<script type='text/javascript'>alert(\"Not enough stock\");</script>";
    }

    $total_quantity = $total_quantity + $row["quantity"];
    $total_cost = $total_cost + $row["cost"] * $total_quantity;
    echo "
    <tr>
    <td>
    ".$row["product_name"] ."
    </td>
    <td>
    £".$row["cost"]."
    </td>
    <td>
    ".$row["quantity"]."
    </td>
    <td>
    <form action='./Shopping_Basket.php' method='post'>
    <input type='hidden' name='cart_product_add' value=\"".$row['product_name']."\">
    <button type='submit' class='add' value='Add'>Add</button>
    </form>
    </td>
    <td>
    <form action='./Shopping_Basket.php' method='post'>
    <input type='hidden' name='cart_product_remove' value=\"".$row["product_name"] ."\">
    <button type='submit' class='remove' value='Remove'>Remove</button>
    </form>
    </td>
    <td>
    <form action='./Shopping_Basket.php' method='post'>
    <input type='hidden' name='cart_product_delete' value=\"".$row["product_name"] ."\">
    <button type='submit' class='delete' value='Delete'>Delete</button>
    </form>
    </td>
    </tr>";
    }
  echo "</table>
  <form action='./Shopping_Basket.php' method='post'>
  <h3>Total Quantity: ". $total_quantity . "</h3>
  <h3>Total Cost: £". $total_cost . "</h3>
  <input type='hidden' name='order_submit' value='1'>
  <button type='submit' class='submit_order' value='Submit_Order'>Place Order</button>
  </form>";
  }
  else {
    echo "<p><b>Cart is empty : <a href='./Store.php'>back to store</a></b></p>";
  }
}

//Adds one to the book quantity
function addOne($name_to_add) {
  global $data_base;
  $query_name = $data_base->quote($name_to_add);
  $query = "UPDATE cart SET quantity = quantity + 1, cost = (cost / (quantity - 1)) * quantity WHERE product_name=".$query_name. " AND university_id = ".$_COOKIE["university_id"];
  //TODO: Update Price
  try {
    $data_base->exec($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while adding quantity</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
}

//Removes a single entry
function removeOne($name_to_remove) {
  //TODO: Update Price
  global $data_base;
  $query_name = $data_base->quote($name_to_remove);
  $query = "UPDATE cart SET quantity = quantity - 1, cost = (cost / (quantity + 1)) * quantity WHERE product_name=".$query_name. " AND university_id = ".$_COOKIE["university_id"];
  try {
    $data_base->exec($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while lowering quantity</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
}

//Deletes the row
function deleteAll($name_to_remove)  {
    global $data_base;
    $query_name = $data_base->quote($name_to_remove);
    $query = "DELETE FROM cart WHERE product_name=".$query_name. " AND university_id = ".$_COOKIE["university_id"];
    try {
      $data_base->exec($query);
    }
    catch(Exception $e) {
      echo "<p>An error occurred while deleting entry</p>";
      echo "<p>(Error details: <?= $e->getMessage())</p>";
    }
}

function placeOrder()  {
    global $data_base;
    //transfer from cart to orders
    $transferQuery = "INSERT INTO orders SELECT * FROM cart WHERE university_id = ".$_COOKIE["university_id"];
    $deleteQuery = "DELETE FROM cart WHERE university_id = ".$_COOKIE["university_id"];
    //I probably shoud link the product id or something instead, but it's 1am
      $stockUpdate ="UPDATE products
INNER JOIN orders ON products.product_name = orders.product_name
SET products.product_stock = (products.product_stock - orders.quantity)
WHERE orders.product_name = products.product_name AND orders.university_id = ".$_COOKIE["university_id"];
    try {
      $data_base->exec($transferQuery);
      $data_base->exec($deleteQuery);
      $data_base->exec($stockUpdate);
    }
    catch(Exception $e) {
      echo "<p>An error occurred while transfering orders</p>";
      echo "<p>(Error details: <?= $e->getMessage())</p>";
    }
}

//TODO: Make sure that I am using this to check order values when
//A function to check the stock of the product against a provided quantity
function enoughProductStock($name_to_check, $value_to_compare)  {
    global $data_base;
    $query_name = $data_base->quote($name_to_check);
    $query = "SELECT product_stock FROM products WHERE product_name=".$query_name;

    try {
      $stock = $data_base->query($query);
    }
    catch(Exception $e) {
      echo "<p>An error occurred while getting the product_stock</p>";
      echo "<p>(Error details: <?= $e->getMessage())</p>";
    }
    $value = $stock -> fetch();
    return $value["product_stock"];
}

?>
