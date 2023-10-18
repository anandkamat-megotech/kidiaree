<?php

include './components/component_get_faculty_courses.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_faculty_courses.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetFacultyCourses = new ServiceGetFacultyCourses();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();
//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);
$idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);



//Check whether idFaculty is numeric or not
if(!is_numeric($idFaculty)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idFaculty exists or not
$rowCountFaculty = $serviceCheckRecordExistsInTable->serve($db, "FacultyMaster", $idFaculty);
if ($rowCountFaculty == 0) {
    echo response_not_found(time());
    return;
}


$json = $serviceGetFacultyCourses->serve($db, $idFaculty);

echo response_ok($json, time());

?> 