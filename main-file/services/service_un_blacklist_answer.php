<?php

class ServiceUnBlacklistAnswer{
    
    
    public function serve($db, $idAnswer) {
        $sql = "UPDATE Answers SET blacklisted = 0 WHERE id = $idAnswer;";
        $statement = query_execute($db, $sql);
    }
    
}

?>