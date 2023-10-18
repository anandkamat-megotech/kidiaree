<?php

include './components/component_admin_get_faculty.php';
include './services/service_base.php';
include './services/service_admin_get_faculty.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceAdminGetFaculty = new ServiceAdminGetFaculty();

$json = $serviceAdminGetFaculty->serve($db);

echo response_ok($json, time());

?> 