<?php

include './components/component_redeem_coupon.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_redeem_coupon.php';
include './utilities/authorization.php';
include './utilities/post_parameters.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceRedeemCoupon = new ServiceRedeemCoupon();
$validatorString = new ValidatorString();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$couponCode = "";
$couponCode = post_params("couponCode");

$isCouponCodeNonEmpty = $validatorString->validate($couponCode);

if(!$isCouponCodeNonEmpty){
    echo response_parameters_invalid(time());
    return;
}



//Check whether coupon code is present or not
$id = getSingleValue($db, "SELECT id FROM CouponsMaster WHERE name = ?", [$couponCode]);

if($id == ''){
    echo response_not_found(time());
    return;
}

//Check whether campaign is still valid or not
$idCampaign = getSingleValue($db, "SELECT idCampaign FROM CouponsMaster WHERE name = ?", [$couponCode]);

$campaignRedeemExpiryTimestamp = getSingleValue($db, "SELECT redeemExpiryTimestamp FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

if(time() > $campaignRedeemExpiryTimestamp){
    echo response_campaign_ended(time());
    return;
}

//Check whether coupon code is claimed or not
$idUser = getSingleValue($db, "SELECT idUser FROM CouponsMaster WHERE name = ?", [$couponCode]);

if($idUser != ''){
    echo response_already_redeemed(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);


$serviceRedeemCoupon->serve($db, $couponCode, $idCampaign, $idUser);

echo response_ok($id, time());

?> 