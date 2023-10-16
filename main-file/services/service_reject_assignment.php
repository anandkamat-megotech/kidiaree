<?php

class ServiceRejectAssignment{
    
    
    public function serve($db, $idAssignmentSubmission, $review, $idNeedsImprovementStatus, $facultyReviewAttachmentUrl) {

        $sql = "Update AssignmentSubmissionsMapping SET facultyRemarks = '$review', facultyAttachmentUrl = '$facultyReviewAttachmentUrl', status = '$idNeedsImprovementStatus', timestampReviewed = '".time()."', studentRemarks = '', studentAttachmentUrl = '' where id = $idAssignmentSubmission;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        

        
		return $idAssignmentSubmission;


        
    }
    
}

?>