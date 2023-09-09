<?php

include './components/component_get_questions.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_faculty_get_questions.php';
include './services/service_admin_get_questions.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceFacultyGetQuestions = new ServiceFacultyGetQuestions();
$serviceAdminGetQuestions = new ServiceAdminGetQuestions();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$offset = "";
$offset = post_params("offset");

//Check whether offset is numeric or not
if(!is_numeric($offset)){
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

    $json = $serviceFacultyGetQuestions->serve($db, $idFaculty, $offset);

    echo response_ok($json, time());
}else{
    $json = $serviceAdminGetQuestions->serve($db, $offset);

    echo response_ok($json, time());
}



?> 