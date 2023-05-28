<?php
    require_once 'session.php';
    if (!$username = checkSession()) exit;

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $username = mysqli_real_escape_string($conn, $username);

    $type = $_GET['q'];

    if ($type === 'activity') {
        $query = "SELECT * FROM activities WHERE username = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        $activitiesArray = array();
        while ($entry = mysqli_fetch_assoc($res)) {
            $activitiesArray[] = array(
                'username' => $entry['username'],
                'activityId' => $entry['id'],
                'name' => $entry['name'],
                'photo' => $entry['photo']
            );
        }
        echo json_encode($activitiesArray);
    } else if ($type === 'flight') {
        $query = "SELECT * FROM flights WHERE username = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        $flightsArray = array();
        while ($entry = mysqli_fetch_assoc($res)) {
            $flightsArray[] = array(
                'username' => $entry['username'],
                'id' => $entry['id'],
                'content' => $entry['content']
            );
        }
        echo json_encode($flightsArray);
    }
    
    exit;
?>
