<?php

class ServiceGetSubjectFaculty{
    
    
    public function serve($db, $idSubject) {

        $sql = "Select FacultyMaster.idUser, FacultyMaster.designation, FacultyMaster.info, FacultyMaster.id, usersmaster.name, usersmaster.email, usersmaster.profilePictureUrl
        FROM FacultyMaster, usersmaster, CoursesMaster, SubjectsMaster WHERE FacultyMaster.idUser = usersmaster.id AND SubjectsMaster.id = $idSubject AND CoursesMaster.idFaculty = FacultyMaster.id AND CoursesMaster.idSubject = SubjectsMaster.id AND usersmaster.name NOT LIKE '%admin%' GROUP BY(usersmaster.id);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>