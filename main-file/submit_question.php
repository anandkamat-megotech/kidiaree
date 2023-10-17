<?php

include './components/component_submit_question.php';
include './globals/constants_question_asked_email_db.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_submit_question.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceSubmitQuestion = new ServiceSubmitQuestion();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$question = "";
$question = clean(post_params("question"));

$idCourse = "";
$idCourse = post_params("idCourse");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

$isQuestionValid = $validatorString->validate($question);

if(!$isQuestionValid){
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

$id = $serviceSubmitQuestion->serve($db, $idUser, $idCourse, $question);

$idFaculty = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);
$idUserFaculty = getSingleValue($db, "SELECT idUser FROM FacultyMaster WHERE id = ?", [$idFaculty]);
$emailFaculty = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUserFaculty]);

$course = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);

$userName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);
$mailSubject = "Question Asked";

$mailContent = str_replace("[COURSE]", $course, QUESTION_ASKED_MAIL_FORMAT);
$mailContent = str_replace("[USER_NAME]", $userName, $mailContent);
$mailContent = str_replace("[QUESTION]", $question, $mailContent);

send_mail_to($emailFaculty, $mailSubject, $mailContent);


echo response_ok($id, time());

?> 