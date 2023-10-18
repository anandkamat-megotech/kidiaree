<?php

include './components/component_get_course_schedule.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_request_counselling_schedule.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceRequestCounsellingSchedule = new ServiceRequestCounsellingSchedule();
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
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser  from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get idFaculty  from CoursesMaster
$idFaculty = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);

//Get idFaculty  from CoursesMaster
$idCounsellingSession = getSingleValue($db, "SELECT id FROM CounsellingSessions WHERE idUser = ? AND idCourse = ?", [$idUser,$idCourse]);


$json = $serviceRequestCounsellingSchedule->serve($db, $idUser, $idCourse, $idFaculty, $idCounsellingSession);

echo response_ok(json_encode($json), time());

?> 