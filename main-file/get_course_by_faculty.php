<?php

include './components/component_search_by_course.php';
include './services/service_base.php';
include './services/service_get_course_by_faculty_id.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$token = getBearerToken();

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$ServiceGetCourseByFaculty = new ServiceGetCourseByFaculty();


// $searchString = "";
// $searchString = post_params("searchString");

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);



$json = $ServiceGetCourseByFaculty->serve($db, $idUser);

echo response_ok($json, time());

?> 