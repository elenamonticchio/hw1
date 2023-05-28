<?php
    require_once 'session.php';

    if(checkSession()){
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["name"]) && !empty($_POST["lastname"]) && !empty($_POST["email"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["confirm"])){
        $errors = array();

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "* Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $errors[] = "* Email già in uso";
            }
        }

        if(!preg_match('/^[a-z0-9_.]{1,20}$/', $_POST['username'])) {
            $errors[] = "* L'username può contenere massimo 20 caratteri, solo lettere minuscole, numeri e simboli";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $errors[] = "* Username già in uso";
            }
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[._!@#$&*])(?=.*[0-9])(?=.{8,})/', $_POST['password'])) {
            $errors[] = "* La password deve contenere almeno 8 caratteri, almeno una lettera maiuscola, almeno un numero e almeno un carattere speciale";
        } 

        if (strcmp($_POST["password"], $_POST["confirm"]) != 0) {
            $errors[] = "* Le password non coincidono";
        }

        if (count($errors) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users (name, lastname, email, username, password) VALUES('$name', '$lastname', '$email', '$username', '$password')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["user"] = $_POST["username"];
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $errors[] = "Impossibile connettersi al database";
            }
        }
        mysqli_close($conn);
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Iscriviti</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='signup.css'>
        <link rel='stylesheet' href='style.css'>
        <script src='signup.js?version=6' defer></script>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="container">
            <h1>Registrati</h1>
            <form name="signup" method="post">
                <div class="name">
                    <label for='name'>Nome</label>
                    <input type='text' name='name' <?php if(isset($_POST["name"])){ echo "value=".$_POST["name"]; } ?> >
                    <span>* Inserisci il tuo nome</span>
                </div>
                <div class="lastname">
                    <label for='lastname'>Cognome</label>
                    <input type='text' name='lastname' <?php if(isset($_POST["lastname"])){ echo "value=".$_POST["lastname"];} ?> >
                    <span>* Inserisci il tuo cognome</span>
                </div>
                <div class="email">
                    <label for='email'>Email</label>
                    <input type='text' name='email' <?php if(isset($_POST["email"])){ echo "value=".$_POST["email"]; } ?> >
                    <span>* Inserisci la tua email</span>
                </div>
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?> >
                    <span>* Inserisci il tuo username</span>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' class='short'>
                    <img src="./assets/open.png" id="show">
                    <span>* Inserisci almeno 8 caratteri</span>
                </div>
                <div class="confirm">
                    <label for='confirm'>Conferma password</label>
                    <input type='password' name='confirm' class='short'>
                    <img src="./assets/open.png" id="show">
                    <span>* Conferma la password</span>
                </div>
            </form>

            <?php if(isset($errors)) {
                    foreach($errors as $error) {
                        echo "<div class='php_error'>".$error."</div>";
                    }
                }
            ?>

            <input type='submit' value="Registrati" id="submit">

            <div id="login">Hai già un account?
                <a href="login.php">Accedi</a>
            </div>
        </div>
    </body>
</html>