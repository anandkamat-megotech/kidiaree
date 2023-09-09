<?php

include './components/component_redeem_coupon_check.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_redeem_coupon_multiuse_check.php';
include './utilities/authorization.php';
include './utilities/post_parameters.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceRedeemCouponMultiuseCheck = new ServiceRedeemCouponMultiuseCheck();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$validatorString = new ValidatorString();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$isIndia = "";
$isIndia = post_params("isIndia");


$idCourses=[];
$idCourses = post_params("idCourses");
$idCourses= json_encode($idCourses);
$idCourses = json_decode($idCourses);


$couponCode = "";
$couponCode = post_params("couponCode");

$isCouponCodeNonEmpty = $validatorString->validate($couponCode);

if(!$isCouponCodeNonEmpty){
    echo response_parameters_invalid(time());
    return;
}


//Check whether campaign is still valid or not
$idCampaign = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE name = ?", [$couponCode]);

$campaignRedeemExpiryTimestamp = getSingleValue($db, "SELECT redeemExpiryTimestamp FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

if(time() > $campaignRedeemExpiryTimestamp){
    echo response_campaign_ended(time());
    return;
}




$j=0;
for($f = 0; $f < count($idCourses); $f++){
    $idCourse=$idCourses[$f];
    //Check whether idCourse is numeric or not
    if(!is_numeric($idCourse)){
        echo response_parameters_invalid(time());
        return;
    }
    //Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Check whether course is in Campaign  or not
$courses = getSingleValue($db, "SELECT courses FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

        $json = json_decode($courses);
        
        for($i = 0; $i < sizeof($json); $i++){
            $idCourseCamapaign = $json[$i] -> id;
            if($idCourseCamapaign==$idCourse)
            {
               $j++;
               $idCourseSelected[]=$idCourseCamapaign;
               
            }
            
        }
       

}

if($j != count($idCourseSelected)){
    echo response_campaign_course_not_available(time());
    return;
}


$isIndiaNonEmpty = $validatorString->validate($isIndia);

if(!$isIndiaNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

if ($isIndia != "true" && $isIndia != "false") {
    echo response_parameters_invalid(time());
    return;
}



//Check whether coupon code is present or not
$id = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE name = ?", [$couponCode]);

if($id == ''){
    echo response_not_found(time());
    return;
}




//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether coupon code is claimed or not
$idCoupon = getSingleValue($db, "SELECT idUser FROM CouponsMaster WHERE idCampaign = ? AND idUser = ?", [$idCampaign, $idUser]);

if($idCoupon != ''){
    echo response_already_redeemed(time());
    return;
}

//Check whether bucket is full or not
$idCoupons = getSingleValue($db, "SELECT count(*) FROM CouponsMaster WHERE idCampaign = ? and idUser IS NOT ?", [$idCampaign, NULL]);
$bucketSize = getSingleValue($db, "SELECT bucketSize FROM CampaignsMaster WHERE id = ?", [$idCampaign]);
if($idCoupons == $bucketSize){
    echo response_bucket_full(time());
    return;
}

$check = $serviceRedeemCouponMultiuseCheck->serve($db, $couponCode, $idCampaign, $idUser, $idCourseSelected, $isIndia);

echo response_ok($check[0], $check[1], $check[2], $check[3], $check[4], $check[5], $check[6], $check[7], $check[8], $check[9], time());

?> 