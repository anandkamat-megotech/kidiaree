<?php
// Replace with your Razorpay API key
$api_key = 'YOUR_RAZORPAY_API_KEY';

// The IFSC code you want to look up

$ifsc_code = $_GET['ifsc'];
// 'HDFC0000182';

// Set the API endpoint
$api_url = "https://ifsc.razorpay.com/$ifsc_code";

// Initialize cURL session
$ch = curl_init($api_url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode("$api_key:")
]);

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Decode the JSON response
echo $data = '{ "body": '.$response.' }';
die;

if ($data) {
    // Bank details
    echo "Bank Name: " . $data['BANK'] . "<br>";
    echo "Branch Name: " . $data['BRANCH'] . "<br>";
    echo "Address: " . $data['ADDRESS'] . "<br>";
    echo "City: " . $data['CITY'] . "<br>";
    echo "State: " . $data['STATE'] . "<br>";
    echo "District: " . $data['DISTRICT'] . "<br>";
} else {
    echo "Bank details not found for the provided IFSC code.";
}
?>
