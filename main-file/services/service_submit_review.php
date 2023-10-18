<?php

class ServiceSubmitReview{
    
    
    public function serve($db, $idAssignmentSubmission, $review, $idReviewedStatus, $facultyReviewAttachmentUrl) {

        $sql = "Update AssignmentSubmissionsMapping SET facultyRemarks = '$review', facultyAttachmentUrl = '$facultyReviewAttachmentUrl', status = '$idReviewedStatus', timestampReviewed = '".time()."' where id = $idAssignmentSubmission;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
		return $idAssignmentSubmission;
        
    }
    
}

?>