<html>
<head>
<title> Custom Form Kit </title>
</head>
<body>
<center>

<?php include('Crypto.php')?>
<?php require_once "config.php"; ?>
<?php 

	error_reporting(0);
	
	$merchant_data='';
	$orderId = rand();
	$working_key = CCA_WORKING_KEY;
	$access_code = CCA_ACCESS_CODE;

	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$merchant_data .= "order_id=".$orderId;

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

