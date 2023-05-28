<?php 
    require_once 'session.php';
    if(!checkSession()) exit;

    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,'https://api.amadeus.com/v1/security/oauth2/token');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=GRBsiYlPUM59re6KS0LaqnVExcabaXXj&client_secret=Gz0pD2Ao4RGj0FCR");
    $headers = array('Content-Type: application/x-www-form-urlencoded');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $results=curl_exec($curl);
    $token=json_decode($results,true);
    curl_close($curl);

    $curl = curl_init();
    $latitude = urlencode($_GET["latitude"]);
    $longitude = urlencode($_GET["longitude"]);
    $query = http_build_query(array("latitude" => $latitude, "longitude" => $longitude, "radius" => 20));
    curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v1/shopping/activities?".$query); 
    $headers = array("Authorization: Bearer ".$token['access_token']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $results_2=curl_exec($curl);
    curl_close($curl);

    echo $results_2;
?>