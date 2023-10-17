<?php

class ServiceSearchBySubject{
    
    
    public function serve($db, $searchString) {
        $searchStringL = strtolower($searchString);
        $sql = "SELECT * FROM SubjectsMaster WHERE lower(name) LIKE '%$searchStringL%' OR lower(description) LIKE '%$searchStringL%';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        
        for ($i=0; $i < count($result) ; $i++) { 
            $name = strtolower($result[$i]['name']);
            $description = strtolower($result[$i]['description']);
            if(!strrpos($name, $searchStringL, 0)){
                $result[$i]['matchString'] = substr($result[$i]['description'], strrpos($description, $searchStringL, 0), strlen($description));
            }else{
                $result[$i]['matchString'] = substr($result[$i]['name'], strrpos($name, $searchStringL, 0), strlen($name));
            }
        }
        $json = json_encode($result);
        return $json;
        

    }
    
}

?>