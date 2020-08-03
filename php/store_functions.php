<?php

function getAllBooksFromCategory($category) {
  $searchFor = htmlspecialchars($category);
  $result = getFromDatabase("products", $searchFor);

  echo "<table class='books-table'><tr><th>Title</th><th>Description</th><th>Price</th></tr>";
  foreach($result as $row) {
    //build table rows for each book in the query
    //I didn't know how to view a specific book cleanly, so I use a hidden form to send the details to the book functions
    echo "
    <tr>
    <td>
    <form method='post' action='../Single_Book.php'>
    <input type='hidden' name='BookTitle' value=\"".htmlspecialchars($row["product_name"]) ."\">
    <label><b>" .$row["product_name"] ."</b></label></br>
    <button type='submit'>View</button>
    </form>
    </td>
    <td>
    ".htmlspecialchars($row["product_description"])."
    </td>
    <td>
    £".$row["product_cost"]."
    </td>
    </tr>";
  }
  echo "</table>";
}

function getFromDatabase($table, $category) {
$data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");
  //Use a quote statement to prevent SQL Injection without Node.js
$queryCategory = $data_base->quote($category);
$query = "SELECT * FROM ". $table ." WHERE category = ".$queryCategory;

try {
  $rows = $data_base->query($query);
  $rowCount = $rows->rowCount();
  if($rowCount != 0){
  return $rows;
}
else {
  echo "<p>No Results Returned For: ". $category. "</p>";
  }
}catch(Exception $e) {
  echo "<p>(Error details: <?= $e->getMessage())</p>";
  return null;

  }
}
  ?>
