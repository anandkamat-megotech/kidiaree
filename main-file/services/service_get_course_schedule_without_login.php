<?php

class ServiceGetCourseScheduleWithoutLogin{
    
    
    public function serve($db, $idCourse) {

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
                $sql1LiveSession = "Select MultipleLiveSessions.id, MultipleLiveSessions.meetingDescription, MultipleLiveSessions.meetingLink, MultipleLiveSessions.meetingTimestamp, MultipleLiveSessions.dd, MultipleLiveSessions.mm, MultipleLiveSessions.yyyy, MultipleLiveSessions.hh,MultipleLiveSessions.mmm from MultipleLiveSessions where MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND MultipleLiveSessions.idPrerecordedSession = $idPrerecordedSession order by meetingTimestamp asc LIMIT 1;";
                $statement1LiveSession = query_execute($db, $sql1LiveSession);
                $result1LiveSession= $statement1LiveSession->fetchAll(\PDO::FETCH_ASSOC);
                $resultPrerecordedSession[$i]['meetingLink']=$result1LiveSession[0]['meetingLink'];
                $resultPrerecordedSession[$i]['meetingDescription']=$result1LiveSession[0]['meetingDescription'];
                $resultPrerecordedSession[$i]['meetingTimestamp']=$result1LiveSession[0]['meetingTimestamp'];
            }
        }
                
        $jsonPrerecordedSession = json_encode($resultPrerecordedSession);

        $curTimestamp=time() - SESSION_TIME_ALLOCATED;
        
        $sqlLiveSession = "Select MultipleLiveSessions.id, MultipleLiveSessions.meetingDescription, MultipleLiveSessions.meetingLink, MultipleLiveSessions.meetingTimestamp, MultipleLiveSessions.dd, MultipleLiveSessions.mm, MultipleLiveSessions.yyyy, MultipleLiveSessions.hh,MultipleLiveSessions.mmm from MultipleLiveSessions, PrerecordedSessionsMaster, SchedulesMaster, FacultyMaster, usersmaster where MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idPrerecordedSession = PrerecordedSessionsMaster.id AND MultipleLiveSessions.idPrerecordedSession = PrerecordedSessionsMaster.id AND FacultyMaster.id = PrerecordedSessionsMaster.idFaculty AND FacultyMaster.idUser = usersmaster.id order by meetingTimestamp asc LIMIT 1;";
        $statementLiveSession = query_execute($db, $sqlLiveSession);
        $resultLiveSession = $statementLiveSession->fetchAll(\PDO::FETCH_ASSOC);
        $jsonLiveSession = json_encode($resultLiveSession);

        $sqlAssignment = "Select AssignmentsMaster.id, AssignmentsMaster.name, AssignmentsMaster.description, AssignmentsMaster.attachmentUrl, AssignmentsMaster.quizUrl from SchedulesMaster, AssignmentsMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idAssignment = AssignmentsMaster.id;";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAssignment = json_encode($resultAssignment);


        $resultAssignmentSubmission=[];
        $jsonAssignmentSubmission = json_encode($resultAssignmentSubmission);

        $message = "Meeting is not Requested";
        $status = "Not Requested";
        $jsonCounsellingSessions[0]['message'] = $message;
        $jsonCounsellingSessions[0]['status'] = $status;
        $jsonCounsellingSessionsEncoded = json_encode($jsonCounsellingSessions);

        $resultStudentFeedback = [];
        $jsonStudentFeedback = json_encode($resultStudentFeedback);


        $resultCertificate = [];
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