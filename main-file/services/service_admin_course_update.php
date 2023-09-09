<?php

class ServiceAdminCourseUpdate{
    
    
    public function serve($db, $id, $name, $info, $intro, $introVideoUrl, $idFaculty, $idTa, $idSubject, $isActive, $subjectImageUrl, $amount, $amountUsd, $idLevel, $duration, $learn, $isFeatured, $introThumbnailUrl) {

        //Making Course inactive if milestone count is zero
        $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $id AND idMilestone IS NOT NULL;";
        $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
        $milestoneCount = $statementMilestoneCount->rowCount(); 

        if($milestoneCount==0)
        {
            $isActive=0;
        }


        $learnJSON = json_encode($learn);
        $sql = "Update CoursesMaster SET name = '$name', info = '$info', intro = '$intro', introVideoUrl = '$introVideoUrl', idFaculty = $idFaculty, idTa = $idTa, idSubject = $idSubject, isActive = $isActive, imageUrl = '$subjectImageUrl', amount = $amount, amountUsd = $amountUsd, idLevel = $idLevel, duration = '$duration', learn = '$learnJSON', isFeatured = $isFeatured, introThumbnailUrl = '$introThumbnailUrl' where id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $idCertificatesMaster = getSingleValue($db, "SELECT id FROM CertificatesMaster WHERE idCourse = ? ", [$id]);
        $sqlCertificate = "";
        if($idCertificatesMaster == ''){
            $sqlCertificate = "Insert into CertificatesMaster (certificateHtml, idCourse) values ('<div id=\"background\">    
            <div id=\"border\">
                <img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/border.png\" style=\"height: 100%; width: 100%\" />
            </div>
            <div id=\"cetfificateContent\" style=\"display:flex; flex-direction:column; justify-content:center; align-items:center; width: 100%; height: 100%;\">
                <div id=\"BRICKETCLOGOPNG\">
                    <img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/BRICKETCLOGOPNG.png\" style=\"height: 100%; width: 100%\" />
                </div>        
                <div style=\"display:flex; flex-direction:row; justify-content:center; align-items:center\">
                    <div id=\"Rectangle1\"><img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/Rectangle1.png\" style=\"height: 100%; width: 100%\" /></div>
                    <h1 style=\"color: #0c55a8; z-index:3; margin-left: 15px; margin-right: 15px;margin-top: 2px; margin-bottom: 2px;\">Certificate Of Completion</h1> 
                    <div id=\"Rectangle1\"><img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/Rectangle1.png\" style=\"height: 100%; width: 100%\" /></div>
                </div>        
                <h4 style=\" z-index:3; margin-top: 0px; \">is hereby awarded to</h4>        
                <h3 style=\" z-index:3; margin-top: 2px; margin-bottom: 1px;\">[STUDENT_NAME]</h3>        
                <div style=\"z-index:3; height:0.5px; width:80%; background-color: black;\"></div>        
                <h4 style=\" z-index:3; margin-top: 10px; \">for successfully completing</h4>        
                <h3 style=\" z-index:3; margin-top: 2px; margin-bottom: 1px;\">[COURSE_NAME]</h3>        
                <div style=\"z-index:3; height:0.5px; width:80%; background-color: black;\"></div>       
                <div style=\"display:flex; flex-direction:row; justify-content:space-evenly; align-items:center; width: 100%; margin-top: 20px;\">            
                    <div style=\"flex:1; z-index: 3; display: flex; flex-direction: column; justify-content: center; align-items: center;\">                
                        <div id=\"Signature\"><img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/signatures/pathfinder.png\" style=\"height: 100%; width: 100%\"></div>
                        <h3 style=\"color: #0c55a8; z-index:3; font-weight: lighter;\">Signature</h3>            
                    </div>            
                    <div style=\"flex:1; z-index: 3; display: flex; flex-direction: column; justify-content: center; align-items: center;\">                
                        <div id=\"seal\"><img src=\"https://storage.googleapis.com/bricketc-storage/certificate-images/seal.png\" style=\"height: 100%; width: 100%\" /></div>            
                    </div>                        
                    <div style=\"flex:1; z-index: 3; display: flex; flex-direction: column; justify-content: center; align-items: center;\">                
                        <h3 style=\"z-index:3; font-weight: lighter;\">[COMPLETION_DATE]</h3>                
                        <h3 style=\"color: #0c55a8; z-index:3; font-weight: lighter;\">Date</h3>            
                    </div>                    
                </div>    
            </div>
            </div>', $id);";
        }

        $statementCertificate = query_execute($db, $sqlCertificate);
        $resultCertificate = $statementCertificate->fetchAll(\PDO::FETCH_ASSOC);
    
		return $id;


        
    }
    
}

?>