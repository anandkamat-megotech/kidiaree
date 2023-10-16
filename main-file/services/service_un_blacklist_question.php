<?php

class ServiceUnBlacklistQuestion{
    
    
    public function serve($db, $idQuestion) {
        $sql = "UPDATE Questions SET blacklisted = 0 WHERE id = $idQuestion;";
        $statement = query_execute($db, $sql);

        $sql1 = "UPDATE Answers SET blacklisted = 0 WHERE idQuestion = $idQuestion;";
        $statement1 = query_execute($db, $sql1);
    }
    
}

?>