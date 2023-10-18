<?php 

function response_ok($json, $timestamp){
    http_response_code(200);
    $str = '{"code": 200, "timestamp": '.$timestamp.', "body": '.$json.' }';
    return $str;
}


?> 