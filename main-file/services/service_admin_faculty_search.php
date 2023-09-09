<?php

class ServiceAdminFacultySearch{
    
    
    public function serve($db, $searchString) {
        $searchStringL = strtolower($searchString);
        $sql = "SELECT usersmaster.name, usersmaster.email, usersmaster.mobile, usersmaster.profilePictureUrl, FacultyMaster.id, FacultyMaster.idUser, FacultyMaster.info, FacultyMaster.designation FROM usersmaster, FacultyMaster WHERE (lower(usersmaster.name) LIKE '%$searchStringL%' OR lower(FacultyMaster.info) LIKE '%$searchStringL%') AND FacultyMaster.idUser = usersmaster.id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        for ($i=0; $i < count($result) ; $i++) { 
            $name = strtolower($result[$i]['name']);
            $info = strtolower($result[$i]['info']);
            if(!strrpos($name, $searchStringL, 0)){
                $result[$i]['matchString'] = substr($result[$i]['info'], strrpos($info, $searchStringL, 0), strlen($info));
            }else{
                $result[$i]['matchString'] = substr($result[$i]['name'], strrpos($name, $searchStringL, 0), strlen($name));
            }
        }
        $json = json_encode($result);
        return $json;
        

    }
    
}

?>