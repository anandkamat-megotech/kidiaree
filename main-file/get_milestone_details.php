<?php

include './components/component_get_milestone_details.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_milestone_details.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetMilestoneDetails = new serviceGetMilestoneDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$id = "";
$id = post_params("id");

//Check whether id is numeric or not
if(!is_numeric($id)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether id exists or not
$rowCountId = $serviceCheckRecordExistsInTable->serve($db, "MilestonesMaster", $id);
if ($rowCountId == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

//Check whether user is Faculty or not
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if(($idRole != $idAdminMaster) && ($idRole != $idFacultyMaster)){
    echo response_unauthorized(time());
    return;
}

$json = $serviceGetMilestoneDetails->serve($db, $id);

echo response_ok(json_encode($json), time());

?> 