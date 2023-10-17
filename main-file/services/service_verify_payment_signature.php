<?php

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class ServiceVerifyPaymentSignature{
    
    
    public function serve($razorpayOrderId , $razorpayPaymentId, $razorpaySignature) {

        $success = true;

        $error = "Payment Failed";

        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
        try
        {
            // Please note that the razorpay order ID must
            // come from a trusted source (session here, but
            // could be database or something else)
            $attributes = array(
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature
            );

            $api->utility->verifyPaymentSignature($attributes);
        }
        catch(SignatureVerificationError $e)
        {
            $success = false;
            $error = 'Razorpay Error : ' . $e->getMessage();
        }

        

        return $success;
            
    }
    
}

?>