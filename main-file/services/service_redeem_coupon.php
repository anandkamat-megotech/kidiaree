<?php

class ServiceRedeemCoupon{
    
    
    public function serve($db, $couponCode, $idCampaign, $idUser) {

        $campaignValidity = getSingleValue($db, "SELECT validity FROM CampaignsMaster WHERE id = ?", [$idCampaign]);
        $currentdate = date('Y-m-d H:i:s');
        $couponExpiryDate = date('Y-m-d H:i:s', strtotime("+".$campaignValidity." days", strtotime($currentdate)));

        $couponExpiryTimestamp = strtotime($couponExpiryDate);

        $sql = "Update CouponsMaster SET idUser = $idUser where name = '$couponCode';";
        $statement = query_execute($db, $sql);

        $courses = getSingleValue($db, "SELECT courses FROM CampaignsMaster WHERE id = ?", [$idCampaign]);
        $json = json_decode($courses);

        

        for($i = 0; $i < sizeof($json); $i++){
            $idCourse = $json[$i] -> id;

            $sqlPayment = "Insert into UserCoursePaymentMapping (idUser, idCourse, idOrder, timestamp, expiryTimestamp) values ($idUser, $idCourse, '$couponCode', '".time()."', '$couponExpiryTimestamp');";

            $statement = query_execute($db, $sqlPayment);

        }
        
    }
    
}

?>