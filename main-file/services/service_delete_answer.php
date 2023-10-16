<?php

class ServiceDeleteAnswer{
    
    
    public function serve($db, $idAnswer) {        

        $sql = "DELETE from Answers WHERE id = $idAnswer;";
        $statement = query_execute($db, $sql);
    }
    
}

?>