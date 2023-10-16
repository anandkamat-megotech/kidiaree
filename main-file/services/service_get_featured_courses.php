<?php

class ServiceGetFeaturedCourses{
    
    
    public function serve($db) {
        $sql = "Select CoursesMaster.id, CoursesMaster.name, CoursesMaster.idSubject, CoursesMaster.info, CoursesMaster.imageUrl, SubjectsMaster.name AS subjectName from CoursesMaster, SubjectsMaster WHERE CoursesMaster.idSubject = SubjectsMaster.id AND CoursesMaster.isFeatured = 1 AND CoursesMaster.isActive = 1;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>