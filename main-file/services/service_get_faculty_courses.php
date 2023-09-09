<?php

class ServiceGetFacultyCourses{
    
    
    public function serve($db, $idFaculty) {
        
        $sql = "Select DISTINCT SchedulesMaster.idCourse, CoursesMaster.name, CoursesMaster.idSubject from SchedulesMaster, CoursesMaster, PrerecordedSessionsMaster WHERE SchedulesMaster.idCourse = CoursesMaster.id AND PrerecordedSessionsMaster.idFaculty = $idFaculty AND PrerecordedSessionsMaster.id = SchedulesMaster.idPrerecordedSession and isActive = 1;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>