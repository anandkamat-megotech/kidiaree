<?php

class ServiceEnrollAndCount{
    
    
    public function serve($db,$idUser, $idPrerecordedSession) {

    $fp = fopen("./lock.txt", "r");
    $flagFile = true;
	if(flock($fp, LOCK_EX,$flagFile)){
	
        // get all liveSession of idPrerecordedSession
        $curTimestamp=time() - SESSION_TIME_ALLOCATED;
        $sqlLiveSession = "Select MultipleLiveSessions.* from MultipleLiveSessions where MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND MultipleLiveSessions.idPrerecordedSession = ".$idPrerecordedSession."  order by meetingTimestamp asc";
        $statementls = query_execute($db, $sqlLiveSession);
        $resultls = $statementls->fetchAll(\PDO::FETCH_ASSOC);
        if(empty($resultls)){
        	flock($fp, LOCK_UN);
            return response_parameters_invalid(time());
        }

        // get total count of livesession enrolled user
        foreach($resultls as $value){
            $sqlEnroll = "SELECT count(*) as total_enrolled from LiveSessionEnrollment WHERE liveSessionId =".$value['id'];
            $statementEnroll = query_execute($db, $sqlEnroll);
            $resultEnroll = $statementEnroll->fetchAll(\PDO::FETCH_ASSOC);
            if($resultEnroll[0]['total_enrolled'] < SESSION_BUCKET_SIZE){

                // check user enrolled or not
                $idUserCount = getSingleValue($db, "SELECT idUser FROM LiveSessionEnrollment WHERE liveSessionId = ? AND idUser = ?", [$value['id'], $idUser]);
                if($idUserCount != ''){
                    flock($fp, LOCK_UN);
                    return response_already_exist(time());
                }
                
                // enroll new user
                $sql = "Insert into LiveSessionEnrollment (liveSessionId, idUser) values (".$value['id'].", $idUser);";
                $statement = query_execute($db, $sql);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                $sql = "SELECT count(*) as total from LiveSessionEnrollment WHERE liveSessionId =".$value['id'];
                $statement = query_execute($db, $sql);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                $json = json_encode($result);
	            flock($fp, LOCK_UN);
                return  response_ok($json, time());
            }
        }
        return  response_ok(SESSION_RESPONSE,time());
	    flock($fp, LOCK_UN);
	}else{
            return response_parameters_invalid(time());
	}


    

        

        

    }

    public function serveAdmin($db,$idUser, $liveSessionId) {

        $sql = "SELECT count(*) as total from LiveSessionEnrollment WHERE liveSessionId =".$liveSessionId;
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }

 
    public function checkLock($db)
        {
            $sql = "SELECT count(*) from locktable";
            $statement = query_execute($db, $sql);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    
    public function putLock($db)
        {
            $query = "INSERT INTO locktable (id, locked) VALUES ('1', '1');";
            query_execute($db, $query);
            // return true;
        }

    public function releaseLock($db)
        {
            $query = "DELETE FROM locktable";
            query_execute($db, $query);
            // return true;
        }   
}

?>
