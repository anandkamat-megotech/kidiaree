<?php

include './components/component_submit_answer.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_submit_answer.php';
include './services/service_check_record_exists_in_table.php';
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
$serviceSubmitAnswer = new ServiceSubmitAnswer();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$answer = "";
$answer = clean(post_params("answer"));

$idCourse = "";
$idCourse = post_params("idCourse");

$idQuestion = "";
$idQuestion = post_params("idQuestion");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idQuestion is numeric or not
if(!is_numeric($idQuestion)){
    echo response_parameters_invalid(time());
    return;
}

$isAnswerValid = $validatorString->validate($answer);

if(!$isAnswerValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Check whether idQuestion exists or not
$rowCountQuestion = $serviceCheckRecordExistsInTable->serve($db, "Questions", $idQuestion);
if ($rowCountQuestion == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check id of Faculty from rolesmaster
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

//Check id of Admin from rolesmaster
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);


//Check role of user from usersmaster
$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);


if(($idRole != $idFacultyMaster) && ($idRole != $idAdminMaster)){
    echo response_unauthorized(time());
    return;
}

$id = $serviceSubmitAnswer->serve($db, $answer, $idQuestion, $idUser, $idCourse);

echo response_ok($id, time());

?> 