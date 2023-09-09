<?php

include './components/component_is_trial_period.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$isTrialPeriodStarted = getSingleValue($db, "SELECT isTrialStarted FROM usersmaster WHERE id = ?", [$idUser]);

if($isTrialPeriodStarted == 1){
    $currentTimestamp = time();
    $expiryTimestamp = getSingleValue($db, "SELECT trialExpiryTimestamp FROM usersmaster WHERE id = ?", [$idUser]);
    if($currentTimestamp < $expiryTimestamp){
        $myObj = new stdClass();
        $myObj->isTrialPeriod = 'true';
        $myObj->message = 'This trial period is valid till '.date('D, M d Y, H:i:s', $expiryTimestamp);

        echo response_ok(json_encode($myObj), time());
    }else{
        $myObj = new stdClass();
        $myObj->isTrialPeriod = 'false';
        $myObj->message = 'This trial period was valid till '.date('D, M d Y, H:i:s', $expiryTimestamp);
        echo response_ok(json_encode($myObj), time());
    }
}else{
    $myObj = new stdClass();
    $myObj->isTrialPeriod = 'false';
    $myObj->message = 'Start Free Trial';
    echo response_ok(json_encode($myObj), time());
}



?> 