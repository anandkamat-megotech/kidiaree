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


//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$idStatusVisited = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Visited']);

$createTimestamp = time();

$updateTimestamp = time();


$id = $serviceUpdateUserCourseActivity->serve($db, NULL, 0, $idUser, $idStatusVisited, $createTimestamp, $updateTimestamp, NULL, $idCourse);

echo response_ok($id, time());

?> 