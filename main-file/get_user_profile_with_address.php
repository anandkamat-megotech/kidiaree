<?php

include './components/component_get_user_profile.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_user_profile_with_address.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetUserProfileWithAddress = new ServiceGetUserProfileWithAddress();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$json = $serviceGetUserProfileWithAddress->serve($db, $idUser);

echo response_ok($json, time());

?> 