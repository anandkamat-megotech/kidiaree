<?php
require_once 'config.php';
include '../utilities/authorization.php';

insertCorsHeaders();
  
function create_meeting($entityBody) {
    date_default_timezone_set('Asia/Calcutta');
    $jsonData = json_decode($entityBody,true);
    $topic = $jsonData['topic'];
    $cid = 81;
    $start_time = $jsonData['start_time'];
    $timestamp = strtotime($start_time);
    
    $dateSlots = date("Y-m-d", $timestamp);
    $year = date("Y", $timestamp);

    $month = date("m", $timestamp);

    $day = date("d", $timestamp);

    $hour = date("h", $timestamp);

    $minute = date("i", $timestamp);

    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
  
    $db = new DB();
    

    $zoom_id = $db->get_zoom_id($cid);
    if(empty($zoom_id)){
        echo $str = '{"code": 403, "timestamp": '.time().', "message": "meeting id not found" }';
        exit();
    }
    $clientId = '';
    $clientSecret = '';
    if($zoom_id == 3) {
        $clientId = CLIENT_ID;
        $clientSecret = CLIENT_SECRET;
    }elseif($zoom_id == 4){
        $clientId = CLIENT_ID1;
        $clientSecret = CLIENT_SECRET1;
    }elseif($zoom_id == 5){
        $clientId = CLIENT_ID2;
        $clientSecret = CLIENT_SECRET2;
    }
    // echo $zoom_id;
   
   
    $arr_token = $db->get_access_token($zoom_id);
    $accessToken = $arr_token->access_token;
    // echo $accessToken;
    // die;
  
    try {
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => $topic,
                "type" => 2,
                "start_time" => $jsonData['start_time'],
                "duration" => "30", // 30 mins
                "password" => "123456"
            ],
        ]);
  
        $response->getBody();
        // $data = json_decode($response->getBody());
        // print_r($data);
        // die;
      
        // $statement1 = query_execute($db, $sql1);
        // $data = json_decode($response->getBody());
        // echo "Join URL: ". $data->join_url;
        // echo "<br>";
        // echo "Meeting Password: ". $data->password;
        $str = '{"code": 200, "timestamp": '.$timestamp.', "body": '.$response->getBody().' }';
        echo $str;
  
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token($zoom_id);
  
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode($clientId.':'.$clientSecret)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody(),$zoom_id);
            $entityBody = file_get_contents('php://input'); 
  
            create_meeting($entityBody);
        } else {
            echo $e->getMessage();
        }
    }
}
$entityBody = file_get_contents('php://input');  
create_meeting($entityBody);