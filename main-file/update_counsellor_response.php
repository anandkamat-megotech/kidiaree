<?php

include './components/component_update_counsellor_response.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_counsellor_response.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceUpdateCounsellorResponse = new serviceUpdateCounsellorResponse();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idCounselling = "";
$idCounselling= post_params("idCounselling");

$counsellorResponse = "";
$counsellorResponse = post_params("counsellorResponse");

//Check whether idSchedule is numeric or not
if(!is_numeric($idCounselling)){
    echo response_parameters_invalid(time());
    return;
}


$isCounsellorResponseValid = $validatorString->validate($counsellorResponse);

if(!$isCounsellorResponseValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idSchedule exists or not
$rowCountSchedule = $serviceCheckRecordExistsInTable->serve($db, "CounsellingSessions", $idCounselling);
if ($rowCountSchedule == 0) {
    echo response_not_found(time());
    return;
}



//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);


//Check whether user is Admin or not
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idFacultyMaster){
    echo response_unauthorized(time());
    return;
}


$resTimeStamp = $serviceUpdateCounsellorResponse->serve($db, $idCounselling, $counsellorResponse);


    
 echo response_ok(time());




?> 