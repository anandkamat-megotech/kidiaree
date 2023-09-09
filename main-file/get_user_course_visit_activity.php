<?php

include './components/component_get_user_course_visit_activity.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_user_course_visit_activity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetUserCourseVisitActivity = new ServiceGetUserCourseVisitActivity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$idStatusVisited = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Visited']);

$json = $serviceGetUserCourseVisitActivity->serve($db, $idUser, $idStatusVisited);

echo response_ok($json, time());

?> 