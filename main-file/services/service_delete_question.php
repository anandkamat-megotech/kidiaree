<?php

class ServiceDeleteQuestion{
    
    
    public function serve($db, $idQuestion) {
        $sql = "DELETE from Questions  WHERE id = $idQuestion;";
        $statement = query_execute($db, $sql);

        $sql1 = "DELETE from Answers WHERE idQuestion = $idQuestion;";
        $statement1 = query_execute($db, $sql1);
    }
    
}

?>