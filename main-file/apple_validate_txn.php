<?php
include './globals/constants_send_otp_email_db.php';
include './components/component_resend_otp.php';
include './services/service_base.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_otp_generate.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_email.php';
include './utilities/send_message.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$receiptData = "";
$receiptData = post_params("receiptData");

$receiptData = // The transaction receipt data
$sharedSecret = // Your app's shared secret (optional)
$endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt'; // Use the sandbox URL for testing

$requestData = json_encode(array(
    'receipt-data' => $receiptData,
    'password' => $sharedSecret
));

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);

$response = curl_exec($ch);
curl_close($ch);


$responseData = json_decode($response, true);

if ($responseData['status'] == 0) {
    // The receipt is valid
    $productId = $responseData['receipt']['in_app'][0]['product_id'];
    $purchaseDate = $responseData['receipt']['in_app'][0]['purchase_date'];
    // ... other receipt data
    echo '{"code": 200, "timestamp": '.time().', "body": "'.$responseData.'" }';
} else {
    echo '{"code": 403, "timestamp": '.time().', "body": "The receipt is invalid" }';
    // The receipt is invalid
    // Handle the error
}





?> 