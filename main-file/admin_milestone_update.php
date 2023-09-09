<?php

include './components/component_admin_milestone_update.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_milestone_update.php';
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
$serviceAdminMilestoneUpdate = new ServiceAdminMilestoneUpdate();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idMilestone = "";
$idMilestone = post_params("idMilestone");

//Check whether idMilestone is numeric or not
if(!is_numeric($idMilestone)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idMilestone exists or not
$rowCountIdMilestone = $serviceCheckRecordExistsInTable->serve($db, "MilestonesMaster", $idMilestone);
if ($rowCountIdMilestone == 0) {
    echo response_not_found(time());
    return;
}

$milestoneName = "";
$milestoneName = post_params("milestoneName");

$isMilestoneNameValid = $validatorString->validate($milestoneName);

if(!$isMilestoneNameValid){
    echo response_parameters_invalid(time());
    return;
}

$sessionName = "";
$sessionName = post_params("sessionName");

$isSessionNameValid = $validatorString->validate($sessionName);

if(!$isSessionNameValid){
    echo response_parameters_invalid(time());
    return;
}

$sessionDescription = "";
$sessionDescription = post_params("sessionDescription");

$isSessionDescriptionValid = $validatorString->validate($sessionDescription);

if(!$isSessionDescriptionValid){
    echo response_parameters_invalid(time());
    return;
}

$sessionDescription = str_replace("'", "\'", $sessionDescription);

$sessionVideo = "";
$sessionVideo = post_params("sessionVideo");



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

$idCourse = "";
$idCourse = post_params("idCourse");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountIdCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountIdCourse == 0) {
    echo response_not_found(time());
    return;
}

$assignmentTitle = "";
$assignmentTitle = post_params("assignmentTitle");

$isAssignmentTitleValid = $validatorString->validate($assignmentTitle);

if(!$isAssignmentTitleValid){
    echo response_parameters_invalid(time());
    return;
}

$assignmentDescription = "";
$assignmentDescription = clean(post_params("assignmentDescription"));

$isAssignmentDescriptionValid = $validatorString->validate($assignmentDescription);

if(!$isAssignmentDescriptionValid){
    echo response_parameters_invalid(time());
    return;
}

$assignmentQuizUrl = "";
$assignmentQuizUrl = post_params("assignmentQuizUrl");

$sessionThumbnailUrl = "";
$sessionThumbnailUrl = post_params("sessionThumbnailUrl");



$assignmentHandoutUrl = getSingleValue($db, "SELECT attachmentUrl FROM AssignmentsMaster WHERE idMilestone = ?", [$idMilestone]);;

if (!empty($_FILES['file']['name']))
{
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    $filename = 'assignment_handout_'.$assignmentTitle.'_'.$milestoneName.'_'.time().'.'.$ext;
    $uploaddir = "cache/";
    $uploadfile = $uploaddir . $filename;
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
    {
        echo response_parameters_invalid(time());
        return;
    }

    //upload file to google cloud storage
    $assignmentHandoutUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, "assignments");

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


$id = $serviceAdminMilestoneUpdate->serve($db, $idMilestone, $milestoneName, $sessionName, $sessionDescription, $sessionVideo, $idFaculty, $assignmentTitle, $assignmentDescription, $assignmentQuizUrl, $sessionThumbnailUrl, $assignmentHandoutUrl, $idCourse);

echo response_ok($id, time());

?> 