<?php

class ServiceAdminStudentSearch{
    
    
    public function serve($db, $searchString) {
        $searchStringL = strtolower($searchString);
        $sql = "SELECT id, name, email, mobile, profilePictureUrl FROM usersmaster WHERE lower(name) LIKE '%$searchStringL%' AND idRole=2;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        for ($i=0; $i < count($result) ; $i++) { 
            $name = strtolower($result[$i]['name']);
            $result[$i]['matchString'] = substr($result[$i]['name'], strrpos($name, $searchStringL, 0), strlen($name));
            
        }
        $json = json_encode($result);
        return $json;
        

    }
    
}

?>