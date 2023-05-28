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
        $res = mysqli_query($conn, $query);

        $userinfo = mysqli_fetch_assoc($res);
    ?>
    <head>
        <title>Wanderlust Adventures</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="home.css">
        <script src="home.js" defer></script>
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
                    <a href="flights.php">Voli</a>
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

            <div id="left">
                <h1>Wanderlust Adventures</h1>
                <div id="subtitle"><em>Fuggi dalla tua routine con noi</em></div>
            </div>

            <form>
                <input type='text' 
                        placeholder='Dove vuoi andare?'
                        name='city'
                        id='city'>
                <img src='./assets/magnifier.png' id='submit'>
            </form>
        </header>

        <img id="logo" src="./assets/logo.jpg"/>

        <section id="content">
            <span id="text">Ecco alcune tra le mete consigliate: </span>
            <div id="suggested">
                <div class='image' data-latitude="-6.1664908" data-longitude="39.2074312"><img src="./assets/zanzibar.jpg"><span>ZANZIBAR</span></div>
                <div class="image" data-latitude="40.6286581" data-longitude="14.4854955"><img src="./assets/positano.jpg"><span>POSITANO</span></div>
                <div class="image" data-latitude="30.0443879" data-longitude="31.2357257"><img src="./assets/ilcairo.jpg"><span>IL CAIRO</span></div>
                <div class="image" data-latitude="36.4622122" data-longitude="25.3757257"><img src="./assets/santorini.jpg"><span>SANTORINI</span></div>
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