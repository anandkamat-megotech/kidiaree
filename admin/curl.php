<?php
$ch = curl_init();
$curlConfig = array(
    CURLOPT_URL            => "https://kidiaree.softwareconnect.in/main-file/welcome_email_partner.php?name=anand k&email=anand@synccoders.com",
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => array(
        'field1' => 'some date',
        'field2' => 'some other data',
    )
);
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);