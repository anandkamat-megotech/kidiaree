<?php

include './components/component_search_by_subject.php';
include './services/service_base.php';
include './services/service_search_by_subject.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
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
$serviceSearchBySubject = new ServiceSearchBySubject();


$searchString = "";
$searchString = post_params("searchString");



$json = $serviceSearchBySubject->serve($db, $searchString);

echo response_ok($json, time());

?> 