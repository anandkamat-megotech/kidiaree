<?php

include './components/component_admin_get_campaign_details.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_get_campaign_details.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceAdminGetCampaignDetails = new ServiceAdminGetCampaignDetails();
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
$rowCountId = $serviceCheckRecordExistsInTable->serve($db, "CampaignsMaster", $id);
if ($rowCountId == 0) {
    echo response_not_found(time());
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


$json = $serviceAdminGetCampaignDetails->serve($db, $id);

echo response_ok($json, time());

?> 