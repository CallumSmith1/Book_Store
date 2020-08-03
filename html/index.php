<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Home</title>
  <!-- This didn't work with {{asset(css/styles.css)}} etc -->
  <link href="./resources/css/home_styles.css" rel="stylesheet" type="text/css" >
  <link href="./resources/css/generic_styles.css" rel="stylesheet" type="text/css" >
</head>
<body>
  <!-- Page div -->
  <div>
    <!-- This is the main nav bar containing all of the links (convert to dropdwown if time) -->
    <div>
      <nav class="main-nav">
          <a href="./Store.php">Store</a>
          <a href="./Staff_Page.php">Staff Zone</a>
          <a href="./Shopping_Basket.php">Basket</a>
          <a href="./Login_Form.php">Login</a>
      </nav>
    </div>
    <div class = "login-info">
      <p>

      </p>
    </div>
    <!-- Header section. This is styles with an image in the css -->
    <header class="main-header">
      <h1>Aston Book Store</h1>
    </header>

    <main>
      <!-- sections to promote books -->
      <section>
      <!--This section contains the three primary subjects listed as cards -->
        <h2>Genres</h2>
        <!-- Remeber to add alt tags -->
        <div class="card">
          <h3 class="genre-heading">Computing</h3>
          <a href="./Store.html#computing"><img class="card-img" src="../resources/images/Home_Page_Images/coding_card.jpg" alt="An image of code on a computer screen"/></a>
        </div>
        <div class="card">
          <h3 class="genre-heading">Business</h3>
          <a href="./Store.html#business"><img class="card-img" src="../resources/images/Home_Page_Images/business_card.jpg" alt="An image of two business people discussing documents"/></a>
        </div>
        <div class="card">
          <h3 class="genre-heading">Languages</h3>
          <a href="./Store.html#languages"><img class="card-img" src="../resources/images/Home_Page_Images/languages_card.jpg" alt="An image of a Spanish dictionary"/></a>
        </div>
      </section>

      <!-- Add a list of books here -->
      <section>
        <h2>Popular Reads</h2>
        <!-- Somehow pull back from DB based on order no-->
      </section>

      <!-- Add a list of books here -->
      <section>
        <!-- Somehow pull back from DB based on added date -->
        <h2>New In Stock</h2>
      </section>

    </main>

    <!-- An inspirational & motivational quote related to education -->
    <aside class="quote">
      <blockquote>
      Only the educated are free.
        <footer>
      ~   <cite><a href="https://www.goodreads.com/quotes/183399-only-the-educated-are-free" target="_blank">Epictetus</a></cite>
        </footer>
      </blockquote>
    </aside>

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
