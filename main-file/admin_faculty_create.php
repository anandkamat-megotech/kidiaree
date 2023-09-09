<?php

include './components/component_admin_faculty_create.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_faculty_create.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceAdminFacultyCreate = new ServiceAdminFacultyCreate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$name = "";
$name = post_params("name");

$email = "";
$email = post_params("email");

if(!$validatorString->checkemail($email)){
    echo response_parameters_invalid_email(time());
    return;
}

$isNameValid = $validatorString->validate($name);

if(!$isNameValid){
    echo response_parameters_invalid(time());
    return;
}

$isEmailValid = $validatorString->validate($email);

if(!$isEmailValid){
    echo response_parameters_invalid(time());
    return;
}

if(!validateEmail($email)){
    echo response_parameters_invalid(time());
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

$id = $serviceAdminFacultyCreate->serve($db, $name, $email);

echo response_ok($id, time());


function validateEmail($email) {
    if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
        
    }
}

?> 