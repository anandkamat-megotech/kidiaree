<?php
include './components/component_slots.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_certificate_details.php';
include './services/service_create_certificate.php';
include './services/service_check_certificate_exists_in_table.php';
include './services/service_check_counselling_slots_in_table.php';
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
$serviceCheckCounsellingSlotsInTable = new ServiceCheckCounsellingSlotsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idCourse = "";
$idCourse = post_params("idCounselling");
$date = "";
$date = post_params("date");


//Get idUser of from usertokenmapping
// $zoomId = getSingleValue($db, "SELECT id FROM zoom_oauth WHERE coursesId like '%-:-$idCourse-:-%'", [$idCourse]);

$slots = $serviceCheckCounsellingSlotsInTable->serve($db, "slotsavailblecounselling", $idCourse, 3,$date);


echo response_ok(json_encode($slots) , time());

?> 