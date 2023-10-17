<?php

class ServiceUpdateAssignment{
    
    
    public function serve($db, $idAssignmentSubmission, $studentRemarks, $studentAttachmentUrl, $idStatusCompleted) {

        $sql = "Update AssignmentSubmissionsMapping SET studentRemarks = '$studentRemarks', studentAttachmentUrl = '$studentAttachmentUrl', status = '$idStatusCompleted', timestampSubmit = '".time()."' where id = '$idAssignmentSubmission';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        
		return $idAssignmentSubmission;
        
    }
    
}

?>