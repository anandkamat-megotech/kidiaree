<?php

include './components/component_get_user_profile.php';
include './services/service_base.php';
include './services/service_get_subscription_details.php';
include './services/service_check_token_validity.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetSubscriptionDetails = new ServiceGetSubscriptionDetails();
$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}



date_default_timezone_set(TIME_ZONE);


//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);



$json = $serviceGetSubscriptionDetails->serve($db, $idUser);

echo response_ok($json, time());

?> 