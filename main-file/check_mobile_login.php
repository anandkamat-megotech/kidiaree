<?php
include './components/component_check_mobile_login.php';
include './services/service_base.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}


date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();

$ip = "";
$ip = post_params("ip");

$isIPValid = $validatorString->validate($ip);

if(!$isIPValid){
    echo response_parameters_invalid(time());
    return;
}


$data = file_get_contents('https://ipapi.co/'.$ip.'/json/?key=eSH3jpNeBxqnXfy3QUd3yyHej4QLwD4ISZGIkqjJO2sWNCVmYR');

$jsonData = json_decode($data,true);
$countryCode = $jsonData['country_code'];

if($countryCode == 'IN'){
    echo response_ok('true', time());
}else{
    echo response_ok('false', time());
}

?> 