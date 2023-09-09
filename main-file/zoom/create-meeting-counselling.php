<?php
require_once 'configCounselling.php';
insertCorsHeaders();

class ServiceUpdateCounsellingDetailsMeeting{
function create_meeting($post_start_time, $studentName) {
    // print_r($post_start_time);
    // die;
    date_default_timezone_set('Asia/Calcutta');
    // $jsonData = json_decode($entityBody,true);
    // $idCounsellingSession = $jsonData['idCounsellingSession'];
    $topic = "Counselling session ".$studentName;
    $start_time = $post_start_time;
    $timestamp = strtotime($start_time);
    if($timestamp < time()){
        $str = '{"code": 400, "timestamp": '.time().', "message": "Please enter correct time" }';
        return $str;
        exit();
    }
   

    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
  
    $db = new DB();
    $arr_token = $db->get_access_token(3);
    // print_r($arr_token);
    // die;
    $accessToken = $arr_token->access_token;
  
    try {
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => $topic,
                "type" => 2,
                "start_time" => $start_time,
                "duration" => "30", // 30 mins
                "password" => "123456"
            ],
        ]);
  
        $response->getBody();
        $data = json_decode($response->getBody());
        return $data;
            print_r($data);
    die;
        // $sql1 = "Update CounsellingSessions SET meetingDescription = '$topic', meetingLink = '$data->id', dd = $day, mm = $month, yyyy = $year, hh = $hour, mmm = $minute, meetingTimestamp = '$timestamp' WHERE id = $idCounsellingSession;";
        // $db->create_data($sql1);
        // $statement1 = query_execute($db, $sql1);
        // $data = json_decode($response->getBody());
        // echo "Join URL: ". $data->join_url;
        // echo "<br>";
        // echo "Meeting Password: ". $data->password;
        // $str = '{"code": 200, "timestamp": '.$timestamp.', "body": {"data": null} }';
        // echo $str;
  
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token(3);
  
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody(),3);
            // $entityBody = file_get_contents('php://input');
            // print_r($entityBody); 
            // die;
  
            // create_meeting($entityBody);
        } else {
            echo $e->getMessage();
        }
    }
}
}
