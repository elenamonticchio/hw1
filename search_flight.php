<?php 
    require_once 'session.php';
    if(!checkSession()) exit;

    if(isset($_POST['departure']) && isset($_POST['destination']) && isset($_POST['departure-date']) && isset($_POST['return-date']) && isset( $_POST['adults']) && isset($_POST['children'])){
        $departureToTranslate = $_POST['departure'];
        $destinationToTranslate = $_POST['destination'];
        $departureDate = $_POST['departure-date'];
        $returnDate = $_POST['return-date'];
        $adults = $_POST['adults'];
        $children = $_POST['children'];   

        $curl = curl_init();
        $yandex_key = 'trnsl.1.1.20230424T095649Z.34cfccf4e38befaf.237894ccedab4dffe96c5894d17f3bccb691a2d0';
        $query = http_build_query(array('key' => $yandex_key, 'text' => $departureToTranslate, 'lang' => 'it-en'));
        curl_setopt($curl, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate?' . $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $json = json_decode($response, true);
        $departure = $json['text'][0];
        curl_close($curl);

        $curl = curl_init();
        $yandex_key = 'trnsl.1.1.20230424T095649Z.34cfccf4e38befaf.237894ccedab4dffe96c5894d17f3bccb691a2d0';
        $query = http_build_query(array('key' => $yandex_key, 'text' => $destinationToTranslate, 'lang' => 'it-en'));
        curl_setopt($curl, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate?' . $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $json = json_decode($response, true);
        $destination = $json['text'][0];
        curl_close($curl);

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
        $keyword = urlencode($departure);
        //$query = http_build_query( array("keyword" => $keyword , "max" => 1));
        $query = "keyword=" . $keyword . "&max=1";
        curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v1/reference-data/locations/cities?".$query); 
        $headers = array("Authorization: Bearer ".$token['access_token']); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $results_1=curl_exec($curl);
        $city_1=json_decode($results_1,true);
        $iataCodeDeparture = $city_1['data'][0]['iataCode'];
        curl_close($curl);
          
        $curl = curl_init();
        $keyword = urlencode($destination);
        //$query = http_build_query( array("keyword" => $keyword , "max" => 1));
        $query = "keyword=" . $keyword . "&max=1";
        curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v1/reference-data/locations/cities?".$query); 
        $headers = array("Authorization: Bearer ".$token['access_token']); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $results_2=curl_exec($curl);
        $city_2=json_decode($results_2,true);
        $iataCodeDestination = $city_2['data'][0]['iataCode'];
        curl_close($curl);

        $curl = curl_init();
        $query = http_build_query(array("originLocationCode" => $iataCodeDeparture, "destinationLocationCode" => $iataCodeDestination, "departureDate" => $departureDate, "returnDate" => $returnDate, "adults" => $adults, "children" => $children, "nonStop" => 'false', "currencyCode" => 'EUR', "max" => 5));
        curl_setopt($curl, CURLOPT_URL, "https://api.amadeus.com/v2/shopping/flight-offers?".$query); 
        $headers = array("Authorization: Bearer ".$token['access_token']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $results_3=curl_exec($curl);
        curl_close($curl);

        echo $results_3;
    }
?>