<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Book Detail</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/store_styles.css?v=1" rel="stylesheet" type="text/css" >
  <link href="./resources/css/generic_styles.css?v=1" rel="stylesheet" type="text/css" >
</head>
<body>
  <?php require "./php/book_functions.php";?>
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
      <h1>Details</h1>
    </header>

    <main>
      <!-- sections to promote books -->
      <section style="background-color: #ffe3fe;">
        <div class = "book-details">
          <?php
          //Display the individual book deatils
          if(!empty(trim($_POST["BookTitle"]))) {
            buildBookPage($_POST["BookTitle"]);
          }
            else {
              header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
          ?>
          </div>
        <!-- order button (if in stock) -->
      </section>
      <style>
        .book-details {
          text-align: center;
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
