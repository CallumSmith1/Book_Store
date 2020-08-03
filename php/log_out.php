  <html>
  <body>
  <?php
  if(isset($_COOKIE["name"])) {
    setcookie("name", "", time()-3600, "/");
  }
  if(isset($_COOKIE["access"])) {
    setcookie("access", "", time()-3600, "/");
  }
  if(isset($_COOKIE["university_id"])) {
    setcookie("university_id", "", time()-3600, "/");
  }
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  ?>
  </body>
  </html>
