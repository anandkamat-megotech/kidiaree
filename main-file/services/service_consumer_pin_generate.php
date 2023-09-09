<?php

class ServiceConsumerPinGenerate{
    
    
    public function serve($db, $idUser) {

        $consumerPin = uniqid();
        $sql = "Update usersmaster SET consumerPin = '$consumerPin' where id = $idUser;";
        $statement = query_execute($db, $sql);
        return $consumerPin;

        
    }

    
}

?>