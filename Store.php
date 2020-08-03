<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Store</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/store_styles.css?v=1" rel="stylesheet" type="text/css" >
  <link href="./resources/css/generic_styles.css?v=1" rel="stylesheet" type="text/css" >
</head>
<body>
  <?php require "./php/store_functions.php";?>
  <!-- Page div -->
  <div>
    <!-- This is the main nav bar containing all of the links (convert to dropdwown if time) -->
    <div>
      <nav class="main-nav">
          <a href="./index.php">Home</a>
          <a href="./Staff_Page.php">Staff Zone</a>
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
      <h1>Store</h1>
    </header>

    <main>
      <!-- sections to promote books -->
      <section style="background-color: #ffe3fe;">
        <!-- Remeber to add alt tags -->
        <div class="computing-block" id="computing" name="computing">
          <h2 class="genre-heading">Computing</h2>
          <div>
          <?php
          getAllBooksFromCategory("Computing");
          ?>
          </div>
        </div>
        <div class="business-block" id="business" name="business">
          <h2 class="genre-heading">Business</h2>
          <div>
          <?php
          getAllBooksFromCategory("Business");
          ?>
          </div>
        </div>
        <div class="languages-block" id="languages" name="languages">
          <h2 class="genre-heading">Languages</h2>
          <div>
          <?php
          getAllBooksFromCategory("Languages");
          ?>
          </div>
        </div>
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
      </style>
      </section>

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
