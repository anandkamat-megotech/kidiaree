<?php

include './components/component_submit_student_feedback.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_submit_student_feedback.php';
include './services/service_create_certificate.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_check_student_feedback_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCheckStudentFeedbackExistsInTable = new ServiceCheckStudentFeedbackExistsInTable();
$serviceSubmitStudentFeedback = new ServiceSubmitStudentFeedback();
$serviceCreateCertificate = new ServiceCreateCertificate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$feedbackText = "";
$feedbackText = post_params("feedbackText");

$idCourse = "";
$idCourse = post_params("idCourse");

$overallExperience = "";
$overallExperience = post_params("overallExperience");

$qualityOfContent = "";
$qualityOfContent = post_params("qualityOfContent");

$qualityOfTasks = "";
$qualityOfTasks = post_params("qualityOfTasks");

$knowledgeBuilding = "";
$knowledgeBuilding = post_params("knowledgeBuilding");


//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

$isFeedbackTextValid = $validatorString->validate($feedbackText);

if(!$isFeedbackTextValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Check whether qualityOfContent is numeric or not
if(!is_numeric($qualityOfContent)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether qualityOfContent is less than 5
if($qualityOfContent > 5){
    echo response_parameters_invalid(time());
    return;
}

//Check whether overallExperience is numeric or not
if(!is_numeric($overallExperience)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether overallExperience is less than 5
if($overallExperience > 5){
    echo response_parameters_invalid(time());
    return;
}

//Check whether qualityOfTasks is numeric or not
if(!is_numeric($qualityOfTasks)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether qualityOfTasks is less than 5
if($qualityOfTasks > 5){
    echo response_parameters_invalid(time());
    return;
}

//Check whether knowledgeBuilding is numeric or not
if(!is_numeric($knowledgeBuilding)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether knowledgeBuilding is less than 5
if($knowledgeBuilding > 5){
    echo response_parameters_invalid(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether student feedback of idUser and idCourse exists or not
$rowCountStudentFeedback = $serviceCheckStudentFeedbackExistsInTable->serve($db, $idUser, $idCourse);
if ($rowCountStudentFeedback != 0) {
    echo response_duplicate(time());
    return;
}


$id = $serviceSubmitStudentFeedback->serve($db, $idUser, $idCourse, $feedbackText, $overallExperience, $qualityOfContent, $qualityOfTasks, $knowledgeBuilding);

//$id = $serviceCreateCertificate->serve($db, $idUser, $idCourse);

echo response_ok($id, time());

?> 