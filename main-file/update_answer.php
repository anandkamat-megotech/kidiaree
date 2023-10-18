<?php

include './components/component_update_answer.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_answer.php';
include './services/service_check_record_exists_in_table.php';
include './validator/validator_string.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceUpdateAnswer = new ServiceUpdateAnswer();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idAnswer = "";
$idAnswer = post_params("idAnswer");

$answer = "";
$answer = post_params("answer");

//Check whether idAnswer is numeric or not
if(!is_numeric($idAnswer)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idAnswer exists or not
$rowCountAnswer = $serviceCheckRecordExistsInTable->serve($db, "Answers", $idAnswer);
if ($rowCountAnswer == 0) {
    echo response_not_found(time());
    return;
}

$isAnswerValid = $validatorString->validate($answer);

if(!$isAnswerValid){
    echo response_parameters_invalid(time());
    return;
}


//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check id of Faculty from rolesmaster
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

//Check id of Faculty from rolesmaster
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);


//Check role of user from usersmaster
$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);


if($idRole != $idFacultyMaster && $idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}

//Get idFaculty of from FacultyMaster
$idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);

//Get idCourse of question
$idCourse = getSingleValue($db, "SELECT idCourse FROM Answers WHERE id = ?", [$idAnswer]);

//Get idFaculty of course
$idFacultyCourse = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);

if($idFaculty != $idFacultyCourse && $idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}


$json = $serviceUpdateAnswer->serve($db, $idAnswer, $answer);

echo response_ok($idAnswer, time());

?> 