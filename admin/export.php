<?php 
include('global/admin_global.php');
session_start();
$url =  $_SERVER['REQUEST_URI'];
$query = parse_url($url, PHP_URL_QUERY);
$token = $_SESSION['token'];
// Load the database configuration file 
$ch = curl_init();
        //  echo $query;
        //  die;
      curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree_admin."/main-file/get_payments_order.php?".$query);
      $authorization = "Authorization: Bearer ".$token;
      curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
      $result = curl_exec($ch);
      curl_close($ch);
         
      $txns =json_decode($result);
      $sumAmount = 0;
      $sumAAmount = 0;
      $countInv = 0;
      $countAInv = 0;
      foreach($txns->body as $data_sum){
         $countInv +=1;
         $sumAmount+=$data_sum->c_gross_total;
         if($data_sum->status == 1){
            $sumAAmount+=$data_sum->c_taxable;
            $countAInv +=1;
         }
         
      }
//  echo "<pre>";print_r($txns);
//       die;
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "export-data_" . date('Y-m-d') .rand(). ".xls"; 
 
// Column names 
$fields = array('INV_NO', 'INV_DATE', 'COURSE_NAME', 'STUDENT_NAME', 'STUDENT_STATE', 'TEACHER_NAME', 'TEACHER_STATE', 'TEACHER_GST_NO', 'GROSS_TOTAL', 'COURSE_FEE_TAXABLE', 'COURSE_CGST', 'COURSE_SGST', 'COURSE_IGST', 'SERVICE_FEE_%', 'SERVICE_FEE', 'SERVICE_CGST', 'SERVICE_SGST', 'SERVICE_IGST', 'TCS_CGST', 'TCS_SGST', 'TCS_IGST', 'NET_PAYABLE', 'STATUS', 'TYPE_COURSE'); 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
// Fetch records from database 
if(!empty($txns)){ 
    // Output each row of the data 
    foreach($txns->body as $value){
        $status = ($value->status == 1)?'paid':'failed'; 
        $lineData = array($value->inv_number, $value->inv_date, $value->course_name, $value->student_name, $value->student_state, $value->teacher_name, $value->teacher_state, $value->teacher_gst_number, $value->c_gross_total, $value->c_taxable, $value->ccgst, $value->csgst, $value->cigst, $value->service_fee_persnt,$value->service_fee,$value->scgst,$value->ssgst,$value->sigst,$value->tcs_cgst,$value->tcs_sgst,$value->tcs_igst,$value->net_payable,$status,$value->type); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
 
?>