  <html>
  <body>
  <?php

  if(!empty(trim($_POST["Username"])) && !empty(trim($_POST["Password"]))) {
    $username = $_POST["Username"];
    $password = $_POST["Password"];
  }
    else {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //To remove the XSS
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    //Hash Password
    $password = hash("md5", $password);

    $result = checkUserCreds($username, $password);
    foreach ($result as $row) {
      setCookies($row["name"], $row["access"], $username);
      header("Location: ../Store.php");
  }

  function checkUserCreds($username, $password) {
    $data_base = new PDO("mysql:mysql:host=180210017.cs2410-web01pvm.aston.ac.uk;dbname=u_180210017_aston_book_store", "u-180210017", "Oa3tKeQFzVfxoBu");
    //Use a quote statement to prevent SQL Injection without Node.js
  $queryUsername = $data_base->quote($username);
  $queryPassword = $data_base->quote($password);
  $query = "SELECT * FROM users WHERE university_id=".$queryUsername ."AND password=". $queryPassword;

    try {
      $rows = $data_base->query($query);
      $rowCount = $rows->rowCount();
      if($rowCount != 0){
      return $rows;
    }
    else {
      echo "<p>Invalid user credentials</p>";
    }
    }
    catch(Exception $e) {
      return null;
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
  }

  ?>
  </body>
  </html>
