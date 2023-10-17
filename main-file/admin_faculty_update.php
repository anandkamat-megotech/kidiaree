<?php

include './components/component_admin_faculty_update.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_faculty_update.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_upload_to_cloud.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckValueExistsInTable = new ServiceCheckValueExistsInTable();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceAdminFacultyUpdate = new ServiceAdminFacultyUpdate();
$serviceUploadToCloud = new ServiceUploadToCloud();


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

$designation = "";
$designation = clean(post_params("designation"));

$info = "";
$info = clean(post_params("info"));

$isActive = "";
$isActive = post_params("isActive");

//Check whether id is numeric or not
if(!is_numeric($id)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether id exists or not
$rowCountId = $serviceCheckRecordExistsInTable->serve($db, "usersmaster", $id);
if ($rowCountId == 0) {
    echo response_not_found(time());
    return;
}

//Check whether faculty exists or not
$rowCountFacultyExist = $serviceCheckValueExistsInTable->serve($db, "FacultyMaster", "idUser", $id);
if ($rowCountFacultyExist == 0) {
    echo response_not_found(time());
    return;
}

$isNameValid = $validatorString->validate($name);

if(!$isNameValid){
    echo response_parameters_invalid(time());
    return;
}

$isDesignationValid = $validatorString->validate($designation);

if(!$isDesignationValid){
    echo response_parameters_invalid(time());
    return;
}

$isInfoValid = $validatorString->validate($info);

if(!$isInfoValid){
    echo response_parameters_invalid(time());
    return;
}

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

$profilePictureUrl = getSingleValue($db, "SELECT profilePictureUrl FROM usersmaster WHERE id = ?", [$id]);

if (!empty($_FILES['file']['name']))
{
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    $filename = 'profile_picture_'.$idUser.'_'.time().'.'.$ext;
    $uploaddir = "cache/";
    $uploadfile = $uploaddir . $filename;
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
    {
        echo response_parameters_invalid(time());
        return;
    }

    //upload file to google cloud storage
    $profilePictureUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, "profile_pictures");

}

$id = $serviceAdminFacultyUpdate->serve($db, $id, $name, $designation, $info, $profilePictureUrl, $isActive);

echo response_ok($id, time());

?> 