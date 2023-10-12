<?php

class ServiceGetParent{
    
    
    public function serve($db, $id) {
        $sql = "Select * FROM usersmaster WHERE usersmaster.id ='$id';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>