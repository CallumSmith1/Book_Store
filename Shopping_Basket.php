<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Basket</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/shopping_basket_styles.css?v=1" rel="stylesheet" type="text/css">
  <link href="./resources/css/generic_styles.css?v=1" rel="stylesheet" type="text/css" >
</head>
<body>
  <?php
  include "./php/update_cart.php";
  ?>
  <!-- Page div -->
  <div class="body-div">
    <div>
      <nav class="main-nav">
          <a href="./index.php">Home</a>
          <a href="./Store.php">Store</a>
          <a href="./Staff_Page.php">Staff Zone</a>
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
    <header class="main-header">
      <h1>My Basket</h1>
    </header>
    <main>
      <?php
      if((!isset($_COOKIE['access']))) {
        header("Location: Login_Form.php");
          } ?>
      <div class="basket-container">
        <div class="basket">

          <?php
          if(isset($_POST['cart_product_add'])) {
            addOne($_POST['cart_product_add']);
          }
          if(isset($_POST['cart_product_remove'])) {
            removeOne($_POST['cart_product_remove']);
          }
          if(isset($_POST['cart_product_delete'])) {
            deleteAll($_POST['cart_product_delete']);
          }

          if(isset($_POST['order_submit'])) {
            placeOrder();
            echo "<script type='text/javascript'> alert(\"Order Placed\") </script>";
          }

            printUsersCart($_COOKIE["university_id"]);
          ?>

        </div>
      </div>
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
        button {
          width: 80px;
          height: 30px;
          float: right;
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
