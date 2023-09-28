<?php

class ServiceGetPaymentsOrder{
    
    
    public function serve($db, $teacher, $date, $from, $to, $idProduct) {
        $where = '';
        if(!empty($teacher) || !empty($date) || !empty($from)){
            $where = 'where ';
        }

        if(!empty($teacher)){
            $where .= " upm.teacher_name = '".$teacher."'";
        }
        
        if(!empty($idProduct)){
            $where .= " AND upm.idProduct = '".$idProduct."'";
        }

        if(!empty($date)){
            $where .= " AND upm.inv_date = '".$date."'";
        }

        if(!empty($from) && !empty($to)){
            $where .= " AND upm.inv_date BETWEEN '".date("Y-m-d", strtotime($from) )."' AND '".date("Y-m-d", strtotime($to) )."'";
        }

       $sql = "SELECT upm.*, p.teacher_id, p.name, p.price, p.type FROM `usercoursepaymentmapping` as upm JOIN products p ON p.id = upm.idProduct ".$where." ORDER by upm.id DESC";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;


        
    }
    
}

?>