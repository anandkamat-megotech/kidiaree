<?php

include './components/component_admin_subject_update.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_subject_update.php';
include './services/service_check_record_exists_in_table.php';
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
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceAdminSubjectUpdate = new ServiceAdminSubjectUpdate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$id = "";
$id = post_params("id");

$name = "";
$name = post_params("name");

$description = "";
$description = clean(post_params("description"));

//Check whether id is numeric or not
if(!is_numeric($id)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether id exists or not
$rowCountId = $serviceCheckRecordExistsInTable->serve($db, "SubjectsMaster", $id);
if ($rowCountId == 0) {
    echo response_not_found(time());
    return;
}

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

$isActive = "";
$isActive = post_params("isActive");

//Check whether isActive is numeric or not
if(!is_numeric($isActive)){
    echo response_parameters_invalid(time());
    return;
}

if($isActive != 0 && $isActive != 1){
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

$subjectImageUrl = getSingleValue($db, "SELECT imageUrl FROM SubjectsMaster WHERE id = ?", [$id]);

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
}

$id = $serviceAdminSubjectUpdate->serve($db, $id, $name, $description, $subjectImageUrl, $isActive);

echo response_ok($id, time());

?> 