<?php
    require_once 'dbconfig.php';
    require_once 'session.php';
    if (!$username = checkSession()) exit;

    global $dbconfig, $username;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    if (!$conn) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($conn, $username);

    if (isset($_POST['content'])) {
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $query = "DELETE FROM flights WHERE username = '$username' AND content = '$content'";
    } else {
        $data = json_encode($_POST);
        $encodedData = mysqli_real_escape_string($conn, $data);
        $query = "DELETE FROM flights WHERE username = '$username' AND content = '$encodedData'";
    }

    if (mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('ok' => true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>

