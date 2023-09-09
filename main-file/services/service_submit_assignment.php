<?php

class ServiceSubmitAssignment{
    
    
    public function serve($db, $idAssignment, $idUser, $idFaculty, $idCourse, $studentRemarks, $studentAttachmentUrl, $status) {

        $sql = "Insert into AssignmentSubmissionsMapping (idAssignment, idUser, idFaculty, idCourse, studentRemarks, studentAttachmentUrl, status, timestampSubmit) values ($idAssignment, $idUser, $idFaculty, $idCourse, '$studentRemarks', '$studentAttachmentUrl', $status, '".time()."');";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $id = getSingleValue($db, "SELECT id FROM AssignmentSubmissionsMapping WHERE idUser = ? AND idAssignment = ? ORDER BY id DESC LIMIT 1", [$idUser, $idAssignment]);
    
		return $id;
        
    }
    
}

?>