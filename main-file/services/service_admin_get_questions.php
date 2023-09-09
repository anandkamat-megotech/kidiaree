<?php

class ServiceAdminGetQuestions{
    
    
    public function serve($db, $offset) {
        $sql = "Select Questions.id, Questions.question, Questions.idCourse, Questions.timestamp, Questions.blacklisted, CoursesMaster.name, CoursesMaster.idSubject FROM Questions, CoursesMaster WHERE Questions.idCourse = CoursesMaster.id AND Questions.id not in (SELECT idQuestion from Answers) ORDER BY Questions.timestamp DESC LIMIT ".GET_QUESTIONS_LIMIT." OFFSET $offset;";

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>