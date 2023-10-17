<?php

class ServiceRedeemCouponCheck{
    
    
    public function serve($db, $couponCode, $idCampaign, $idUser, $idCourseSelected, $isIndia) {

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
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        for ($i=0; $i < count($result) ; $i++) { 

              $offerPercentage =  $result[$i]['offerPercentage'];
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

          foreach ($idCourseSelected as $courseSelected) {
              $amount1 = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$courseSelected]);
              $amount+=$amount1;
           }
          $cgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['cgst']);
          $sgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['sgst']);    
          $maxAmount=$maxAmountInr;
          $minAmount=$minAmountInr;
          $flatDiscount=$flatDiscountInr;
          if($minAmountInr<=$amount){
             if($discountType == "Percentage"){
                 $offerAmount= ($amount * $offerPercentage) / 100;
                  if($offerAmount > $maxAmountInr &&  $maxAmountInr > 0){
                     $reducedAmount=$maxAmountInr;
                    }
                  else{
                     $reducedAmount=$offerAmount;
                    }
                  $finalAmount=($amount-$reducedAmount);       
                }
             if($discountType == "Flat"){
                 $flatOfferAmount= $flatDiscountInr;
                 $reducedAmount=$flatOfferAmount;
                 $finalAmount=($amount-$reducedAmount);
                }
             if($finalAmount <= 0){
                 $finalAmount=0;
                }
            }
            else{
               $finalAmount=$amount;
               if($finalAmount <= 0){
                  $finalAmount=0;
                }
            }

            $cgstAmount= ($finalAmount * $cgst)/100;
            $sgstAmount= ($finalAmount * $sgst)/100;
            $finalAmount = $finalAmount + $cgstAmount + $sgstAmount;
        }
        else{
    
            foreach ($idCourseSelected as $courseSelected) {
               $amount1 = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$courseSelected]);
               $amount+=$amount1;
            }
            $maxAmount=$maxAmountUsd;
            $minAmount=$minAmountUsd;
            $flatDiscount=$flatDiscountUsd;
            if($minAmountUsd<=$amount){
              if($discountType == "Percentage"){
                 $offerAmount= ($amount * $offerPercentage) / 100;
                 if($offerAmount > $maxAmountUsd && $maxAmountUsd > 0){
                     $reducedAmount=$maxAmountUsd;
                    }
                 else{
                     $reducedAmount=$offerAmount;
                    }
                 $finalAmount=($amount-$reducedAmount);

                }
               if($discountType == "Flat"){
                  $flatOfferAmount= $flatDiscountUsd;
                  $reducedAmount=$flatOfferAmount;
                  $finalAmount=($amount-$reducedAmount);
                }
               if($finalAmount <= 0){
                  $finalAmount=0;
                }
            }
            else{
               $finalAmount=$amount;
               if($finalAmount <= 0){
                 $finalAmount=0;
                }
            }
        }

       return [$amount, $offerPercentage, $finalAmount, $maxAmount, $minAmount, $flatDiscount, $discountType, $usageType, $cgstAmount,$sgstAmount];
    }
    
}

?>