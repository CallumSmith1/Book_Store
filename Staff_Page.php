<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Staff Zone</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/staff_styles.css?v=1" rel="stylesheet" type="text/css" >
  <link href="./resources/css/generic_styles.css?v=1" rel="stylesheet" type="text/css" >
  <?php
  if((!isset($_COOKIE['access'])) || (isset($_COOKIE['access']) && !$_COOKIE['access']== "1")) {
  header("Location: ../Login_Form.php");
      } ?>
</head>
<body>
  <?php
  include "./php/staff_functions.php";
  ?>
  <!-- Page div -->
  <div>
    <!-- This is the main nav bar containing all of the links (convert to dropdwown if time) -->
    <div>
      <nav class="main-nav">
          <a href="./index.php">Home</a>
          <a href="./Store.php">Store</a>
          <a href="./Shopping_Basket.php">Basket</a>
          <a href="./Login_Form.php">Login</a>
      </nav>
    </div>
    <div class = "login-info">
      <p class = "user-details">
        <?php
        if(isset($_COOKIE["name"])) {
          $user= $_COOKIE["name"];
          echo "Logged in as: $user \n";
        } else {
        echo "Log in: <a href=./Login_Form.php>Login</a>";
      }
        ?>
        <a class="sign-out" href="./php/log_out.php">Sign Out</a>
      </p>
    </div>
    <!-- Header section. This is styles with an image in the css -->
    <header class="main-header">
      <h1>Staff Zone</h1>
    </header>

    <main>
      <section>
        <!-- Section containing the abililty to add books -->
        <div>
          <h2>Add a New Book</h2>
          <form class="upload-form" enctype="multipart/form-data" method="post" action="./Staff_Page.php">
            <!-- product ID -->
            <div class="registration-label">
              <label class="input-label"><b>Product ID</b></label>
            </div>
            <div class="registration-details">
              <input class="input-box" type="number" min="0"step="1" placeholder="Unique Product ID" name="new_product_id" required>
            </div>
              <!-- Book Name -->
            <div class="registration-label">
              <label class="input-label"><b>Book Title</b></label>
            </div>
            <div class="registration-details">
              <input class="input-box" type="text" placeholder="Book Title" name="new_product_name" required>
            </div>
              <!-- Description -->
            <div class="registration-label">
              <label class="input-label"><b>Book Description</b></label>
            </div>
            <div class="registration-details">
              <input style="overflow:scroll;"class="input-box" type="text" placeholder="Book Description" name="new_product_desc" required>
            </div>
              <!-- Publish Date -->
            <div class="registration-label">
              <label class="input-label"><b>Publish Date</b></label>
            </div>
            <div class="registration-details">
              <input class="input-box" type="date" min="1900-01-01" max="2100-12-31" name="new_product_date" required>
            </div>
              <!-- Product Cost -->
            <div class="registration-label">
              <label class="input-label"><b>Product Price</b></label>
            </div>
            <div class="registration-details">
              <input class="input-box" type="text" placeholder="Cost of product as: 00.00" name="new_product_cost" required>
            </div>
            <!-- Product Stock -->
          <div class="registration-label">
            <label class="input-label"><b>Product Stock</b></label>
          </div>
          <div class="registration-details">
            <input class="input-box" type="number" min="0"step="1" placeholder="Stock of this product" name="new_product_stock" required>
          </div>
          <!-- Product Category -->
          <div class="registration-label">
            <label class="input-label"><b>Category</b></label>
          </div>
          <div class="registration-details">
            <select name="new_product_category">
              <option value="Computing">Computing</option>
              <option value="Business">Business</option>
              <option value="Languages">Languages</option>
            </select>
          </div>
            <!-- Cover image uplaod -->
          <div class="registration-label">
            <label class="input-label"><b>Upload Cover Image</b></label>
          </div>
          <div class="registration-details">
            <input class="input-box" type="file" name="new_product_image" required>
          </div>
          <button style="float:right; width: auto; margin-right: 20px; margin-bottom: 20px;" name="rest" type="reset">Cancel</button>
          <button style="float:right; width: auto; margin-right: 20px; margin-bottom: 20px;" name="create" type="submit">Add Book</button>
        </form>
        <?php
        //If one is set, assume all are (because of the "require")
        if(isset($_POST["new_product_id"])) {
          //validate the cost format
          if(validateAgainstRegex('/^(?=.*[0-9])\d{1,4}(?:\.\d{2})?$/', $_POST["new_product_cost"]))  {
            if(!duplicateProductId($_POST["new_product_id"])) {
              if($_FILES["new_product_image"]["size"] > 20000) {
              $data_base = getDatabase();
              $image = $_FILES["new_product_image"]["name"];
              //convert the date since html only allows dd/mm/yyyy
              $toConvert = strtotime($_POST["new_product_date"]);
              $converted = date("Y-m-d", $toConvert);

              if(isImage($image)) {
              //Do this here so that I don't have to pass monumental numbers of params.
              //I don't know how to use an inner class in php, and don't have time to research,
              //so I cannot use that. I will pass the query results instead - this will stop
              //the main file becoming ane even more gargantuan monstrosity
              $queryId = $data_base->quote(htmlspecialchars($_POST["new_product_id"]));
              $queryName = $data_base->quote(htmlspecialchars($_POST["new_product_name"]));
              $queryDesc = $data_base->quote(htmlspecialchars($_POST["new_product_desc"]));
              $queryDate = $data_base->quote(htmlspecialchars($converted));
              $queryCost = $data_base->quote(htmlspecialchars($_POST["new_product_cost"]));
              $queryStock = $data_base->quote(htmlspecialchars($_POST["new_product_stock"]));
              $queryCategory = $data_base->quote(htmlspecialchars($_POST["new_product_category"]));
              $queryImageName = $data_base->quote(htmlspecialchars(uploadImageAndReturnName($image, $_FILES["new_product_image"]["tmp_name"])));

              $query = "INSERT INTO products (product_name, product_description, product_id, product_cost, product_stock, product_image_location, published_date, category)
              VALUES ($queryName, $queryDesc, $queryId, $queryCost, $queryStock, $queryImageName, $queryDate, $queryCategory)";
              try {
                $data_base->exec($query);
              }
              catch(Exception $e) {
                echo "<p>An error occurred while lowering quantity</p>";
                echo "<p>(Error details: <?= $e->getMessage())</p>";
                  }
              echo "<script type='text/javascript'> alert(\"Submitted Successfully!\") </script>";
                }
              }
            }
          }
          else {
            echo "<script type='text/javascript'> alert(\"Failed To Submit: Please re-enter, using a valid cost or date format\") </script>";
          }
        }
         ?>
        </div>
        <!-- Section containing the abililty to increase pproduct stock -->
        <div class="staff-block">
          <h2>Increase Stock</h2>
          <form action='./Staff_Page.php' method='post'>
          <input name="book-name" class='search-bar' placeholder="Search for the name of a book">
          <button type='submit' class='options-button' value='Search'>Search</button>
          </form>
          <?php
            if(isset($_POST["book-name"])) {
              searchBookInDataBase($_POST["book-name"]);
            }
            if(isset($_POST["amount"]) && isset($_POST["name"])) {
            updateBookQuantity($_POST["name"], $_POST["amount"]);
            echo "<script type='text/javascript'> alert(\"Updated Quantity\") </script>";
          }
          ?>
        </div>
        <!-- Section containing the abililty to view all of the databse's orders as a table -->
        <div class="staff-block">
          <h2>View All Orders</h2>
          <form action='./Staff_Page.php' method='post'>
          <input type="hidden" name="view-orders" value="yes">
          <button type='submit' class='options-button' value='View'>Show All Orders</button>
          </form>
          <?php
            if(isset($_POST["view-orders"])) {
              createOrderTable();
            }
          ?>
        </div>
      </section>
      <!-- I had to do this because the CSS wasn't styling the page. I guess because of waterfall reading(?)-->
      <style>
        table {
        justify-content: center;
        overflow-x: auto;
        overflow-y: auto;
        width: 100%;
        background-color: #dbdbdb;
              }
       th {
         background-color: #555;
         color: white;
       }

       table, th, td {
        border: 1px solid black;
                      }
       td, th {
        width: 33%;
        height: auto;
              }
        h3 {
          text-align: right;
        }
    </style>
    </main>
    <footer>
      <div class="media">
        <ul>
        <!-- Style this list using icons to make it neat -->
          <li><a href="http://twitter.com" target="_blank" class="social-media twitter">Twitter</a></li>
          <li><a href="http://facebook.com" target="_blank" class="social-media facebook">Facebook</a></li>
          <li><a href="http://instagram.com" target="_blank" class="social-media instagram">Instagram</a></li>
        </ul>
      </div>
    </footer>
  </div>
</body>
</html>
