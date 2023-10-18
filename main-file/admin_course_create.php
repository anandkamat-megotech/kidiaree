<?php

include './components/component_admin_course_create.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_course_create.php';
include './services/service_upload_to_cloud.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceUploadToCloud = new ServiceUploadToCloud();
$serviceAdminCourseCreate = new ServiceAdminCourseCreate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$name = "";
$name = clean(post_params("name"));

$isNameValid = $validatorString->validate($name);

if(!$isNameValid){
    echo response_parameters_invalid(time());
    return;
}

$info = "";
$info = clean(post_params("info"));

$isInfoValid = $validatorString->validate($info);

if(!$isInfoValid){
    echo response_parameters_invalid(time());
    return;
}

$intro = "";
$intro = clean(post_params("intro"));

$isIntroValid = $validatorString->validate($intro);

if(!$isIntroValid){
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

$filename = $filename = $name.'_course_image_'.time().'.jpg';
$uploaddir = "cache/";
$uploadfile = $uploaddir . $filename;
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
{
    echo response_parameters_invalid(time());
    return;
}


//upload file to google cloud storage
$courseImageUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, '');

$id = $serviceAdminCourseCreate->serve($db, $name, $info, $intro, $courseImageUrl);

echo response_ok($id, time());

?> 