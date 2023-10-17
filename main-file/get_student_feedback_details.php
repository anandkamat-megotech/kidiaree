<?php

include './components/component_get_student_feedback_details.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_student_feedback_details.php';
include './services/service_check_student_feedback_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceGetStudentFeedbackDetails = new ServiceGetStudentFeedbackDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCheckStudentFeedbackExistsInTable = new ServiceCheckStudentFeedbackExistsInTable();

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

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether student feedback of idUser and idCourse exists or not
$rowCountStudentFeedback = $serviceCheckStudentFeedbackExistsInTable->serve($db, $idUser, $idCourse);
if ($rowCountStudentFeedback == 0) {
    echo response_not_found(time());
    return;
}

$json = $serviceGetStudentFeedbackDetails->serve($db, $idUser, $idCourse);

echo response_ok($json, time());

?> 