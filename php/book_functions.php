<?php

//variables to set
$productName = '';
$productDescription = '';
$productCost = '';
$productStock = '';
$productImageLocation = '';
$addedDate = '';
$category = '';
$result = '';

static $resultList = array();

function createIndex($product_name, $product_value) {
  $resultList[$product_name] = $product_value;
}

function buildBookPage($postValue) {
  global $productName;
  $productName = htmlspecialchars($postValue);
    setBookDetails();
    printBookDetails();
  }

function printBookDetails() {
  global $productName;
  global $productImageLocation;
  global $productDescription;
  global $productCost;
  global $productStock;
  global $addedDate;
  global $category;
 echo "
 <h2>$productName</h2></br>
 <img src='$productImageLocation' alt='$productName'/></br>
 <p><b>Description:</b></br>$productDescription</p>
 <p><b>Cost:</b></br>£$productCost</p>
 <p><b>In Stock:</b></br>$productStock</p>
 <p><b>Publish Date:</b></br>$addedDate</p>
 <p><b>Category:</b></br>$category</p>
 ";

 //Create the add to basket buttons
 if($productStock > 0) {
   echo "<form method='get' action='./php/cart_functions.php'></br>
         <input type='hidden' name='Book_Name' value=\"".htmlspecialchars($productName) ."\">
         <input type='hidden' name='Book_Value' value='$productCost'>
         <button type='button' onclick='javascript:history.back()''>Back</button>
         <button type='submit'>Add to Basket</button>
         </form>";
 }
 //If out of stock - print
 else{
   echo "<p><b>Sorry - This Product IS Out Of Stock</b></p></br>
   <button type='button' onclick='javascript:history.back()''>Back</button>
   ";
 }
}

function setBookDetails() {
  global $productName;
  global $productImageLocation;
  global $productDescription;
  global $productCost;
  global $productStock;
  global $addedDate;
  global $category;
  global $result;
  $result = getFromDatabase("products", $productName);
  foreach($result as $row) {
    $productDescription = $row["product_description"];
    $productCost = $row["product_cost"];
    $productStock = $row["product_stock"];
    $productImageLocation = $row["product_image_location"];
    $addedDate = $row["published_date"];
    $category = $row["category"];
  }
}

  function getFromDatabase ($table, $productName) {
    $data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");
      //Use a quote statement to prevent SQL Injection without Node.js
    $queryProduct = $data_base->quote($productName);
    $query = "SELECT * FROM $table WHERE product_name = ".$queryProduct;

    try {
      $rows = $data_base->query($query);
      $rowCount = $rows->rowCount();
      if($rowCount != 0){
      return $rows;
    }
    else {
      echo "<p>No Results Returned For: $productName</p>";
    }
  }catch(Exception $e) {
      echo "<p>(Error details: <?= $e->getMessage())</p>";
      return null;

  }
}
  ?>
