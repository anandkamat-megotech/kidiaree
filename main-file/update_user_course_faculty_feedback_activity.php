<?php

include './components/component_update_user_course_activity.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_user_course_activity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceUpdateUserCourseActivity = new ServiceUpdateUserCourseActivity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idSchedule = "";
$idSchedule = post_params("idSchedule");

$idStatus = "";
$idStatus = post_params("idStatus");

$progress = "";
$progress = post_params("progress");

//Check whether idSchedule is numeric or not
if(!is_numeric($idSchedule)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idStatus is numeric or not
if(!is_numeric($idStatus)){
    echo response_parameters_invalid(time());
    return;
}


if(empty($progress)){
    $progress = 'NULL';
}

//Check whether idSchedule exists or not
$rowCountSchedule = $serviceCheckRecordExistsInTable->serve($db, "SchedulesMaster", $idSchedule);
if ($rowCountSchedule == 0) {
    echo response_not_found(time());
    return;
}

//Check whether idStatus exists or not
$rowCountStatus = $serviceCheckRecordExistsInTable->serve($db, "StatusMaster", $idStatus);
if ($rowCountStatus == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get idFacultyFeedback from SchedulesMaster
$idFacultyFeedback = getSingleValue($db, "SELECT idFacultyFeedback FROM SchedulesMaster WHERE id = ?", [$idSchedule]);

//Get idCourse from SchedulesMaster
$idCourse = getSingleValue($db, "SELECT idCourse FROM SchedulesMaster WHERE id = ?", [$idSchedule]);


//Check whether idPrerecordedSession is not Null
if($idFacultyFeedback == NULL){
    echo response_not_found(time());
    return;
}

//Check record for schedule and User already exists in UserActivity
$id = getSingleValue($db, "SELECT id FROM UserActivity WHERE idSchedule = ? AND idUser = ?", [$idSchedule, $idUser]);
$createTimestamp = NULL;
$updateTimestamp = NULL;

if($id == NULL){
    //New record in UserActivity
    $createTimestamp = time();
}else{
    //Update existing record
    $updateTimestamp = time();
}

$id = $serviceUpdateUserCourseActivity->serve($db, $id, $idSchedule, $idUser, $idStatus, $createTimestamp, $updateTimestamp, $progress, $idCourse);

$idStatusCompleted = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Completed']);


if($idStatus == $idStatusCompleted){
    $facultyFeedbackSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idFacultyFeedback = ?", [$idFacultyFeedback]);

    $milestoneScheduleId = getSingleValue($db, "SELECT id FROM SchedulesMaster WHERE sequenceNumber > ? AND idMilestone IS NOT NULL ORDER BY sequenceNumber LIMIT 1", [$facultyFeedbackSequenceNumber]);

    $id = NULL;
    $createTimestamp = time();
    $updateTimestamp = time();
    $progress = NULL;
    $id = $serviceUpdateUserCourseActivity->serve($db, $id, $milestoneScheduleId, $idUser, $idStatus, $createTimestamp, $updateTimestamp, $progress);

    echo response_ok($id, time());

}else{
    
    echo response_ok($id, time());
}



?> 