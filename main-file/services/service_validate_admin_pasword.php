<?php

class ServiceValidateAdminPasswordSave{
    
    
    public function serve($db, $idUser, $otp) {
        $time = time();
       $sql = "UPDATE `usersmaster` SET `otp` = '$otp' WHERE `usersmaster`.`id` =  $idUser;";
        $statement = query_execute($db, $sql);
        
        $rowCount = $statement->rowCount(); 
		return $rowCount;
    }
    
}

?>