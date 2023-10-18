<?php 

function response_ok($amount, $offerPercentage, $finalAmount, $maxAmount, $minAmount, $flatDiscount, $discountType, $usageType, $cgstAmount,$sgstAmount, $timestamp){
    http_response_code(200);
    $str = '{"code": 200, "timestamp": '.$timestamp.', "body": {"amount": "'.$amount.'", "offerPercentage": "'.$offerPercentage.'", "finalAmount": "'.$finalAmount.'", "maxAmount": "'.$maxAmount.'", "minAmount": "'.$minAmount.'", "flatDiscount": "'.$flatDiscount.'", "discountType": "'.$discountType.'", "usageType": "'.$usageType.'", "cgstAmount": "'.$cgstAmount.'", "sgstAmount": "'.$sgstAmount.'"} }';
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

function response_already_redeemed($timestamp){
    http_response_code(403);
    $str = '{"code": 403, "timestamp": '.$timestamp.', "message": "'.ERR_ALREADY_REDEEMED.'"}';
    return $str;
}

function response_campaign_ended($timestamp){
    http_response_code(405);
    $str = '{"code": 405, "timestamp": '.$timestamp.', "message": "'.ERR_CAMPAIGN_ENDED.'"}';
    return $str;
}

function response_bucket_full($timestamp){
    http_response_code(406);
    $str = '{"code": 406, "timestamp": '.$timestamp.', "message": "'.ERR_BUCKET_FULL.'"}';
    return $str;
}
function response_campaign_course_not_available($timestamp){
    http_response_code(408);
    $str = '{"code": 408, "timestamp": '.$timestamp.', "message": "'.ERR_COURSE_NOT_AVAILABLE.'"}';
    return $str;
}

?> 