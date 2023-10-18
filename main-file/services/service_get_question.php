<?php

class ServiceGetQuestion{
    
    
    public function serve($db, $idQuestion) {
        $sql = "Select * from Questions WHERE id = $idQuestion;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>