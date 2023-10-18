<?php

include './components/component_admin_faculty_search.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_faculty_search.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceAdminFacultySearch = new ServiceAdminFacultySearch();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}


$searchString = "";
$searchString = post_params("searchString");

// $isSearchStringValid = $validatorString->validate($searchString);

// if(!$isSearchStringValid){
//     echo response_parameters_invalid(time());
//     return;
// }

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}

$json = $serviceAdminFacultySearch->serve($db, $searchString);

echo response_ok($json, time());

?> 