<?php

include './components/component_get_consumer_pin.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';



$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();

date_default_timezone_set(TIME_ZONE);

$token = getBearerToken();
$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}


//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get consumer pin of from usersmaster
$consumerPin = getSingleValue($db, "SELECT consumerPin FROM usersmaster WHERE id = ?", [$idUser]);

echo response_ok($consumerPin, time());

?> 