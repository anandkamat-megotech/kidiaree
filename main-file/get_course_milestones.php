<?php

include './components/component_get_course_milestones.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_course_milestones.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetCourseMilestones = new ServiceGetCourseMilestones();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
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
$rowCountIdCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountIdCourse == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

//Check whether user is Faculty or not
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

$idUserRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);



if(($idUserRole != $idAdminMaster) && ($idUserRole != $idFacultyMaster)){
    echo response_unauthorized(time());
    return;
}

$json = $serviceGetCourseMilestones->serve($db, $idCourse);

echo response_ok($json, time());

?> 