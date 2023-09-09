<?php

class ServiceUpdateCounsellorResponse{
    
    
    public function serve($db, $idCounselling, $counsellorResponse) {
       
        $curTimestamp=time();
       
            $sql = "Update CounsellingSessions SET counsellorResponse = '$counsellorResponse', resTimestamp = '$curTimestamp' where id = $idCounselling;";
       
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $curTimestamp;

        
    }
    
}

?>