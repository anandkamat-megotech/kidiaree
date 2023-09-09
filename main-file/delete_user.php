<?php
include './globals/constants_send_otp_email_db.php';
include './components/component_resend_otp.php';
include './services/service_base.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_otp_generate.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_email.php';
include './utilities/send_message.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$idUser = "";
$idUser = post_params("idUser");

//Check whether idUser is numeric or not
if(!is_numeric($idUser)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idUser exists or not
$rowCountUser = $serviceCheckRecordExistsInTable->serve($db, "usersmaster", $idUser);
if ($rowCountUser == 0) {
    echo response_not_found(time());
    return;
}

//Get email of from usersmaster
$userDeleteToken = getSingleValue($db, "DELETE FROM usertokenmapping WHERE idUser = ?", [$idUser]);
$userDelete = getSingleValue($db, "DELETE FROM usersmaster WHERE id = ?", [$idUser]);



echo '{"code": 200, "timestamp": '.time().', "body": {"message" : "User has been deleted"} }';


?> 