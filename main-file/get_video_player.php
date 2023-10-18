<?php

ob_start();

include './components/component_get_video_player.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_kpoint_get_video_player.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
ob_end_clean();

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceKPointGetVideoPlayer = new ServiceKPointGetVideoPlayer();


$idVideo = "";
$idVideo = get_params("idVideo");

$token = "";
$token = get_params("token");

$offset = 0;
if(isset($_GET["offset"])){
    $offset = get_params("offset");
}


$isIdVideoValid = $validatorString->validate($idVideo);

if(!$isIdVideoValid){
    echo response_parameters_invalid(time());
    return;
}

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get email of from usersmaster
$email = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);

//Get name of from usersmaster
$displayname = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);


$html = $serviceKPointGetVideoPlayer->serve($displayname, $email, $idVideo, $offset);

echo $html;

?>