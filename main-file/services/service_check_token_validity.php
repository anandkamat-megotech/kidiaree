<?php

class ServiceCheckTokenValidity{
    
    
    public function serve($db, $token) {
        $sql = "Select usersmaster.id FROM usersmaster, usertokenmapping WHERE usertokenmapping.token='$token' AND usertokenmapping.idUser = usersmaster.id AND usersmaster.isActive = 1;";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
		return $rowCount;
    }
    
}

?>