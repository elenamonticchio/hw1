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
        $query1 = "SELECT * FROM flights WHERE username = '$username' AND content = '$content'";

        $result = mysqli_query($conn, $query1) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            echo json_encode(array('ok' => true));
            exit;
        }

        $query2 = "INSERT INTO flights (content, username) VALUES ('$content', '$username')";
        if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
        }
    } else {
        $data = json_encode($_POST);
        $encodedData = mysqli_real_escape_string($conn, $data);
        $query1 = "SELECT * FROM flights WHERE username = '$username' AND content = '$encodedData'";

        $result = mysqli_query($conn, $query1) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            echo json_encode(array('ok' => true));
            exit;
        }

        $query2 = "INSERT INTO flights (content, username) VALUES ('$encodedData', '$username')";
        if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
        }
    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>


