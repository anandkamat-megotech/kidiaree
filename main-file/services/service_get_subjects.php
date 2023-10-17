<?php

class ServiceGetSubjects{
    
    
    public function serve($db) {
        $sql = "Select * from SubjectsMaster;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        for ($i=0; $i < count($result) ; $i++) { 
            $idSubject =  $result[$i]['id'];
            $sqlCourseCount = "Select id from CoursesMaster where idSubject = $idSubject;";
            $statementCourseCount = query_execute($db, $sqlCourseCount);
            $courseCount = $statementCourseCount->rowCount();
            
            $result[$i]['courseCount'] = $courseCount;
        }
        $json = json_encode($result);
		return $json;
    }
    
}

?>