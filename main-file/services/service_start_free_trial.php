<?php

class ServiceStartFreeTrial{
    
    
    public function serve($db, $idUser) {

        $currentdate = date('Y-m-d H:i:s');
        $expiryDate = date('Y-m-d H:i:s', strtotime("+".FREE_TRIAL_DAYS." days", strtotime($currentdate)));

        $expiryTimestamp = strtotime($expiryDate);
        
        $sql = "Update usersmaster SET isTrialStarted = 1, trialExpiryTimestamp = '$expiryTimestamp' where id = $idUser;";
        
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

?>