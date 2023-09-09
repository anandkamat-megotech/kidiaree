<?php

class ServiceRedeemCouponMultiuseCheck{
    
    
    public function serve($db, $couponCode, $idCampaign, $idUser, $idCourseSelected, $isIndia) {

        /*$campaignValidity = getSingleValue($db, "SELECT validity FROM CampaignsMaster WHERE id = ?", [$idCampaign]);
        $currentdate = date('Y-m-d H:i:s');
        $couponExpiryDate = date('Y-m-d H:i:s', strtotime("+".$campaignValidity." days", strtotime($currentdate)));

        $couponExpiryTimestamp = strtotime($couponExpiryDate);

        $sql = "Update CouponsMaster SET idUser = $idUser, idCourse = $idCourseSelected where idCampaign = '$idCampaign' and idUser IS NULL order by idCampaign LIMIT 1";
       echo $sql;
        $statement = query_execute($db, $sql);

        $courses = getSingleValue($db, "SELECT courses FROM CampaignsMaster WHERE id = ?", [$idCampaign]);
        $json = json_decode($courses);*/

        

        /*for($i = 0; $i < sizeof($json); $i++){
            $idCourse = $json[$i] -> id;
            $idCourse = $json[$i] -> id;

            $sqlPayment = "Insert into UserCoursePaymentMapping (idUser, idCourse, idOrder, timestamp, expiryTimestamp) values ($idUser, $idCourse, '$couponCode', '".time()."', '$couponExpiryTimestamp');";

            $statement = query_execute($db, $sqlPayment);

        }*/

        $amount = 0;
$offerPercentage = 0;
$maxAmountInr = 0;
$maxAmountUsd = 0;

$minAmountInr = 0;
$minAmountUsd = 0;

$maxAmount = 0;
$minAmount = 0;

$flatDiscountInr = 0;
$flatDiscountUsd = 0;

$flatDiscount = 0;

$discountType = '';
$usageType = '';

$cgstAmount = 0;
$cgstAmount = 0;

$sql = "Select CampaignsMaster.offerPercentage as offerPercentage, CampaignsMaster.maxAmountInr as maxAmountInr, CampaignsMaster.maxAmountUsd as maxAmountUsd, CampaignsMaster.flatDiscountInr as flatDiscountInr, CampaignsMaster.flatDiscountUsd as flatDiscountUsd,CampaignsMaster.minAmountInr as minAmountInr, CampaignsMaster.minAmountUsd as minAmountUsd, CampaignsMaster.discountType as discountType, CampaignsMaster.usageType as usageType  from CampaignsMaster WHERE CampaignsMaster.id = $idCampaign;";
//echo $sql;
$statement = query_execute($db, $sql);
$result = $statement->fetchAll(\PDO::FETCH_ASSOC);


for ($i=0; $i < count($result) ; $i++) { 
    $offerPercentage =  $result[$i]['offerPercentage'];
    //echo $offerPercentage;
    $maxAmountInr =  $result[$i]['maxAmountInr'];
    $maxAmountUsd =  $result[$i]['maxAmountUsd'];

    $flatDiscountInr =  $result[$i]['flatDiscountInr'];
    $flatDiscountUsd =  $result[$i]['flatDiscountUsd'];

    $minAmountInr =  $result[$i]['minAmountInr'];
    $minAmountUsd =  $result[$i]['minAmountUsd'];

    $discountType =  $result[$i]['discountType'];
    $usageType =  $result[$i]['usageType'];
    
}

if($isIndia == "true"){
    //Get amount of from CoursesMaster
    //$amount = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$idCourseSelected]);
    foreach ($idCourseSelected as $courseSelected) {
        $amount1 = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$courseSelected]);
        $amount+=$amount1;
       // echo $amount;
      }
      $cgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['cgst']);
      $sgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['sgst']);
    
    $maxAmount=$maxAmountInr;
    $minAmount=$minAmountInr;
    $flatDiscount=$flatDiscountInr;
   /* $amount = $amount * 100;*/
   if($minAmountInr<=$amount)
   {
   if($discountType == "Percentage")
   {
    $offerAmount= ($amount * $offerPercentage) / 100;
    if($offerAmount > $maxAmountInr &&  $maxAmountInr > 0)
    {
        $reducedAmount=$maxAmountInr;
        //echo $reducedAmount;
    }
    else
    {
        $reducedAmount=$offerAmount;
        //echo $reducedAmount;
    }
    $finalAmount=($amount-$reducedAmount);
}
if($discountType == "Flat")
   {
    $flatOfferAmount= $flatDiscountInr;
    $reducedAmount=$flatOfferAmount;
    $finalAmount=($amount-$reducedAmount);
    }

    if($finalAmount <= 0)
    {
        $finalAmount=0;
    }
}
else{
    $finalAmount=$amount;

    if($finalAmount <= 0)
    {
        $finalAmount=0;
    }
}
   $cgstAmount= ($finalAmount * $cgst)/100;
   //echo $cgstAmount;
   $sgstAmount= ($finalAmount * $sgst)/100;
   //echo $sgstAmount;

   $finalAmount = $finalAmount + $cgstAmount + $sgstAmount;
   //echo $finalAmount;

}
else{
    //Get amount of from CoursesMaster
    //$amount = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$idCourseSelected]);
    foreach ($idCourseSelected as $courseSelected) {
        $amount1 = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$courseSelected]);
        $amount+=$amount1;
       // echo $amount;
      }
    $maxAmount=$maxAmountUsd;
    $minAmount=$minAmountUsd;
    $flatDiscount=$flatDiscountUsd;
   // $amount = $amount * 100;
   if($minAmountUsd<=$amount)
   {
   if($discountType == "Percentage")
   {
    $offerAmount= ($amount * $offerPercentage) / 100;
    if($offerAmount > $maxAmountUsd && $maxAmountUsd > 0)
    {
        $reducedAmount=$maxAmountUsd;
    }
    else
    {
        $reducedAmount=$offerAmount;
    }
    $finalAmount=($amount-$reducedAmount);
   }
    if($discountType == "Flat")
   {
    $flatOfferAmount= $flatDiscountUsd;
    $reducedAmount=$flatOfferAmount;
    $finalAmount=($amount-$reducedAmount);
    }

    if($finalAmount <= 0)
    {
        $finalAmount=0;
    }
}
else{
    $finalAmount=$amount;

    if($finalAmount <= 0)
    {
        $finalAmount=0;
    }
}
}

return [$amount, $offerPercentage, $finalAmount, $maxAmount, $minAmount, $flatDiscount, $discountType, $usageType, $cgstAmount,$sgstAmount];
    }
    
}
        
   
?>