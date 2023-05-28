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
    <link rel="stylesheet" href="flights.css">
    <script src="flights.js" defer></script>
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
          <a>Offerte</a>
          <a href="home.php">Home</a>
          <a>Contatti</a>
          <a href="profile.php" id="button"><?php echo $userinfo['name'] ?></a>
        </div>

        <div id="menu">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </nav>

      <div id="overlay"></div>

      <section class="flight-search">
        <h1>Trova il tuo volo</h1>

        <form>
          <div class="form-group">
            <label for="departure">Partenza</label>
            <input type="text" id="departure" name="departure" placeholder="Luogo di partenza">
          </div>
          <div class="form-group">
            <label for="destination">Destinazione</label>
            <input type="text" id="destination" name="destination" placeholder="Luogo di destinazione">
          </div>
          <div class="form-group">
            <label for="departure-date">Data di partenza</label>
            <input type="date" id="departure-date" name="departure-date" required>
          </div>
          <div class="form-group">
            <label for="return-date">Data di ritorno</label>
            <input type="date" id="return-date" name="return-date">
          </div>
          <div class="form-group">
            <label for="adults">Numero di adulti</label>
            <select id="adults" name="adults" required>
              <option value="1">1 adulto</option>
              <option value="2">2 adulti</option>
              <option value="3">3 adulti</option>
              <option value="4">4 adulti</option>
              <option value="5">5 adulti</option>
              <option value="6">6 adulti</option>
              <option value="7">7 adulti</option>
              <option value="8">8 adulti</option>
              <option value="9">9 adulti</option>
            </select>
          </div>
          <div class="form-group">
            <label for="children">Numero di bambini</label>
            <select id="children" name="children">
              <option value="0">Nessun bambino</option>
              <option value="1">1 bambino</option>
              <option value="2">2 bambini</option>
              <option value="3">3 bambini</option>
              <option value="4">4 bambini</option>
              <option value="5">5 bambini</option>
              <option value="6">6 bambini</option>
              <option value="7">7 bambini</option>
              <option value="8">8 bambini</option>
              <option value="9">9 bambini</option>
            </select>
          </div>
        </form>

        <input type='submit' value="Cerca" id="submit">
      </section>
    </header>

    <section id="content">
      <span id="text">Ecco alcune tra le mete consigliate: </span>
      <div id="suggested">
          <div class='image' data-name="zanzibar"><img src="./assets/zanzibar.jpg"><span>ZANZIBAR</span></div>
          <div class="image" data-name="positano"><img src="./assets/positano.jpg"><span>POSITANO</span></div>
          <div class="image" data-name="cairo"><img src="./assets/ilcairo.jpg"><span>IL CAIRO</span></div>
          <div class="image" data-name="santorini"><img src="./assets/santorini.jpg"><span>SANTORINI</span></div>
      </div>
    </section>

    <section id="results-view" class='hidden'>
            <section id="container"></section>
            <section id="back">Torna indietro</section>
    </section>

    <footer>
      <span>Creato da: Elena Maria Monticchio</span>
      <span>Matricola: 1000015325</span>
    </footer>
  </body>
</html>