<?php

class ServiceOTPGenerate{
    
    
    public function serve($db, $columnName, $value) {
        $otp='';
        if($columnName == 'email' && $value == 'dipika.s@megotechnologies.com'){
            $otp = '1212';
        }elseif($columnName == 'email' && $value == 'priya.c@megotechnologies.com'){
            $otp = '1313';
        }else{
            $otp = rand(1000,10000);
        }
        $expTime = time() + 300;
        $sql = "UPDATE usersmaster SET otp = '$otp', otpExpirytime = '$expTime' WHERE $columnName='$value';";
        $statement = query_execute($db, $sql);
        return $otp;
    }
    
}

?>