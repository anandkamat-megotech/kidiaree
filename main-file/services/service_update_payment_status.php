<?php

class ServiceUpdatePaymentStatus{
    
    
    public function serve($db, $idUser, $idCourses, $idOrder, $razorpayOrderId, $razorpayPaymentId, $razorpaySignature, $couponCode, $usageType, $coursesData, $pricingSummary) {

        $currentdate = date('Y-m-d H:i:s');
        $expiryDate = date('Y-m-d H:i:s', strtotime("+2 years", strtotime($currentdate)));

        $expiryTimestamp = strtotime($expiryDate);

        for($f = 0; $f < count($idCourses); $f++){
            $idCourse=$idCourses[$f];
            $idCoursesSelected[$f]=$idCourse;
            $sql = "Insert into UserCoursePaymentMapping (idUser, idCourse, idOrder, razorpayOrderId, razorpayPaymentId, razorpaySignature, timestamp, expiryTimestamp) values ($idUser, $idCourse, '$idOrder', '$razorpayOrderId', '$razorpayPaymentId', '$razorpaySignature', '".time()."', '$expiryTimestamp');";
        
            $statement = query_execute($db, $sql);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $id[$f] = getSingleValue($db, "SELECT id FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ? ORDER BY id DESC LIMIT 1", [$idUser, $idCourse]);
        }

        $idCourses= json_encode($idCourses);
        $id= json_encode($id);

        $sql3 = "Insert into OrderidAmountMapping (orderId, coursesData, pricingSummary, idUser) values ('$idOrder', '$coursesData', '$pricingSummary', $idUser);";
        $statement3 = query_execute($db, $sql3);
        $result3 = $statement3->fetchAll(\PDO::FETCH_ASSOC);


        if($usageType == "Multiuse"){
           $idCampaign = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE CampaignsMaster.name = ? ", [$couponCode]);
           $couponName = uniqid($couponCode."_", false);
           $sql1 = "Insert into CouponsMaster (name, idCampaign,  idUser , idCourses, idUserCoursePaymentMappings) values ('$couponName', $idCampaign,  $idUser,  '$idCourses', '$id');";
           $statement1 = query_execute($db, $sql1);
           $result1 = $statement1->fetchAll(\PDO::FETCH_ASSOC);
        }

        if($usageType == "Singleuse"){
           $sql2 = "Update CouponsMaster SET idUser = $idUser, idCourses = '$idCourses', idUserCoursePaymentMappings='$id' where name = '$couponCode';";
           $statement2 = query_execute($db, $sql2);
           $result2 = $statement2->fetchAll(\PDO::FETCH_ASSOC);
        }


        $escapers =     array("\\","/","\"","\n","\r","\t","\x08","\x0c");
        $replacements = array("\\\\","\\/","\\\"","\\n","\\r","\\t","\\f","\\b");
        $id = str_replace($escapers, $replacements, $id);
               
		return $id;


        
    }
    
}

?>