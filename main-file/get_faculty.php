<?php

include './components/component_get_faculty.php';
include './services/service_base.php';
include './services/service_get_faculty.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetFaculty = new ServiceGetFaculty();

$json = $serviceGetFaculty->serve($db);

echo response_ok($json, time());

?> 