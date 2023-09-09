<?php

class ServiceAdminCampaignCreate{
    
    
    public function serve($db, $name, $bucketSize, $courses, $redeemExpiryTimestamp, $validity, $offerPercentage, $maxAmountInr, $maxAmountUsd, $flatDiscountInr, $flatDiscountUsd, $discountType, $usageType, $minAmountInr, $minAmountUsd) {

        $coursesJSON = json_encode($courses);
        $sql = "Insert into CampaignsMaster (name, bucketSize, courses, redeemExpiryTimestamp, validity, offerPercentage, maxAmountInr, maxAmountUsd, flatDiscountInr, flatDiscountUsd, discountType, usageType, minAmountInr, minAmountUsd) values ('$name', $bucketSize, '$coursesJSON', '$redeemExpiryTimestamp', $validity, $offerPercentage, $maxAmountInr, $maxAmountUsd, $flatDiscountInr, $flatDiscountUsd, '$discountType', '$usageType', $minAmountInr, $minAmountUsd);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $id = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE name = ? ORDER BY id DESC LIMIT 1", [$name]);

        if($usageType == "Singleuse")
        {
            for($i = 0; $i < $bucketSize; $i++){
               $couponName = uniqid($name."_", false);

               $sqlCoupon = "Insert into CouponsMaster (name, idCampaign) values ('$couponName', $id);";
               $statementCoupon = query_execute($db, $sqlCoupon);
               $resultCoupon = $statementCoupon->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
		return $id;
       
    }
    
}

?>