<?php
require_once 'config.php';
   
$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
   
$db = new DB();
$arr_token = $db->get_access_token();
$accessToken = $arr_token->access_token;
   
$response = $client->request('GET', '/v2/past_meetings/MEETING_ID/participants', [
    "headers" => [
        "Authorization" => "Bearer $accessToken"
    ]
]);
  
$data = json_decode($response->getBody());
if ( !empty($data) ) {
    foreach ( $data->participants as $p ) {
        $name = $p->name;
        $email = $p->user_email;
        echo "Name: $name";
        echo "Email: $email";
    }
}