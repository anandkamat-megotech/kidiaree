<?php

class ServiceCheckUserAssignmentExistsInTable{
    
    
    public function serve($db, $idUser, $idAssignment) {
        $sql = "SELECT id FROM AssignmentSubmissionsMapping WHERE idUser = '$idUser' AND idAssignment = '$idAssignment';";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
        return $rowCount;
    }
    
}

?>