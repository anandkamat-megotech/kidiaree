<!DOCTYPE html>
<?php
include('global/admin_global.php');
$url =  $_SERVER['REQUEST_URI'];
$query = parse_url($url, PHP_URL_QUERY);
   // echo $query;
session_start();
if(empty($_SESSION['token'])){
     header("Location: login.php"); exit;
}

?>
<html lang="en">
   <?php include('inc/head.php');?>
   <body>
      <div class="main-wrapper">
      <?php include('inc/header.php');
      $ch = curl_init();
         
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
      $payment_not_done = 0;
      foreach($txns->body as $data_sum){
         $countInv +=1;
         $sumAmount+=$data_sum->c_gross_total;
         if($data_sum->status == 1){
            $sumAAmount+=$data_sum->c_taxable;
            $countAInv +=1;
         }
         if($data_sum->status == 0){
            $payment_not_done+=$data_sum->c_gross_total;
         }
         
      }
      // echo "<pre>";print_r($txns);
      // die;
      ?>
      <?php include('inc/sidebar.php');?>
      
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Order Details</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">Order Details</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col"></div>
                     <div class="col-auto">
                        <a href="transactions.php" class="invoices-links active">
                        <i class="feather feather-list"></i>
                        </a>
                     </div>
                  </div>
               </div>
               
               <div class="row">
                  <div class="col-xl-3 col-sm-6 col-12">
                     <div class="card inovices-card">
                        <div class="card-body">
                           <div class="inovices-widget-header">
                              <span class="inovices-widget-icon">
                              <img src="assets/img/icons/invoices-icon1.svg" alt>
                              </span>
                              <div class="inovices-dash-count">
                                 <div class="inovices-amount">00<?php echo $_GET['id']; ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Unique ID</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 col-12">
                     <div class="card inovices-card">
                        <div class="card-body">
                           <div class="inovices-widget-header">
                              <span class="inovices-widget-icon">
                              <img src="assets/img/icons/invoices-icon3.svg" alt>
                              </span>
                              <div class="inovices-dash-count">
                                 <div class="inovices-amount"><?php echo $txns->body[0]->course_name; ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Title</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card card-table">
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-stripped table-hover datatable">
                                 <thead class="thead-light">
                                    <tr>
                                       <th>Sl.No</th>
                                       <th>Date of Booking</th>
                                       <th>Kid Name</th>
                                       <th>Age</th>
                                       <th>Email ID</th>
                                       <th>Mobile Number</th>
                                       <th>Status</th>


                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php foreach($txns->body as $value){  ?>
                                             
                                    <tr>
                                       <td><?php echo $value->id ?></td>
                                       <td><?php echo $value->inv_date ?></td>
                                       <td><?php echo $value->student_name ?></td>
                                       <td>12</td>
                                       <td>test@gmail.com</td>
                                       <td>7045767896</td>
                                       <td><?php if($value->status == 1){ echo '<span class="badge bg-success">Received </span>';}else{echo '<span class="badge bg-danger">Not received</span>';} ?></td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include('inc/scripts.php');?>
   </body>
</html>