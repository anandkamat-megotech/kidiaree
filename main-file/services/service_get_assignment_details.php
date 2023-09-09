<?php

class ServiceGetAssignmentDetails{
    
    
    public function serve($db, $idAssignment) {
        $sql = "Select * from AssignmentsMaster WHERE id = $idAssignment;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>