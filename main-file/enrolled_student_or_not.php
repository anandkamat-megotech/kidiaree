<?php

include './components/component_enroll_student_get_count.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_enroll_get_student.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idMilestone = "";
$idMilestone = post_params("idMilestone");
$serviceEnrolledStudent = new ServiceEnrolledStudent();

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);



$json = $serviceEnrolledStudent->serve($db, $idUser, $idMilestone);

echo response_ok($json, time());

?> 