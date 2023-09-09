<?php

class serviceGetStudentQuestionAnswer{
    
    
    public function serve($db, $idUser) {
        $sqlQuestion = "Select Questions.id, Questions.question, Questions.idCourse, Questions.timestamp, CoursesMaster.name, CoursesMaster.idSubject FROM Questions, CoursesMaster WHERE Questions.idUser = $idUser AND Questions.blacklisted = 0 AND Questions.idCourse = CoursesMaster.id ORDER BY Questions.timestamp DESC;";
        $statementQuestion = query_execute($db, $sqlQuestion);
        $resultQuestion = $statementQuestion->fetchAll(\PDO::FETCH_ASSOC);
        $jsonQuestion = json_encode($resultQuestion);


        $sqlAnswer = "Select Answers.id, Answers.answer, Answers.idCourse, Answers.timestamp, Answers.idQuestion, Questions.question, CoursesMaster.name, CoursesMaster.idSubject FROM Answers, CoursesMaster, Questions WHERE Answers.idUser = $idUser AND Answers.blacklisted = 0 AND Answers.idCourse = CoursesMaster.id AND Answers.idQuestion = Questions.id ORDER BY Answers.timestamp DESC;";
        $statementAnswer = query_execute($db, $sqlAnswer);
        $resultAnswer = $statementAnswer->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAnswer = json_encode($resultAnswer);

        $myObj = new stdClass();
        $myObj->question = $jsonQuestion;
        $myObj->answer = $jsonAnswer;

        json_encode($myObj);

        
		return $myObj;
    }
    
}

?>