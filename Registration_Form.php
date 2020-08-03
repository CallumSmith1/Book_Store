<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/registration_styles.css?v=1" rel="stylesheet" type="text/css">
  <link href="./resources/css/generic_styles.css?v=1" rel="stylesheet" type="text/css" >
</head>
<body>
  <!-- Page div -->
  <div class="body-div">
    <div>
      <nav class="main-nav">
          <a href="./index.php">Home</a>
          <a href="./Store.php">Store</a>
          <a href="./Staff_Page.php">Staff Zone</a>
          <a href="./Shopping_Basket.php">Basket</a>
      </nav>
    </div>

    <header class="main-header">
      <h1>Registration Form</h1>
    </header>
    <main>
    <!--Login Form -->
      <form class="registration-form" method="post" action="./php/registration_form_checker.php">

        <div class="registration-label">
          <label class="input-label"><b>Student ID: </b></label>
        </div>
        <div class="registration-details">
          <input class="input-box" type="text" placeholder="Enter Student ID" name="Username" required>
        </div>

        <div class="registration-label">
          <label class="input-label"><b>Name: </b></label>
        </div>
        <div class="registration-details">
          <input class="input-box" type="text" placeholder="Enter Your Name" name="Name" required>
        </div>

        <div class="registration-label">
          <label class="input-label"><b>Password: </b></label>
        </div>
        <div class="registration-details">
          <input class="input-box" type="password" placeholder="Enter Password" name="Password" required>
        </div>

        <div>
          <!--JS to navigate back to the previous page since I dont use _blank -->
          <button class="cancel-button" type="button" onclick="javascript:history.back()">Cancel</button>
          <button class="register-button" type="submit">Login</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
