<?php 

function send_message_to($mobile, $message){

    $txtMessage = urlencode($message);

    $messageContent = str_replace("[MOBILE]", $mobile, MOBILE_MESSAGE_FORMAT);
    $messageContent = str_replace("[MESSAGE]", $txtMessage, $messageContent);

    file_get_contents ($messageContent);

}

?> 