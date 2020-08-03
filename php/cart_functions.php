<html>
<body>
<?php

$data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");

if(!empty(trim($_GET["Book_Name"])) && !empty(trim($_GET["Book_Value"]))) {
  $name = htmlspecialchars($_GET["Book_Name"]);
  $cost = htmlspecialchars($_GET["Book_Value"]);
  if(isset($_COOKIE["university_id"])) {
    $university_id = $_COOKIE["university_id"];
  }
  else {
    header("Location: ../Login_Form.php");
    }
  addToCart($name, $cost, $university_id);
  header("Location: ../Shopping_Basket.php");
}
else {
  header("Location: ../Store.php");
  }

function addToCart($name, $cost, $university_id) {
  global $data_base;
  $queryName = $data_base->quote($name);
  $queryCost = $data_base->quote($cost);
  $queryID = $data_base->quote($university_id);
  $query = "INSERT INTO cart (university_id, product_name, cost, quantity) VALUES ($queryID, $queryName, $queryCost, 1)";
  try {
    $data_base->exec($query);
  }
  catch(Exception $e) {
    echo "<p>An error occurred while adding a product to the cart</p>";
    echo "<p>(Error details: <?= $e->getMessage())</p>";
  }
}

 ?>
 </html>
</body>
