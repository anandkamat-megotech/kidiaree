<?php
include './components/component_slots.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_certificate_details.php';
include './services/service_create_certificate.php';
include './services/service_check_certificate_exists_in_table.php';
include './services/service_check_slots_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
insertCorsHeaders();

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCreateCertificate = new ServiceCreateCertificate();
$serviceGetCertificateDetails = new ServiceGetCertificateDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCheckCertificateExistsInTable = new ServiceCheckCertificateExistsInTable();
$serviceCheckSlotsInTable = new ServiceCheckSlotsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idCourse = "";
$idCourse = post_params("idCourse");
$date = "";
$date = post_params("date");


//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get idUser of from usertokenmapping
$zoomId = getSingleValue($db, "SELECT id FROM zoom_oauth WHERE coursesId like '%-:-$idCourse-:-%'", [$idCourse]);

$slots = $serviceCheckSlotsInTable->serve($db, "slotsavailble", $idCourse, $zoomId,$date);


echo response_ok(json_encode($slots) , time());

?> 