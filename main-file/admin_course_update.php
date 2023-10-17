<?php

include './components/component_admin_course_update.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_course_update.php';
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
$serviceUploadToCloud = new ServiceUploadToCloud();
$serviceAdminCourseUpdate = new ServiceAdminCourseUpdate();
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
$rowCountIdCount = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $id);
if ($rowCountIdCount == 0) {
    echo response_not_found(time());
    return;
}

$name = "";
$name = post_params("name");

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

$introVideoUrl = "";
$introVideoUrl = post_params("introVideoUrl");

$isIntroVideoUrlValid = $validatorString->validate($introVideoUrl);

if(!$isIntroVideoUrlValid){
    echo response_parameters_invalid(time());
    return;
}

$idFaculty = "";
$idFaculty = post_params("idFaculty");

//Check whether idFaculty is numeric or not
if(!is_numeric($idFaculty)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idFaculty exists or not
$rowCountIdFaculty = $serviceCheckRecordExistsInTable->serve($db, "FacultyMaster", $idFaculty);
if ($rowCountIdFaculty == 0) {
    echo response_not_found(time());
    return;
}

$idTa = "";
$idTa = post_params("idTa");

//Check whether idTa is numeric or not
if(!is_numeric($idTa)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idTa exists or not
$rowCountIdTa = $serviceCheckRecordExistsInTable->serve($db, "FacultyMaster", $idTa);
if ($rowCountIdTa == 0) {
    echo response_not_found(time());
    return;
}

$idSubject = "";
$idSubject = post_params("idSubject");

//Check whether idSubject is numeric or not
if(!is_numeric($idSubject)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idSubject exists or not
$rowCountIdSubject = $serviceCheckRecordExistsInTable->serve($db, "SubjectsMaster", $idSubject);
if ($rowCountIdSubject == 0) {
    echo response_not_found(time());
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

$subjectImageUrl = getSingleValue($db, "SELECT imageUrl FROM CoursesMaster WHERE id = ?", [$id]);
if (!empty($_FILES['file']['name']))
{
    $filename = $name.'_course_image_'.time().'.jpg';

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

$amount = "";
$amount = post_params("amount");

//Check whether amount is numeric or not
if(!is_numeric($amount)){
    echo response_parameters_invalid(time());
    return;
}

$amountUsd = "";
$amountUsd = post_params("amountUsd");

//Check whether amountUsd is numeric or not
if(!is_numeric($amountUsd)){
    echo response_parameters_invalid(time());
    return;
}

$idLevel = "";
$idLevel = post_params("idLevel");

//Check whether idLevel is numeric or not
if(!is_numeric($idLevel)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idLevel exists or not
$rowCountIdLevel = $serviceCheckRecordExistsInTable->serve($db, "LevelsMaster", $idLevel);
if ($rowCountIdLevel == 0) {
    echo response_parameters_invalid(time());
    return;
}

$duration = "";
$duration = post_params("duration");

$isDurationValid = $validatorString->validate($duration);

if(!$isDurationValid){
    echo response_parameters_invalid(time());
    return;
}

$learn = "";
$learn = "[{\"Key\":\"no need\"}]";

$isLearnValid = $validatorString->validate($learn);

if(!$isLearnValid){
    echo response_parameters_invalid(time());
    return;
}

if(!isJson(json_encode($learn))){
    echo response_parameters_invalid(time());
    return;
}

$isFeatured = "";
$isFeatured = post_params("isFeatured");

//Check whether isFeatured is numeric or not
if(!is_numeric($isFeatured)){
    echo response_parameters_invalid(time());
    return;
}

if($isFeatured != 0 && $isFeatured != 1){
    echo response_parameters_invalid(time());
    return;
}

$introThumbnailUrl = getSingleValue($db, "SELECT introThumbnailUrl FROM CoursesMaster WHERE id = ?", [$id]);
if (!empty($_FILES['introThumbnail']['name']))
{
    $filename = $name.'_course_intro_thumbnail_image_'.time().'.jpg';

    $uploaddir = "cache/";
    $uploadfile = $uploaddir . $filename;
    $ext = pathinfo($_FILES['introThumbnail']['name'], PATHINFO_EXTENSION);
    
    if(!move_uploaded_file($_FILES['introThumbnail']['tmp_name'], $uploadfile))
    {
        echo response_parameters_invalid(time());
        return;
    }
    
    //upload file to google cloud storage
    $introThumbnailUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, '');
    $introThumbnailUrl = str_replace(' ', '%20', $introThumbnailUrl);
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


$id = $serviceAdminCourseUpdate->serve($db, $id, $name, $info, $intro, $introVideoUrl, $idFaculty, $idTa, $idSubject, $isActive, $subjectImageUrl, $amount, $amountUsd, $idLevel, $duration, $learn, $isFeatured,  $introThumbnailUrl);

echo response_ok($id, time());

function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

?> 