<?php

$data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");

//This displays a table for the user's search
//Following this, they will be presented with a list of "like" books
//From this they can call the update function after setting a value
function searchBookInDataBase($name_to_search) {
  global $data_base;
  global $lastBookName;
  $name_to_search = htmlspecialchars($name_to_search);

  $queryName = $data_base->quote("%".$name_to_search."%");
  $query = "SELECT product_id, product_name, product_stock FROM products WHERE product_name LIKE $queryName";
  try {
    $rows = $data_base->query($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while building the order table</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
  if($rows->rowCount() > 0) {
    echo "<table><tr><th>Product ID</th><th>Product Name</th><th>Quantity</th><th>Amount To Add</th></tr>";
  foreach($rows as $row) {
    echo "
    <tr>
    <td>
    ".$row["product_id"] ."
    </td>
    <td>
    ".$row["product_name"]."
    </td>
    <td>
    ".$row["product_stock"]."
    </td>
    <td>
    <form action='./Staff_Page.php' method='post'>
    <input type='number' min='0'step='1' name='amount' placeholder='Enter Amount'>
    <input name='name' type='hidden' value=\"".$row["product_name"] ."\">
    <button type='submit' class='options-button' value='Update'>Update</button>
    </form>
    </td>
    </tr>";
    }
  echo "</table>";
  }
  else {
    echo "<p><b>No results found for: ".$name_to_search ."</b></p>";
  }
}

//Increases the product stock by the parameter amount
function updateBookQuantity($name, $quantity) {
  global $data_base;

  $name = htmlspecialchars($name);
  $quantity = htmlspecialchars($quantity);

  $queryName = $data_base->quote($name);
  $queryQuantity = $data_base->quote($quantity);

  $query = "UPDATE products SET product_stock = product_stock + " .$queryQuantity. " WHERE product_name=".$queryName;
  try {
    $rows = $data_base->exec($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while building the order table</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
}



//Creates a table of all orders
function createOrderTable() {
  global $data_base;
  $query = "SELECT * FROM orders";
  try {
    $rows = $data_base->query($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while building the order table</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }

  if($rows->rowCount() > 0) {
  echo "<table><tr><th>University ID</th><th>Product Name</th><th>Cost</th><th>Order Quantity</th></tr>";
  foreach($rows as $row) {
    echo "
    <tr>
    <td>
    ".$row["university_id"] ."
    </td>
    <td>
    ".$row["product_name"]."
    </td>
    <td>
    £".$row["cost"]."
    </td>
    <td>
    ".$row["quantity"]."
    </td>
    </tr>";
    }
  echo "</table>";
  }
  else {
    echo "<p><b>No orders to show</b></p>";
  }
}

//This takes a regex as a parameter and validates against a value
function validateAgainstRegex($regex, $valueToCheck) {
    return preg_match($regex, $valueToCheck);
}

//checks product ID to see if it is a duplicate
//If it isn't, return false
//If it is, return true + print the highest value
function duplicateProductId($idToCheck) {
  global $data_base;

  $idToCheck = htmlspecialchars($idToCheck);
  $queryId = $data_base->quote($idToCheck);

  $query = "SELECT product_id FROM products WHERE product_id = ".$queryId;
  try {
    $rows = $data_base->query($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while searching for the ID</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
  if($rows->rowCount() == 0) {
    return false;
  }
  else{
    $query = "SELECT product_id FROM products ORDER BY product_id DESC limit 1";
    try {
    $rows = $data_base->query($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while searching for the ID</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
  $value = $rows -> fetch();
  $value = $value["product_id"];
  echo "<script type='text/javascript'> alert(\"Failed To Submit: Please use a unique id. Last added was: ".$value."\") </script>";
  return true;
  }
}

function getDatabase() {
  global $data_base;
  return $data_base;
}

function isImage($imageFile) {
  $fileType = strtolower(
    pathinfo(
      basename($imageFile),
      PATHINFO_EXTENSION)
    );
    if($fileType != "jpg" &&
       $fileType != "png" &&
       $fileType != "jpeg"&&
       $fileType != "gif") {
         return false;
       }
    else {
         return true;
       }

}

function uploadImageAndReturnName($imageName, $imageLocation) {
  $uploadDir = "./resources/images/Book_Images/";
  $filePath = $uploadDir . basename($imageName);
 //Make sure that there can't be duplicate entries
  if (file_exists($filePath)) {
    echo "<script type='text/javascript'> alert(\"Failed To Submit: File already exists) </script>";
    header("Location: ../Staff_Page.php");
  }
  else {
    try {
      move_uploaded_file($imageLocation, $filePath);
      return $filePath;
    }
    catch(Exception $e) {
      echo "<p>An error occurred while uploading the file</p>";
      echo "<p>(Error details: <?= $e->getMessage())</p>";
    }
  }
}



?>
