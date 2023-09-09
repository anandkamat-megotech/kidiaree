<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
<head>
	<title>Holiday Announcement Letter</title>
</head>
<body>

	<?php
	$mailmsg ="";
	$mailmsg .= "<h2 style='text-align: center'>Holiday Announcement Letter</h2>";
	$mailmsg .= "<p><span style='float:right;padding-right:30px;'>Thusday, 2019-03-21</span>Hello All,</p>"; 
	$mailmsg .= "<p>Kindly note that our office will remain closed tomorrow, October 02nd [Tuesday], on the occasion of Holi. For anything urgent, please call the individual's mobile phone. Wishing everyone a happy and safe holiday.</p>\r";

	$mailmsg .= '</table>' ;

	$mailmsg .= "<p>Thank you</p>\r"; 
	$mailmsg .= "<p>REGARDS,</p>\r"; 
	$mailmsg .= "<p>For Advanced CasePRO Services</p>\r"; 
	?>
	<center>
		<table width=55% border=\"0\" align=\"center\" cellpadding=1 cellspacing=\"0\" >
			<tr>
				<td align=\"center\" valign=\"top\">
					<table width=900px border=\"0\"  cellpadding=\"0\" cellspacing=\"0\" style='border:2px solid; border-color:#969696'>
						<tr>                                            
							<td bgcolor=\"#FFFFFF\" align=\"left\" style=\"padding:14px;\"><?php echo $mailmsg;?></td>                                            
						</tr>
						<tr>
							<td bgcolor=#606060 align="center" style=\"padding:2px; border-top:2px solid; border-color:#777777\">
								<a href=\"" . $SiteURL . "\" style='color:#ffffff; text-decoration:none'>hr@advancedcaseproservices.com</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>