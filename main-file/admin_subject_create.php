<?php

include './components/component_admin_subject_create.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_subject_create.php';
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
$serviceAdminSubjectCreate = new ServiceAdminSubjectCreate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$name = "";
$name = post_params("name");

$description = "";
$description = clean(post_params("description"));

$isNameValid = $validatorString->validate($name);

if(!$isNameValid){
    echo response_parameters_invalid(time());
    return;
}

$isDescriptionValid = $validatorString->validate($description);

if(!$isDescriptionValid){
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

if (!empty($_FILES['file']['name']))
{
    $filename = $name.'_subject_image_'.time().'.jpg';

    $uploaddir = "cache/";
    $uploadfile = $uploaddir . $filename;
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
    {
        echo response_parameters_invalid(time());
        return;
    }
    
    //upload file to google cloud storage
    $subjectImageUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, '');
}else{
    echo response_parameters_invalid(time());
    return;
}



$id = $serviceAdminSubjectCreate->serve($db, $name, $description, $subjectImageUrl);

echo response_ok($id, time());

?> 