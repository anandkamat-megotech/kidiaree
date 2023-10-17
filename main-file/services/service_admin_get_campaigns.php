<?php

class ServiceAdminGetCampaigns{
    
    
    public function serve($db) {
        $sql = "Select * from CampaignsMaster order by id desc;";

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>