<?php
require_once 'config.php';
  
try {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
  
    $response = $client->request('POST', '/oauth/token', [
        "headers" => [
            "Authorization" => "Basic ". base64_encode(CLIENT_ID1.':'.CLIENT_SECRET1)
        ],
        'form_params' => [
            "grant_type" => "authorization_code",
            "code" => $_GET['code'],
            "redirect_uri" => REDIRECT_URI1
        ],
    ]);
  
    $token = json_decode($response->getBody()->getContents(), true);
  
    $db = new DB();
    $db->update_access_token(json_encode($token),4);
    echo "Access token inserted successfully.";
} catch(Exception $e) {
    echo $e->getMessage();
}