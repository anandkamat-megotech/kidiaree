<?php

use Razorpay\Api\Api;
class ServiceGetOrderId{
    
    
    public function serve($amount, $receiptId, $isIndia) {

        if ($isIndia == 'true') {
            $orderData = [
                'receipt'         => $receiptId,
                'amount'          => $amount,
                'currency'        => RAZORPAY_CURRENCY_IND
            ];
            
            $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
            $razorpayOrder = $api->order->create($orderData);
            return $razorpayOrder->id;
        }else {
            $orderData = [
                'receipt'         => $receiptId,
                'amount'          => $amount,
                'currency'        => RAZORPAY_CURRENCY_US
            ];
            
            $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
            $razorpayOrder = $api->order->create($orderData);
            return $razorpayOrder->id;
        }

        
    }
    
}

?>