<?php

class ServiceNoCouponCheck{
    
    
    public function serve($db,  $idUser, $idCourseSelected, $isIndia) {

       

        $amount = 0;
        $offerPercentage=$maxAmount=$minAmount=$flatDiscount=$discountType=$usageType='Nil';

$cgstAmount = 0;
$cgstAmount = 0;



if($isIndia == "true"){

    foreach ($idCourseSelected as $courseSelected) {
        $amount1 = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$courseSelected]);
        $amount+=$amount1;

      }
    $cgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['cgst']);
    $sgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['sgst']);
    
   
   
    $finalAmount=$amount;


    $cgstAmount= ($finalAmount * $cgst)/100;

   $sgstAmount= ($finalAmount * $sgst)/100;


   $finalAmount = $finalAmount + $cgstAmount + $sgstAmount;
}
else{

    foreach ($idCourseSelected as $courseSelected) {
        $amount1 = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$courseSelected]);
        $amount+=$amount1;

      }
    


    $finalAmount=$amount;

}

return [$amount, $offerPercentage, $finalAmount, $maxAmount, $minAmount, $flatDiscount, $discountType, $usageType, $cgstAmount,$sgstAmount];
    }
    
}

?>