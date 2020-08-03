  <html>
  <body>
  <?php

  if(!empty(trim($_POST["Username"])) && !empty(trim($_POST["Name"])) && !empty(trim($_POST["Password"]))) {
    $username = $_POST["Username"];
    $name = $_POST["Name"];
    $password = $_POST["Password"];
  }
    else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //To remove the XSS
    $username = htmlspecialchars($username);
    $name = htmlspecialchars($name);
    $password = htmlspecialchars($password);

    //Hash Password
    $password = hash("md5", $password);

    //Insert into table
    uploadUserCreds($username, $name, $password);
    setCookies($name, "0", $username);

  function uploadUserCreds($username, $name, $password) {
    $data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");
    //Use a quote statement to prevent SQL Injection without Node.js
  $queryUsername = $data_base->quote($username);
  $queryName = $data_base->quote($name);
  $queryPassword = $data_base->quote($password);
  $query = "INSERT INTO users (university_id, name, password, access) VALUES ($queryUsername, $queryName, $queryPassword, 0)";

    try {
      $data_base->exec($query);
    }
    catch(Exception $e) {
      echo "<p>An error occurred while registering customer</p>";
      echo "<p>(Error details: <?= $e->getMessage())</p>";
    }
  }

//set the authentication
  function setCookies($username, $accessLevel, $university_id) {
    if(isset($_COOKIE["name"])) {
      setcookie("name", "", time()-3600, "/");
    }
    if(isset($_COOKIE["access"])) {
      setcookie("access", "", time()-3600, "/");
    }
    if(isset($_COOKIE["university_id"])) {
      setcookie("university_id", "", time()-3600, "/");
    }
    setCookie("name", $username, 0, "/");
    setCookie("access", $accessLevel, 0, '/');
    setCookie("university_id", $university_id, 0, '/');
    header("Location: ../index.php");
  }

  ?>
  </body>
  </html>
