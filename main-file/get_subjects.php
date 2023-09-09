<?php

include './components/component_get_subjects.php';
include './services/service_base.php';
include './services/service_get_subjects.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceGetSubjects = new ServiceGetSubjects();

$json = $serviceGetSubjects->serve($db);

echo response_ok($json, time());

?> 