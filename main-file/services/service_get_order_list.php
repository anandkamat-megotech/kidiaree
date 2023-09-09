<?php

class ServiceGetOrderList{
    
    
    public function serve($db) {
        $sql = "Select * FROM OrderidAmountMapping;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        function replace_key($arr, $oldkey, $newkey) {
            if(array_key_exists( $oldkey, $arr)) {
                $keys = array_keys($arr);
                $keys[array_search($oldkey, $keys)] = $newkey;
                return array_combine($keys, $arr);	
            }
            return $arr;  
            
        }
       

        for ($i=0; $i < count($result) ; $i++) { 
            $idUser = $result[$i]['idUser'];
            $sqlUser[$i] = "Select *  FROM usersmaster WHERE usersmaster.id = $idUser;";
            $statementUser[$i] = query_execute($db, $sqlUser[$i]);
            $resultUser[$i] = $statementUser[$i]->fetchAll(\PDO::FETCH_ASSOC); 
            $resultUser[$i]=replace_key($resultUser[$i], 0, 'userDetails');       
            $result[$i]=array_merge($result[$i],$resultUser[$i]);
        }


        $json = json_encode($result);  
		return $json;
    }
    
}

?>