<?php

include './components/component_cancel_live_session.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_cancel_live_session.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCancelLiveSession = new ServiceCancelLiveSession();


$entityBody = file_get_contents('php://input');

$jsonObj = json_decode($entityBody);  

$idPrerecordedSession = $jsonObj->payload->tracking->utm_source;

$slug = $jsonObj->payload->event_type->slug;



//Check whether idPrerecordedSession is numeric or not
if(!is_numeric($idPrerecordedSession)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idPrerecordedSession exists or not
$rowCountIdPrerecordedSessionCount = $serviceCheckRecordExistsInTable->serve($db, "Prerecordedsessionsmaster", $idPrerecordedSession);
if ($rowCountIdPrerecordedSessionCount == 0) {
    echo response_not_found(time());
    return;
}

if($slug == CALENDLY_SLUG_LIVE_SESSION){
    $serviceCancelLiveSession->serve($db, $idPrerecordedSession);
}




echo response_ok(time());

?> 