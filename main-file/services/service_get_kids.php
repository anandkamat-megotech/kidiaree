<?php

class ServiceGetKids{
    
    
    public function serve($db, $id) {
        $sql = "Select * FROM kids WHERE kids.id ='$id';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>