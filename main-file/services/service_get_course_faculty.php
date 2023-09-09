<?php

class ServiceGetCourseFaculty{
    
    
    public function serve($db, $idCourse) {


        $sql = "Select idFaculty from CoursesMaster where id = $idCourse;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $resultArray = array();
        for ($i=0; $i < count($result) ; $i++) { 
            $idFaculty =  $result[$i]['idFaculty'];
            $sqlFaculty = "Select FacultyMaster.id, FacultyMaster.idUser, FacultyMaster.designation, FacultyMaster.info, usersmaster.name, usersmaster.email, usersmaster.profilePictureUrl FROM FacultyMaster, usersmaster WHERE FacultyMaster.id = $idFaculty AND FacultyMaster.idUser = usersmaster.id;";
            $statementFaculty = query_execute($db, $sqlFaculty);
            $resultFaculty = $statementFaculty->fetch(\PDO::FETCH_ASSOC);
            $json = json_encode($resultFaculty);
            array_push($resultArray, $resultFaculty);               
           
        }
        
        $json = json_encode($resultArray);
		return $json;
        
    }
    
}

?>