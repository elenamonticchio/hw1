<?php 
  require_once 'session.php';
  if (!$username=checkSession()) {
      header("Location: login.php");
      exit;
  }
?>
<html>
  <?php
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $res_1 = mysqli_query($conn, $query);

    $userinfo = mysqli_fetch_assoc($res_1);
  ?>
  <head>
    <title>Wanderlust Adventures</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="profile.css">
    <script src="profile.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>
    <header>
      <nav>
        <div id="name">Wanderlust Adventures</div>
        <div id="links">
          <a href="home.php">Home</a>
          <a>Offerte</a>
          <a href="flights.php">Voli</a>
          <a>Contatti</a>
          <a href="logout.php" id="button">Esci</a>
        </div>

        <div id="menu">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </nav>

      <div id="overlay"></div>

      <h1><?php echo $userinfo['name']." ".$userinfo['lastname'] ?></h1>
    </header>

    <img id="logo" src="./assets/logo.jpg"/>

    <section id="results-view">
      <span class='text'> Le tue attività preferite: </span>
      <div class="noresults" id='no-activity'></div>
      <section id="container"></section>
      <span class='text'> I tuoi voli preferiti: </span>
      <div class="noresults" id='no-flight'></div>
      <section id="container2"></section>
    </section>

    <footer>
      <span>Creato da: Elena Maria Monticchio</span>
      <span>Matricola: 1000015325</span>
    </footer>
  </body>
</html>