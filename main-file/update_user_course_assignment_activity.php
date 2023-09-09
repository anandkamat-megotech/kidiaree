<?php

include './components/component_update_user_course_activity.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_user_course_activity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
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


//Get idCourse from SchedulesMaster
$idCourse = getSingleValue($db, "SELECT idCourse FROM SchedulesMaster WHERE id = ?", [$idSchedule]);

//Get idAssignment from SchedulesMaster
$idAssignment = getSingleValue($db, "SELECT idAssignment FROM SchedulesMaster WHERE id = ?", [$idSchedule]);

//Check whether idAssignment is not Null
if($idAssignment == NULL){
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

echo response_ok($id, time());

?> 