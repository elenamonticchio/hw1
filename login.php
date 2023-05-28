<?php
    include 'session.php';
    if (checkSession()) {
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
        $errors = array();

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT * FROM users WHERE username = '".$username."'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        if (mysqli_num_rows($res) > 0) {
            $user = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION["user"] = $user["username"];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            } else {
                $errors[]="* Password non corretta";
            }
        } else {
            $errors[]="* Username non corretto";
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Accedi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='signup.css'>
        <link rel='stylesheet' href='login.css'>
        <link rel='stylesheet' href='style.css'>
        <script src='login.js' defer></script>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="container">
            <h1>Accedi</h1>
            <form name="login" method="post">
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username'>
                    <span>* Inserisci username</span>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' class='short'>
                    <img src="./assets/open.png" id="show">
                    <span>* Inserisci la tua password</span>
                </div>
            </form>

            <?php if(isset($errors)) {
                    foreach($errors as $error) {
                        echo "<div class='php_error'>".$error."</div>";
                    }
                }
            ?>

            <input type='submit' value="Accedi" id="submit">

            <div id="signup">Non hai un account?
                <a href="signup.php">Iscriviti</a>
            </div>
        </div>
    </body>
</html>