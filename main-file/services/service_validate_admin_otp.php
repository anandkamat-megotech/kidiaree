<?php

class ServiceValidateAdminOTP{
    
    
    public function serve($db, $idUser, $otp) {
        $time = time();
       $sql = "Select id FROM usersmaster WHERE id='$idUser' AND otp='$otp';";
        $statement = query_execute($db, $sql);
        
        $rowCount = $statement->rowCount(); 
		return $rowCount;
    }
    
}

?>