<?php

class ServiceGetStudentDetails{
    
    
    public function serve($db, $id) {
        $sql = "Select * FROM kids WHERE idUser = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>