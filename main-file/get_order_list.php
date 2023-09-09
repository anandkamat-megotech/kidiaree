<?php

include './components/component_get_faculty.php';
include './services/service_base.php';
include './services/service_get_order_list.php';
include './services/service_check_token_validity.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

date_default_timezone_set(TIME_ZONE);
$serviceGetOrderList = new ServiceGetOrderList();
$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}


//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}



$json = $serviceGetOrderList->serve($db);

echo response_ok($json, time());

?> 