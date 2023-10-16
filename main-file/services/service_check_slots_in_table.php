<?php

class ServiceCheckSlotsInTable{
    
    
    public function serve($db, $tablename, $idCourse, $zoomId,$date) {
      function getTimeSlot($interval, $start_time, $end_time,  $date)
      {
        date_default_timezone_set(TIME_ZONE);
          $start = new DateTime($start_time);
          $end = new DateTime($end_time);
          $startTime = $start->format('H:i:s');
          $endTime = $end->format('H:i');
          $i=0;
          $time = [];
          while(strtotime($startTime) <= strtotime($endTime)){
              $start = date('H:i:s', strtotime($startTime));
              $newDateTime = date('h:i A', strtotime($startTime));
              $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
              $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
              $startTimeSlot = date('H:i',strtotime('-'.$interval.' minutes',strtotime($startTime)));
              $i++;
              $currntimestamp = time();
              $sendtime = strtotime(" $date $startTimeSlot");
              if($sendtime > $currntimestamp){
                $time[$i]['time'] = $start;
                $time[$i]['value'] = $newDateTime;
              }
          }
          return $time;
      }

        $slots = getTimeSlot(60, '09:00', '18:00', $date);
        $sql = "SELECT slots FROM $tablename WHERE  zoom_id='$zoomId' AND date = '$date';";
        
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        foreach($result as $val){
            unset($slots[$val['slots']]);
        }
        return $slots;
    }
    
}

?>