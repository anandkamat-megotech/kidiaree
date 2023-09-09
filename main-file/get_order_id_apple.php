<?php
include 'razorpay-php/Razorpay.php';
include './components/component_get_order_id.php';
include './globals/constants_user_enrolled_email_db.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_redeem_coupon_check.php';
include './services/service_redeem_coupon_multiuse_check.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_order_id.php';
include './services/service_zero_amount_process.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetOrderId = new ServiceGetOrderId();
$serviceZeroAmountProcess = new ServiceZeroAmountProcess();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$validatorString = new ValidatorString();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$isIndia = "";
$isIndia = post_params("isIndia");


$couponCode = "";
$couponCode = post_params("couponCode");

$usageType = "";
$usageType = post_params("usageType");

$discountType = "";
$discountType = post_params("discountType");



$idCourses=[];
$idCourses = post_params("idCourses");
$idCourses= json_encode($idCourses);
$idCourses = json_decode($idCourses);
        


$a="true";
$b="true";
$c="true";
$d="true";



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

   //Check whether user has already enrolled for the course or not
   $idUserCoursePayment = getSingleValue($db, "SELECT id FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ? AND expiryTimestamp > ?", [$idUser, $idCourse, time()]);

   if($idUserCoursePayment != NULL){
      echo response_already_enrolled(time());
      return;
    }

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


if($usageType == "Singleuse")
{
    //Check whether coupon code is present or not
    $id = getSingleValue($db, "SELECT id FROM CouponsMaster WHERE name = ?", [$couponCode]);

    if($id == ''){
      $a="false";     
    }

  //Check whether campaign is still valid or not
  $idCampaign = getSingleValue($db, "SELECT idCampaign FROM CouponsMaster WHERE name = ?", [$couponCode]);

  $campaignRedeemExpiryTimestamp = getSingleValue($db, "SELECT redeemExpiryTimestamp FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

  if(time() > $campaignRedeemExpiryTimestamp){
       $b="false";       
    }

   //Check whether coupon code is claimed or not
   $idUserCoupon = getSingleValue($db, "SELECT idUser FROM CouponsMaster WHERE name = ?", [$couponCode]);

   if($idUserCoupon != ''){
        $c="false";
    
    }

   $j=0;
   for($k = 0; $k < count($idCourses); $k++){
       $idCourse=$idCourses[$k];
      //Check whether course is in Campaign  or not
      $courses = getSingleValue($db, "SELECT courses FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

        $json = json_decode($courses);
        
        for($m = 0; $m < sizeof($json); $m++){
            $idCourseCamapaign = $json[$m] -> id;
            if($idCourseCamapaign==$idCourse)
            {
               $j++;
               $idCourseSelected[]=$idCourseCamapaign;
               
            }
            
        }
       
        if($j != count($idCourseSelected)){
            $d="false";
        }
    }
}

if($usageType == "Multiuse")
{
    //Check whether coupon code is present or not
    $id = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE name = ?", [$couponCode]);

    if($id == ''){
       $a="false";
     
    }

    //Check whether campaign is still valid or not
    $idCampaign = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE name = ?", [$couponCode]);

    $campaignRedeemExpiryTimestamp = getSingleValue($db, "SELECT redeemExpiryTimestamp FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

    if(time() > $campaignRedeemExpiryTimestamp){
      $b="false";   
   
    }
   //Check whether coupon code is claimed or not
   $idUserCoupon = getSingleValue($db, "SELECT idUser FROM CouponsMaster WHERE idCampaign = ? AND idUser = ?", [$idCampaign, $idUser]);

   if($idUserCoupon != ''){
       $c="false";  
    }

   //Check whether course is in Campaign  or not
   $j=0;
   for($k = 0; $k < count($idCourses); $k++){
       $idCourse=$idCourses[$k];
       //Check whether course is in Campaign  or not
       $courses = getSingleValue($db, "SELECT courses FROM CampaignsMaster WHERE id = ?", [$idCampaign]);

        $json = json_decode($courses);
        
        for($m = 0; $m < sizeof($json); $m++){
            $idCourseCamapaign = $json[$m] -> id;
            if($idCourseCamapaign==$idCourse)
            {
               $j++;
               $idCourseSelected[]=$idCourseCamapaign;
               
            }
            
        }
       
        if($j != count($idCourseSelected)){
            $d="false";
            
        }
    }

}

$amount = 0;

if($a=="true" && $b=="true" && $c=="true" && $d =="true" && $usageType!="" && $couponCode!="")
{

$offerPercentage = 0;
$maxAmountInr = 0;
$maxAmountUsd = 0;
$discountType = '';
$flatDiscountInr = 0;
$flatDiscountUsd = 0;
$cgstAmount = 0;
$cgstAmount = 0;

$sql = "Select CampaignsMaster.offerPercentage as offerPercentage, CampaignsMaster.maxAmountInr as maxAmountInr, CampaignsMaster.maxAmountUsd as maxAmountUsd, CampaignsMaster.minAmountInr as minAmountInr, CampaignsMaster.minAmountUsd as minAmountUsd, CampaignsMaster.flatDiscountInr as flatDiscountInr, CampaignsMaster.flatDiscountUsd as flatDiscountUsd, CampaignsMaster.discountType as discountType from CampaignsMaster WHERE CampaignsMaster.id = $idCampaign;";
$statement = query_execute($db, $sql);
$result = $statement->fetchAll(\PDO::FETCH_ASSOC);


for ($i=0; $i < count($result) ; $i++) { 
    $offerPercentage =  $result[$i]['offerPercentage'];
    $maxAmountInr =  $result[$i]['maxAmountInr'];
    $maxAmountUsd =  $result[$i]['maxAmountUsd'];
    $flatDiscountInr =  $result[$i]['flatDiscountInr'];
    $flatDiscountUsd =  $result[$i]['flatDiscountUsd'];
    $discountType =  $result[$i]['discountType'];
    $minAmountInr =  $result[$i]['minAmountInr'];
    $minAmountUsd =  $result[$i]['minAmountUsd'];
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
   if($minAmountInr<=$amount)
   {
   if($discountType == "Percentage")
   {
    $offerAmount= ($amount * $offerPercentage) / 100;
    if($offerAmount > $maxAmountInr &&  $maxAmountInr > 0)
    {
        $reducedAmount=$maxAmountInr;
    }
    else
    {
        $reducedAmount=$offerAmount;
     
    }
    $finalAmount=($amount-$reducedAmount);
   
}
if($discountType == "Flat")
   {
    $flatOfferAmount= $flatDiscountInr;
    $reducedAmount=$flatOfferAmount;
    $finalAmount=($amount-$reducedAmount);
    }
}
else{
    $finalAmount=$amount;
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
}
else{
    $finalAmount=$amount;
}
    
}

}

else{
    if($isIndia == "true"){
        
        foreach ($idCourses as $courseSelected) {
            $amount1 = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$courseSelected]);
            $amount+=$amount1;
           
        }
        $finalAmount = $amount;
        $cgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['cgst']);
        $sgst = getSingleValue($db, "SELECT percentage FROM TaxesMaster WHERE name = ?", ['sgst']);
        $cgstAmount= ($finalAmount * $cgst)/100;
        
        $sgstAmount= ($finalAmount * $sgst)/100;
                 
        $finalAmount = $finalAmount + $cgstAmount + $sgstAmount;
          
    }else{
        
        foreach ($idCourses as $courseSelected) {
            $amount1 = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$courseSelected]);
            $amount+=$amount1;
           
          }
        $finalAmount = $amount;
    }
}


$finalAmount = $finalAmount * 100;


$receiptId = 'rec_'.time();

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

if($isIndia == "true")
{
    $currencySymbol="INR";
}
else{
    $currencySymbol="USD";
}


$finalAmount = $finalAmount;
$reducedAmount=$amount;
$cgstAmount=$cgstAmount;
$sgstAmount=$sgstAmount;
$idOrder = uniqid("order_zero_", false);

$pricingSummary[0]['Amount']=$amount;
$pricingSummary[0]['discountAmount']=$reducedAmount;
$pricingSummary[0]['couponCode']=$couponCode;
$pricingSummary[0]['amountBeforeTaxes']=$finalAmount;
$pricingSummary[0]['cgst']='';
$pricingSummary[0]['sgst']='';
$pricingSummary[0]['cgstAmount']='';
$pricingSummary[0]['sgstAmount']='';
$pricingSummary[0]['amountPaid']=$finalAmount;
$pricingSummary[0]['currency']='';
$pricingSummary[0]['method']='';
$pricingSummary= json_encode($pricingSummary);
$mailCourseContent='';
for($f = 0; $f < count($idCourses); $f++){
    $idCourse=$idCourses[$f];  
    $course = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]); 
    if($isIndia=="true")
    { 
        $courseCost = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$idCourse]); 
    }  
    else 
    { 
       $courseCost = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$idCourse]); 
    }  

    //getting data for purchased course details object    
    $coursesData[$f]['id']=$idCourse;
    $coursesData[$f]['name']=$course;
    $coursesData[$f]['cost']=$courseCost;

    $mailCourseContent .= str_replace("[SR]", $f+1, USER_ENROLLED_MAIL_COURSE_ROW);
$mailCourseContent = str_replace("[NAME]", $course, $mailCourseContent);
$mailCourseContent = str_replace("[PRICE]", $currencySymbol.$courseCost, $mailCourseContent);

}
$coursesData= json_encode($coursesData);


//Mail Content
$mailPaymentContent='';
$mailPaymentContent.=str_replace("[LABEL]", "Total Amount", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", $currencySymbol.$amount, $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "Discount Amount", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", "-".$currencySymbol.$reducedAmount, $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "(".$couponCode.")", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", '', $mailPaymentContent);
if($isIndia=="true")
{
$mailPaymentContent.=str_replace("[LABEL]", "Amount before Taxes", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", $currencySymbol.$finalAmount, $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "Taxes", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", '', $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "CGST(9%)", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", $currencySymbol.$cgstAmount, $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "SGST(9%)", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", $currencySymbol.$sgstAmount, $mailPaymentContent);
}
$mailPaymentContent.=str_replace("[LABEL]", "<b>Amount Paid</b>", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", "<b>".$currencySymbol.$finalAmount."</b>", $mailPaymentContent);

$mailPaymentContent.=str_replace("[LABEL]", "Paid via", USER_ENROLLED_MAIL_PAYMENT_ROW);
$mailPaymentContent =str_replace("[VALUE]", "NA", $mailPaymentContent);


//Mail Address Content
$addressLine1 = getSingleValue($db, "SELECT addressLine1 FROM useraddressmapping WHERE idUser = ?", [$idUser]);
$addressLine2 = getSingleValue($db, "SELECT addressLine2 FROM useraddressmapping WHERE idUser = ?", [$idUser]);
$city = getSingleValue($db, "SELECT city FROM useraddressmapping WHERE idUser = ?", [$idUser]);
$state = getSingleValue($db, "SELECT state FROM useraddressmapping WHERE idUser = ?", [$idUser]);
$country = getSingleValue($db, "SELECT country FROM useraddressmapping WHERE idUser = ?", [$idUser]);
$pincode = getSingleValue($db, "SELECT pincode FROM useraddressmapping WHERE idUser = ?", [$idUser]);

$mailAddressContent='';
$mailAddressContent.=str_replace("[ADDRESSLINE1]", $addressLine1, USER_ENROLLED_MAIL_ADDRESS_ROW);
$mailAddressContent=str_replace("[ADDRESSLINE2]", $addressLine2, $mailAddressContent);
$mailAddressContent=str_replace("[CITY]", $city, $mailAddressContent);
$mailAddressContent=str_replace("[STATE]", $state, $mailAddressContent);
$mailAddressContent=str_replace("[COUNTRY]", $country, $mailAddressContent);
$mailAddressContent=str_replace("[PINCODE]", $pincode, $mailAddressContent);




$userName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);

$mailWishContent='';
$mailWishContent.=str_replace("[USER]", $userName, USER_ENROLLED_MAIL_WISH_ROW);



$userEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);

$currentdate = date('Y-m-d');
$expiryDate = date('Y-m-d', strtotime("+2 years", strtotime($currentdate)));;
$courseValidity = $expiryDate;
$mailValidityContent='';
$mailValidityContent.=str_replace("[VALIDITY_TEXT]", "Courses Valid till", USER_ENROLLED_COURSE_VALIDITY_ROW);
$mailValidityContent =str_replace("[VALIDITY_DATE]", $courseValidity, $mailValidityContent);


$mailSubject = "Purchase Summary of ".$userName;

$mailContent = str_replace("[USER_NAME]", $userName, USER_ENROLLED_MAIL_FORMAT);
$mailContent = str_replace("[ORDERID]", $idOrder, $mailContent);
$mailContent = str_replace("[COURSES_LIST]", $mailCourseContent, $mailContent);
$mailContent = str_replace("[VALIDITY_LIST]", $mailValidityContent, $mailContent);
$mailContent = str_replace("[PAYMENT_LIST]", $mailPaymentContent, $mailContent);
$mailContent = str_replace("[ADDRESS_LIST]", $mailAddressContent, $mailContent);
$mailContent = str_replace("[WISH_LIST]", $mailWishContent, $mailContent);
send_mail_to(ADMIN_MAIL_ID, $mailSubject, $mailContent);
send_mail_to($userEmail, $mailSubject, $mailContent);

$userGeneratedPaymentId = $serviceZeroAmountProcess->serve($db,$finalAmount, $idOrder, $idCourses, $couponCode, $idCampaign, $idUser,$usageType,$pricingSummary,$coursesData, $isIndia);
echo response_ok($userGeneratedPaymentId, time());


?> 