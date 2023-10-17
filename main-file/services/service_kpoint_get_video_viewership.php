<?php

class ServiceKPointGetVideoViewership{
    
    
    public function serve($displayname, $email, $idVideo) {

        $kpointDomain="http://bricketc.kpoint.com";

        $CLIENT_ID = "ci82fd2e73c391458cbf8ff38a39ce4450";
        $SECRET_KEY = "sk049c77e6cd2f45f49c09ee95d0938bc6";
        $challenge = time();
        $account_number = ""; // optional


        /*
        * xauth_token generation part
        */
        //
        // step 1
        // if user is to be authenticated with email-id, then
        $data = "$CLIENT_ID:$email:$displayname:$challenge";

        //step 2
        $xauth_token = hash_hmac("md5", $data, $SECRET_KEY, true);

        //step 3
        $b64token = base64_encode($xauth_token);
        $b64token = str_replace("=","", $b64token);
        $b64token = str_replace("+","-", $b64token);
        $b64token = str_replace("/","_", $b64token);

        //step 4
        // if user is to be authenticated with email-id, then
        $xtencode= "client_id=$CLIENT_ID&user_email=$email&user_name=$displayname&challenge=$challenge&xauth_token=$b64token";

        /*
        * xt token generation part
        */

        $xt= base64_encode($xtencode);
        $xt = str_replace("=","", $xt);
        $xt = str_replace("+","-", $xt);
        $xt = str_replace("/","_", $xt);


        $url = $kpointDomain . '/api/v1/xapi/kapsule/' . $idVideo . '/viewership?by=user&xt='. urlencode($xt);

        $contents = file_get_contents($url);

        $jsonContents = json_decode($contents, true);

        return $jsonContents;

    }
    
}

?>