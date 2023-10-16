<?php

class ServiceGetSubscriptionDetails{
    
    
    public function serve($db, $idUser) {
        $sql = "Select OrderidAmountMapping.id AS idSubscription, OrderidAmountMapping.orderId, OrderidAmountMapping.pricingSummary from OrderidAmountMapping where OrderidAmountMapping.idUser=$idUser;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
		

       

        function utf8ize($d) {
            if (is_array($d)) {
                foreach ($d as $k => $v) {
                    $d[$k] = utf8ize($v);
                }
            } else if (is_string ($d)) {
                return utf8_encode($d);
            }
            return $d;
        }
        $json = json_encode(utf8ize($result));
        return $json;
    }
    
}

?>