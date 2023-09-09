<?php

include './components/component_search_by_course.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_search_by_course.php';
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
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceAdminSearchByCourse = new ServiceAdminSearchByCourse();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}



$searchString = "";
$searchString = post_params("searchString");



//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}

$json = $serviceAdminSearchByCourse->serve($db, $searchString);

echo response_ok($json, time());

?> 