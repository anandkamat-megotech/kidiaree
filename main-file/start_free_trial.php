<?php

include './components/component_start_free_trial.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_start_free_trial.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceStartFreeTrial = new ServiceStartFreeTrial();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);


$serviceStartFreeTrial->serve($db, $idUser);

echo response_ok($idUser, time());

?> 