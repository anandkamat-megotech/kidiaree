<?php

class ServiceAdminGetAnswers{
    
    
    public function serve($db, $offset) {
        $sql = "Select Answers.id, Answers.answer, Answers.idCourse, Answers.timestamp, Answers.blacklisted, Answers.idQuestion, Questions.question, CoursesMaster.name, CoursesMaster.idSubject FROM Answers, CoursesMaster, Questions WHERE Answers.idCourse = CoursesMaster.id AND Answers.idQuestion = Questions.id ORDER BY Answers.timestamp DESC LIMIT ".GET_ANSWERS_LIMIT." OFFSET $offset;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>