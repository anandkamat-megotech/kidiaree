<?php

class ServiceBlacklistQuestion{
    
    
    public function serve($db, $idQuestion) {
        $sql = "UPDATE Questions SET blacklisted = 1 WHERE id = $idQuestion;";
        $statement = query_execute($db, $sql);

        $sql1 = "UPDATE Answers SET blacklisted = 1 WHERE idQuestion = $idQuestion;";
        $statement1 = query_execute($db, $sql1);
    }
    
}

?>