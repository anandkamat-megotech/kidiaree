<?php

include './components/component_is_profile_set.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);


//Get address of from useraddressmapping
$idAddress = getSingleValue($db, "SELECT id FROM useraddressmapping WHERE idUser = ?", [$idUser]);

//Check whether idaddress exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "useraddressmapping", $idAddress);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}





//Get isProfile of from usersmaster
$isProfileSet = getSingleValue($db, "SELECT isProfileSet FROM usersmaster WHERE id = ?", [$idUser]);

echo response_ok($isProfileSet, time());

?> 