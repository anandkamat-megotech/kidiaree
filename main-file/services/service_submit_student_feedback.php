<?php

class ServiceSubmitStudentFeedback{
    
    
    public function serve($db, $idUser, $idCourse, $feedbackText, $overallExperience, $qualityOfContent, $qualityOfTasks, $knowledgeBuilding) {

        $sql = "Insert into StudentFeedbacks (idCourse, idUser, feedbackText, overallExperience, feedbackTimestamp, qualityOfContent, qualityOfTasks, knowledgeBuilding) values ($idCourse, $idUser, '$feedbackText', '$overallExperience', '".time()."', $qualityOfContent, $qualityOfTasks, $knowledgeBuilding);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $id = getSingleValue($db, "SELECT id FROM StudentFeedbacks WHERE idUser = ? AND idCourse = ? ORDER BY id DESC LIMIT 1", [$idUser, $idCourse]);

        
		return $id;


        
    }
    
}

?>