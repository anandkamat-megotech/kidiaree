<?php

include './components/component_get_user_profile.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_delete_user_profile_pic.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceDeleteUserProfilePic = new ServiceDeleteUserProfilePic();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);
// $profilePictureUrl = getSingleValue($db, "SELECT profilePictureUrl FROM usersmaster WHERE id = ?", [$idUser]);
// $array_profile = explode("/",$profilePictureUrl);
// if(!empty($array_profile)){
//     if($array_profile[5] != 'profile_picture_71_1671705548.JPEG') {
//         $file_delete = $serviceDeleteUserProfilePic->delete_object($array_profile[3], $array_profile[4].'/'.$array_profile[5]);
//     }
// }
$serviceDeleteUserProfilePic->serve($db, $idUser);

echo response_ok_updated(time());

?> 