<?php

include './components/component_get_courses.php';
include './services/service_base.php';
include './services/service_get_all_courses.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetAllCourses = new ServiceGetAllCourses();


$json = $serviceGetAllCourses->serve($db);

echo response_ok($json, time());

?> 