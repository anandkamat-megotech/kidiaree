<?php

include './components/component_get_student_question_answer.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_student_question_answer.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetStudentQuestionAnswer = new serviceGetStudentQuestionAnswer();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Student or not
$idStudentMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Student"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idStudentMaster){
    echo response_unauthorized(time());
    return;
}

$json = $serviceGetStudentQuestionAnswer->serve($db, $idUser);

echo response_ok(json_encode($json), time());

?> 