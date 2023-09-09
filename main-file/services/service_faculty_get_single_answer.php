<?php

class ServiceFacultyGetSingleAnswer{
    
    
    public function serve($db, $idFaculty, $idAnswer) {
        $sql = "Select Answers.id, Answers.answer, Answers.idCourse, Answers.timestamp, Answers.blacklisted, Answers.idQuestion, Questions.question, CoursesMaster.name, CoursesMaster.idSubject FROM Answers, CoursesMaster, Questions WHERE  Answers.id = $idAnswer AND  Answers.idCourse = CoursesMaster.id AND Answers.idQuestion = Questions.id AND CoursesMaster.idFaculty = $idFaculty;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>