<?php

class ServiceGetCourseSchedule{
    
    
    public function serve($db, $idCourse, $idUser) {

        $sqlSchedule = "Select * from SchedulesMaster where idCourse = $idCourse ORDER BY sequenceNumber;";
        $statementSchedule = query_execute($db, $sqlSchedule);
        $resultSchedule = $statementSchedule->fetchAll(\PDO::FETCH_ASSOC);
        $jsonSchedule = json_encode($resultSchedule);

        $sqlMilestone = "Select MilestonesMaster.id, MilestonesMaster.name from MilestonesMaster, SchedulesMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idMilestone = MilestonesMaster.id;";
        $statementMilestone = query_execute($db, $sqlMilestone);
        $resultMilestone = $statementMilestone->fetchAll(\PDO::FETCH_ASSOC);
        $jsonMilestone = json_encode($resultMilestone);

        $curTimestamp=time() - SESSION_TIME_ALLOCATED;
        
        $sqlPrerecordedSession = "Select PrerecordedSessionsMaster.id as id, PrerecordedSessionsMaster.name, PrerecordedSessionsMaster.description, PrerecordedSessionsMaster.idFaculty, PrerecordedSessionsMaster.videoUrl, PrerecordedSessionsMaster.duration, PrerecordedSessionsMaster.isLive, PrerecordedSessionsMaster.meetingLink, PrerecordedSessionsMaster.meetingDescription, PrerecordedSessionsMaster.meetingTimestamp, PrerecordedSessionsMaster.thumbnailUrl, FacultyMaster.idUser, FacultyMaster.designation, usersmaster.name AS facultyName from PrerecordedSessionsMaster, SchedulesMaster, FacultyMaster, usersmaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idPrerecordedSession = PrerecordedSessionsMaster.id AND FacultyMaster.id = PrerecordedSessionsMaster.idFaculty AND FacultyMaster.idUser = usersmaster.id;";
        $statementPrerecordedSession = query_execute($db, $sqlPrerecordedSession);
        $resultPrerecordedSession = $statementPrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);

        for ($i=0; $i < count($resultPrerecordedSession) ; $i++) { 
            $idPrerecordedSession = $resultPrerecordedSession[$i]['id'];
            $isLive = getSingleValue($db, "SELECT isLive FROM PrerecordedSessionsMaster WHERE id = ?", [$idPrerecordedSession]);
            if($isLive == 1)
            {
                $sql1LiveSession = "Select MultipleLiveSessions.id, MultipleLiveSessions.meetingDescription, MultipleLiveSessions.meetingLink, MultipleLiveSessions.meetingTimestamp, MultipleLiveSessions.dd, MultipleLiveSessions.mm, MultipleLiveSessions.yyyy, MultipleLiveSessions.hh,MultipleLiveSessions.mmm, MultipleLiveSessions.idPrerecordedSession, zoom_key.zoom_sdk_id_mob, zoom_key.sdk_keys_mob,zoom_key.sdk_key_web, zoom_key.sdk_secret, zoom_key.zoom_id from MultipleLiveSessions, zoom_key where MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND zoom_key.zoom_id = MultipleLiveSessions.zoom_id AND MultipleLiveSessions.idPrerecordedSession = $idPrerecordedSession order by meetingTimestamp asc;";
                $statement1LiveSession = query_execute($db, $sql1LiveSession);
                $result1LiveSession= $statement1LiveSession->fetchAll(\PDO::FETCH_ASSOC);
                $resultPrerecordedSession[$i]['meetingLink']=$result1LiveSession[0]['meetingLink'];
                $resultPrerecordedSession[$i]['meetingDescription']=$result1LiveSession[0]['meetingDescription'];
                $resultPrerecordedSession[$i]['meetingTimestamp']=$result1LiveSession[0]['meetingTimestamp'];
            }
        }
                
        $jsonPrerecordedSession = json_encode($resultPrerecordedSession);
        
        $curTimestamp=time() - SESSION_TIME_ALLOCATED;
        
        $sqlLiveSession = "Select MultipleLiveSessions.id, MultipleLiveSessions.meetingDescription, MultipleLiveSessions.meetingLink, MultipleLiveSessions.meetingTimestamp, MultipleLiveSessions.dd, MultipleLiveSessions.mm, MultipleLiveSessions.yyyy, MultipleLiveSessions.hh,MultipleLiveSessions.mmm, MultipleLiveSessions.idPrerecordedSession, zoom_key.zoom_sdk_id_mob, zoom_key.sdk_keys_mob, zoom_key.sdk_key_web, zoom_key.sdk_secret, zoom_key.zoom_id from MultipleLiveSessions, PrerecordedSessionsMaster, SchedulesMaster, FacultyMaster, usersmaster, zoom_key where MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND zoom_key.zoom_id = MultipleLiveSessions.zoom_id AND SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idPrerecordedSession = PrerecordedSessionsMaster.id AND MultipleLiveSessions.idPrerecordedSession = PrerecordedSessionsMaster.id AND FacultyMaster.id = PrerecordedSessionsMaster.idFaculty AND FacultyMaster.idUser = usersmaster.id order by meetingTimestamp asc";
        $statementLiveSession = query_execute($db, $sqlLiveSession);
        $resultLiveSession = $statementLiveSession->fetchAll(\PDO::FETCH_ASSOC);
        $liveSessionArray = array();
        // array_push($liveSessionArray,$resultLiveSession);

        foreach($resultLiveSession as $value){
            $sqlEnroll = "SELECT  IF(idUser=".$idUser.", 'ENROLLED', 'NOT ENROLLED') as status  from LiveSessionEnrollment WHERE liveSessionId =".$value['id']." AND idUser=".$idUser;
            $statementEnroll = query_execute($db, $sqlEnroll);
            $resultEnroll = $statementEnroll->fetchAll(\PDO::FETCH_ASSOC);
            array_push($liveSessionArray,$resultEnroll);
        }
        

        $resultLiveSessionMerge = array();
        foreach ($resultLiveSession as $key => $value){
            $resultLiveSessionMerge[] = (object)array_merge((array)$liveSessionArray[$key], (array)$value);
        }
        // print_r($out);
        // $mergeArray = array_merge_recursive($resultLiveSession, $liveSessionArray);
        // print_r($mergeArray);
        // die;
        $jsonLiveSession = json_encode($resultLiveSessionMerge);

        $sqlAssignment = "Select AssignmentsMaster.id, AssignmentsMaster.name, AssignmentsMaster.description, AssignmentsMaster.attachmentUrl, AssignmentsMaster.quizUrl from SchedulesMaster, AssignmentsMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idAssignment = AssignmentsMaster.id;";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAssignment = json_encode($resultAssignment);

        $sqlAssignmentSubmission = "Select AssignmentSubmissionsMapping.id, AssignmentSubmissionsMapping.idAssignment, AssignmentSubmissionsMapping.studentRemarks, AssignmentSubmissionsMapping.timestampSubmit, AssignmentSubmissionsMapping.idFaculty, AssignmentSubmissionsMapping.facultyRemarks, AssignmentSubmissionsMapping.status, StatusMaster.name AS statusName, AssignmentSubmissionsMapping.timestampReviewed, usersmaster.name AS facultyName from SchedulesMaster, AssignmentsMaster, AssignmentSubmissionsMapping, FacultyMaster, usersmaster, StatusMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idAssignment = AssignmentsMaster.id AND AssignmentSubmissionsMapping.idAssignment = AssignmentsMaster.id AND FacultyMaster.id = AssignmentSubmissionsMapping.idFaculty AND FacultyMaster.idUser = usersmaster.id AND AssignmentSubmissionsMapping.status = StatusMaster.id AND AssignmentSubmissionsMapping.idUser = $idUser;";
        $statementAssignmentSubmission = query_execute($db, $sqlAssignmentSubmission);
        $resultAssignmentSubmission = $statementAssignmentSubmission->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAssignmentSubmission = json_encode($resultAssignmentSubmission);

        $sqlCounsellingSessions = "Select * from CounsellingSessions, zoom_key where zoom_key.zoom_id = CounsellingSessions.zoom_id AND idCourse = $idCourse AND idUser = $idUser;";
        $statementCounsellingSessions = query_execute($db, $sqlCounsellingSessions);
        $resultCounsellingSessions = $statementCounsellingSessions->fetchAll(\PDO::FETCH_ASSOC);
        $jsonCounsellingSessionsEncoded = json_encode($resultCounsellingSessions);
        
        
        $message='';
        $status='';
        if($statementCounsellingSessions->rowCount() == 0){
            $message = "Meeting is not Requested";
            $status = "Not Requested";
        }else{
            //Get meetingTimestamp of from CounsellingSessions
            $meetingTimestamp = getSingleValue($db, "SELECT meetingTimestamp FROM CounsellingSessions WHERE idCourse = ? AND idUser = ?", [$idCourse, $idUser]);
    
            //Get meetingLink of from CounsellingSessions
            $meetingLink = getSingleValue($db, "SELECT meetingLink FROM CounsellingSessions WHERE idCourse = ? AND idUser = ?", [$idCourse, $idUser]);
    
           

               if($meetingTimestamp == ''){
                  $message = "Meeting is not scheduled";
                  $status = "Not Scheduled";
               }else{
                   if($meetingTimestamp > time()){
                       $message = "Meeting is scheduled on ".date('Y-m-d H:i:s', $meetingTimestamp);
                       $status = "Scheduled";
                  }else{
                      $message = "Meeting was scheduled on ".date('Y-m-d H:i:s', $meetingTimestamp);
                      $status = "Was Scheduled";
                  }
                }
        
            
        }

        $jsonCounsellingSessions = json_decode($jsonCounsellingSessionsEncoded, true);
        $jsonCounsellingSessions[0]['message'] = $message;
        $jsonCounsellingSessions[0]['status'] = $status;

        $jsonCounsellingSessionsEncoded = json_encode($jsonCounsellingSessions);

        $sqlStudentFeedback = "Select * from StudentFeedbacks where idCourse = $idCourse AND idUser = $idUser;";
        $statementStudentFeedback = query_execute($db, $sqlStudentFeedback);
        $resultStudentFeedback = $statementStudentFeedback->fetchAll(\PDO::FETCH_ASSOC);
        $jsonStudentFeedback = json_encode($resultStudentFeedback);


        $sqlCertificate = "Select * from Certificates where idCourse = $idCourse AND idUser = $idUser;";
        $statementCertificate = query_execute($db, $sqlCertificate);
        $resultCertificate = $statementCertificate->fetchAll(\PDO::FETCH_ASSOC);
        $jsonCertificate = json_encode($resultCertificate);

        $sqlQuestions = "Select Questions.id, Questions.question, Questions.idUser, Questions.timestamp, usersmaster.name from Questions, usersmaster where Questions.idCourse = $idCourse AND Questions.idUser = usersmaster.id AND Questions.id in (select idQuestion from  Answers where Answers.idCourse = $idCourse AND Answers.blacklisted=0) AND Questions.blacklisted = 0;";
        $statementQuestions = query_execute($db, $sqlQuestions);
        $resultQuestions = $statementQuestions->fetchAll(\PDO::FETCH_ASSOC);
        $jsonQuestions = json_encode($resultQuestions);

        $sqlAnswers = "Select Answers.id, Answers.answer, Answers.idQuestion, Answers.idUser, Answers.timestamp, usersmaster.name from Answers, usersmaster where Answers.idCourse = $idCourse AND Answers.idUser = usersmaster.id AND Answers.blacklisted = 0;";
        $statementAnswers = query_execute($db, $sqlAnswers);
        $resultAnswers = $statementAnswers->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAnswers = json_encode($resultAnswers);

        $myObj = new stdClass();
        $myObj->schedule = $jsonSchedule;
        $myObj->milestone = $jsonMilestone;
        $myObj->liveSession = $jsonLiveSession;
        $myObj->prerecordedSession = $jsonPrerecordedSession;
        $myObj->assignment = $jsonAssignment;
        $myObj->assignmentSubmission = $jsonAssignmentSubmission;
        $myObj->counsellingSessions = $jsonCounsellingSessionsEncoded;
        $myObj->studentFeedback = $jsonStudentFeedback;
        $myObj->certificate = $jsonCertificate;
        $myObj->questions = $jsonQuestions;
        $myObj->answers = $jsonAnswers;

        json_encode($myObj);

        
		return $myObj;


        
    }
    
}

?>
