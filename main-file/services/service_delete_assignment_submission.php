<?php

class ServiceDeleteAssignmentSubmission{
    
    
    public function serve($db, $idAssignmentSubmission) {

        $sql = "Delete from AssignmentSubmissionsMapping where id = $idAssignmentSubmission;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
}

?>