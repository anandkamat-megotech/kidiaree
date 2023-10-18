<?php

include './components/component_get_meeting_link.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_meeting_link.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetMeetingLink = new ServiceGetMeetingLink();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idPrerecordedSession = "";
$idPrerecordedSession = post_params("idPrerecordedSession");

//Check whether idPrerecordedSession is numeric or not
if(!is_numeric($idPrerecordedSession)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idPrerecordedSession exists or not
$rowCountPrerecordedSession = $serviceCheckRecordExistsInTable->serve($db, "PrerecordedSessionsMaster", $idPrerecordedSession);
if ($rowCountPrerecordedSession == 0) {
    echo response_not_found(time());
    return;
}

$isLive = getSingleValue($db, "SELECT isLive FROM PrerecordedSessionsMaster WHERE id = ?", [$idPrerecordedSession]);

if($isLive != 1){
    echo response_not_found(time());
    return;
}

$idCourse = "";
$idCourse = post_params("idCourse");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get id of payment from UserCoursePaymentMapping
$idPayment = getSingleValue($db, "SELECT id FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);

if($idPayment == ''){
    echo response_not_found(time());
    return;
}
date_default_timezone_set('Asia/Kolkata');
$meetingTimeStamp = getSingleValue($db, "SELECT meetingTimestamp FROM PrerecordedSessionsMaster WHERE id = ?", [$idPrerecordedSession]);

$currentTime = time();

if(($meetingTimeStamp - $currentTime) > 1800) {     //1800 seconds
    echo response_ok("Meeting link will be available 30 minutes before the scheduled time.", time());
    return;
}

$meetingLink = $serviceGetMeetingLink->serve($db, $idPrerecordedSession);

echo response_ok($meetingLink, time());

?> 