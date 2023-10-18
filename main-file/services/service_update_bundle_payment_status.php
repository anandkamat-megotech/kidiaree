<?php

class serviceUpdateBundlePaymentStatus{
    
    
    public function serve($db, $idUser, $courses, $idOrder, $razorpayOrderId, $razorpayPaymentId, $razorpaySignature) {


        $currentdate = date('Y-m-d H:i:s');
        $expiryDate = date('Y-m-d H:i:s', strtotime("+12 months", strtotime($currentdate)));

        $expiryTimestamp = strtotime($expiryDate);

        for($i = 0; $i < sizeof($courses); $i++){
            $idCourse = $courses[$i]['id'];

            $sqlPayment = "Insert into UserCoursePaymentMapping (idUser, idCourse, idOrder, razorpayOrderId, razorpayPaymentId, razorpaySignature, timestamp, expiryTimestamp) values ($idUser, $idCourse, '$idOrder', '$razorpayOrderId', '$razorpayPaymentId', '$razorpaySignature', '".time()."', '$expiryTimestamp');";

            $statement = query_execute($db, $sqlPayment);

        }
        
    }
    
}

?>