<?php

include './components/component_get_answers.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_faculty_get_single_answer.php';
include './services/service_admin_get_single_answer.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceFacultyGetSingleAnswer = new ServiceFacultyGetSingleAnswer();
$serviceAdminGetSingleAnswer = new ServiceAdminGetSingleAnswer();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idAnswer = "";
$idAnswer = post_params("idAnswer");

//Check whether offset is numeric or not
if(!is_numeric($idAnswer)){
    echo response_parameters_invalid(time());
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

if ($idRole == $idFacultyMaster) {
    //Get idFaculty of from FacultyMaster
    $idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);


    $json = $serviceFacultyGetSingleAnswer->serve($db, $idFaculty, $idAnswer);

    echo response_ok($json, time());
}else{
    $json = $serviceAdminGetSingleAnswer->serve($db, $idAnswer);

    echo response_ok($json, time());
}





?> 