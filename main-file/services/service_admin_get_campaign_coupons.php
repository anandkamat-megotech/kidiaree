<?php

class ServiceAdminGetCampaignCoupons{
    
    
    public function serve($db, $id) {
        $sql = "Select * from CouponsMaster where idCampaign = $id;";

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>