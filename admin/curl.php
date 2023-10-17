<?php
$ch = curl_init();
$curlConfig = array(
    CURLOPT_URL            => "https://kidiaree.softwareconnect.in/main-file/welcome_email_partner.php",
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => array(
        'name' => 'anand',
        'email' => 'anand@synccoders.com',
    )
);
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);