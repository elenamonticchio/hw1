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
    $cityToTranslate = urlencode($_GET["q"]);
    $yandex_key = 'trnsl.1.1.20230424T095649Z.34cfccf4e38befaf.237894ccedab4dffe96c5894d17f3bccb691a2d0';
    $query = http_build_query(array('key' => $yandex_key, 'text' => $cityToTranslate, 'lang' => 'it-en'));
    curl_setopt($curl, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate?' . $query);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $json = json_decode($response, true);
    $keyword = $json['text'][0];
    curl_close($curl);    

    $curl = curl_init();
    $query = "keyword=" . $keyword . "&max=1";
    curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v1/reference-data/locations/cities?".$query); 
    $headers = array("Authorization: Bearer ".$token['access_token']); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $results_1=curl_exec($curl);
    $city=json_decode($results_1);
    $latitude = $city->data[0]->geoCode->latitude;
    $longitude = $city->data[0]->geoCode->longitude;
    curl_close($curl);

    $curl = curl_init();
    $query = http_build_query(array("latitude" => $latitude, "longitude" => $longitude, "radius" => 20));
    curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v1/shopping/activities?".$query); 
    $headers = array("Authorization: Bearer ".$token['access_token']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $results_2=curl_exec($curl);
    curl_close($curl);

    echo $results_2;
?>