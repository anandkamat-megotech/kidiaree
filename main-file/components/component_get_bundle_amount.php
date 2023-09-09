<?php 

function response_ok($json, $timestamp){
    http_response_code(200);
    $str = '{"code": 200, "timestamp": '.$timestamp.', "body": '.$json.' }';
    return $str;
}

function response_parameters_invalid($timestamp){
    http_response_code(400);
    $str = '{"code": 400, "timestamp": '.$timestamp.', "message": "'.ERR_PARAMS_INVALID.'"}';
    return $str;
}

function response_not_found($timestamp){
    http_response_code(404);
    $str = '{"code": 404, "timestamp": '.$timestamp.', "message": "'.ERR_NOT_FOUND.'"}';
    return $str;
}


function response_unauthorized($timestamp){
    http_response_code(401);
    $str = '{"code": 401, "timestamp": '.$timestamp.', "message": "'.ERR_UNAUTHORIZED.'"}';
    return $str;
}

function response_already_enrolled($timestamp){
    http_response_code(403);
    $str = '{"code": 403, "timestamp": '.$timestamp.', "message": "'.ERR_ALREADY_ENROLLED.'"}';
    return $str;
}

?> 