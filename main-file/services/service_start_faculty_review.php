<?php

class ServiceStartFacultyReview{
    
    
    public function serve($db, $idAssignmentSubmission, $idUnderReviewStatus) {

        $sql = "Update AssignmentSubmissionsMapping SET status = $idUnderReviewStatus where id = $idAssignmentSubmission;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);


        
    }
    
}

?>