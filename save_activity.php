<?php 
    require_once 'session.php';
    if(!$username = checkSession()) exit;

    global $dbconfig, $username;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $username = mysqli_real_escape_string($conn, $username);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);

    $query = "SELECT * FROM activities WHERE username = '$username' AND id = '$id'";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_num_rows($result) > 0) {
        echo json_encode(array('ok' => true));
        exit;
    }

    $query = "INSERT INTO activities VALUES('$id','$name', '$photo', '$username')";

    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
    }
    
    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>