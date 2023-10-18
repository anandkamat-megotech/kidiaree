<?php

class ServiceSearchByCampaign{
    
    
    public function serve($db, $searchString) {
        $searchStringL = strtolower($searchString);
        $sql = "SELECT * FROM CampaignsMaster WHERE lower(name) LIKE '%$searchString%' order by id desc;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $json = json_encode($result);
        return $json;
        

    }
    
}

?>