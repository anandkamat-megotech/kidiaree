<?php

include './components/component_get_day_user_activity.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_day_user_activity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_email.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetDayUserActivity = new ServiceGetDayUserActivity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();


$body = $serviceGetDayUserActivity->serve($db);

$mailSubject = "Daily User Engagement Report";
$recipientMailAddress = "webmaster@bricketc.com";

send_mail_to($recipientMailAddress, $mailSubject, nl2br($body));
send_mail_to("kavitha@megotechnologies.com", $mailSubject, nl2br($body));

?> 