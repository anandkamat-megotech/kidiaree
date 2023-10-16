<?php
include './globals/constants_counselling_updated_email_db.php';
include './components/component_update_live_session.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_live_session.php';
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
$serviceUpdateLiveSession = new ServiceUpdateLiveSession();


$entityBody = file_get_contents('php://input');

$jsonObj = json_decode($entityBody);  

$idPrerecordedSession = $jsonObj->payload->tracking->utm_source;

$idMilestone = $jsonObj->payload->tracking->utm_medium;

$slug = $jsonObj->payload->event_type->slug;

$link = $jsonObj->payload->event->location;

$startTime = $jsonObj->payload->event->start_time;

$timestamp = date("U",strtotime($startTime));

$description = "Live session is scheduled at ".$jsonObj->payload->event->start_time_pretty;


//Check whether idPrerecordedSession is numeric or not
if(!is_numeric($idPrerecordedSession)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idPrerecordedSession exists or not
$rowCountIdPrerecordedSessionCount = $serviceCheckRecordExistsInTable->serve($db, "PrerecordedSessionsMaster", $idPrerecordedSession);
if ($rowCountIdPrerecordedSessionCount == 0) {
    echo response_not_found(time());
    return;
}

//Check whether idMilestone is numeric or not
if(!is_numeric($idMilestone)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idMilestone exists or not
$rowCountIdMilestoneCount = $serviceCheckRecordExistsInTable->serve($db, "MilestonesMaster", $idMilestone);
if ($rowCountIdMilestoneCount == 0) {
    echo response_not_found(time());
    return;
}

$isTimestampNonEmpty = $validatorString->validate($timestamp);

if(!$isTimestampNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

$isLinkNonEmpty = $validatorString->validate($link);

if(!$isLinkNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

$isDescriptionNonEmpty = $validatorString->validate($description);

if(!$isDescriptionNonEmpty){
    echo response_parameters_invalid(time());
    return;
}


if($slug == CALENDLY_SLUG_LIVE_SESSION){
    $serviceUpdateLiveSession->serve($db, $idPrerecordedSession, $timestamp, $link, $description);
}

echo response_ok(time());

?> 