<?php

include './components/component_get_counselling_details.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_counselling_details.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceGetCounsellingDetails = new ServiceGetCounsellingDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idCounsellingSession = "";
$idCounsellingSession = post_params("idCounsellingSession");

//Check whether idCounsellingSession is numeric or not
if(!is_numeric($idCounsellingSession)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCounsellingSession exists or not
$rowCountCounsellingSession = $serviceCheckRecordExistsInTable->serve($db, "CounsellingSessions", $idCounsellingSession);
if ($rowCountCounsellingSession == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check id of Faculty from rolesmaster
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

//Check id of Admin from rolesmaster
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);


//Check role of user from usersmaster
$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);


if(($idRole != $idFacultyMaster) && ($idRole != $idAdminMaster)){
    echo response_unauthorized(time());
    return;
}

if ($idRole == $idFacultyMaster) {
    //Get idFaculty of from FacultyMaster
    $idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);

    //Get idFaculty of from CounsellingSessions
    $idFacultyCounsellingSessions = getSingleValue($db, "SELECT idFaculty FROM CounsellingSessions WHERE id = ?", [$idCounsellingSession]);

    if($idFaculty != $idFacultyCounsellingSessions){
        echo response_unauthorized(time());
        return;
    }
}


$json = $serviceGetCounsellingDetails->serve($db, $idCounsellingSession);

echo response_ok($json, time());

?> 