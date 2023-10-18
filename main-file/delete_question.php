<?php

include './components/component_blacklist_question.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_delete_question.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceDeleteQuestion = new ServiceDeleteQuestion();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idQuestion = "";
$idQuestion = post_params("idQuestion");

//Check whether idQuestion is numeric or not
if(!is_numeric($idQuestion)){
    echo response_parameters_invalid(time());
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
$idCourse = getSingleValue($db, "SELECT idCourse FROM Questions WHERE id = ?", [$idQuestion]);

//Get idFaculty of course
$idFacultyCourse = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);

if($idFaculty != $idFacultyCourse && $idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}


$json = $serviceDeleteQuestion->serve($db, $idQuestion);

echo response_ok($idQuestion, time());

?> 