<?php

class ServiceTokenGenerate{
    
    
    public function serve($db, $idUser) {

        $token = uniqid();
        $sql = "INSERT into usertokenmapping (idUser, token, timestamp) values ($idUser, '$token', '".time()."');";
        $statement = query_execute($db, $sql);
        return $token;

        
    }

    
}

?>