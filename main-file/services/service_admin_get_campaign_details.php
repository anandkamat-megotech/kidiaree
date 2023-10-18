<?php

class ServiceAdminGetCampaignDetails{
    
    
    public function serve($db, $id) {
        $sql = "Select * from CampaignsMaster where id = $id;";

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>