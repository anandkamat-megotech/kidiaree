<?php

class ServiceBlacklistAnswer{
    
    
    public function serve($db, $idAnswer) {
        $sql = "UPDATE Answers SET blacklisted = 1 WHERE id = $idAnswer;";
        $statement = query_execute($db, $sql);
    }
    
}

?>