<?php

class ServiceDeleteKids{
    
    
    public function serve($db, $idQuestion) {
        $sql = "DELETE from kids  WHERE id = $idQuestion;";
        $statement = query_execute($db, $sql);

    }
    
}

?>