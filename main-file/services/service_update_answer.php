<?php

class ServiceUpdateAnswer{
    
    
    public function serve($db, $idAnswer, $answer) {        

        $sql = "UPDATE Answers SET answer='$answer' WHERE id = $idAnswer;";
        $statement = query_execute($db, $sql);
    }
    
}

?>