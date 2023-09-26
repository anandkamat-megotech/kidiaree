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
         
      curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree_admin."/main-file/get_payments_order.php?teacher=zenny");
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
                        <h3 class="page-title">Transactions</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">Transactions</li>
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
               <div class="card report-card">
                  <div class="card-body pb-0">
                     <div class="row">
                        <div class="col-md-12">
                           <ul class="app-listing">
                              <li>
                                 <div class="multipleSelection">
                                    <div class="selectBox">
                                       <p class="mb-0"><i class="fas fa-user-plus me-1 select-icon"></i> <?php if(!empty($_GET['teacher'])){ echo $_GET['teacher'];}else{ echo 'Select Teacher';} ?></p>
                                       <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div id="checkBoxes">
                                       <form action="" method="GET">
                                          <p class="checkbox-title">Teacher Search</p>
                                          <!-- <div class="form-custom">
                                             <input type="text" class="form-control bg-grey" placeholder="Enter Teacher Name">
                                          </div> -->
                                          <div class="selectBox-cont">
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="zenny">
                                             <span class="checkmark"></span> Zenny
                                             </label>
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="Purva">
                                             <span class="checkmark"></span> Purva
                                             </label>
                                          </div>
                                          <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                          <a href="transactions.php" type="reset" class="btn w-100 btn-grey">Reset</a>
                                       </form>
                                    </div>
                                 </div>
                              </li>
                              <li>
                                 <div class="multipleSelection">
                                    <div class="selectBox">
                                       <p class="mb-0"><i class="fas fa-calendar me-1 select-icon"></i> <?php if(!empty($_GET['date'])){ echo $_GET['date'];}elseif(!empty($_GET['from']) && !empty($_GET['to'])){ echo $_GET['from'] .' TO '.$_GET['to'];}else{ echo 'Select date';} ?></p>
                                       <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div id="checkBoxes">
                                       <form action="" method="GET">
                                       <input type="hidden" name="teacher" value="<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher'];} ?>">
                                          <p class="checkbox-title">Date Filter</p>
                                          <div class="selectBox-cont selectBox-cont-one h-auto">
                                             <div class="date-picker">
                                                <div class="form-custom cal-icon">
                                                   <input class="form-control datetimepicker" type="text" placeholder="Form" name="from">
                                                </div>
                                             </div>
                                             <div class="date-picker pe-0">
                                                <div class="form-custom cal-icon">
                                                   <input class="form-control datetimepicker" type="text" placeholder="To" name="to">
                                                </div>
                                             </div>
                                             <div class="date-list">
                                                <ul>
                                                   <li><a href="transactions.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; }echo '&date='.date("Y-m-d"); ?>" class="btn date-btn">Today</a></li>
                                                   <li><a href="transactions.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&date='.date('Y-m-d', strtotime('-1 days')); ?>" class="btn date-btn">Yesterday</a></li>
                                                   <li><a href="transactions.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&date='.date('Y-m-d', strtotime('-7 days')); ?>" class="btn date-btn">Last 7 days</a></li>
                                                   <li><a href="transactions.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&from='.date('Y-m-01', strtotime(date('Y-m-d'))).'&to='.date('Y-m-t', strtotime(date('Y-m-d')));?>" class="btn date-btn">This month</a></li>
                                                   <li><a href="transactions.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&from='.date("Y-n-j", strtotime("first day of previous month")).'&to='.date("Y-n-j", strtotime("last day of previous month")); ?>" class="btn date-btn">Last month</a></li>
                                                </ul>
                                             </div>
                                             <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                             <a href="transactions.php" type="reset" class="btn w-100 btn-grey">Reset</a>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </li>
                              <li>
                                 <div class="report-btn">
                                    <a href="export.php?<?php echo $query; ?>" class="btn">
                                    <img src="assets/img/icons/invoices-icon5.png" alt class="me-2"> Generate report
                                    </a>
                                 </div>
                              </li>
                           </ul>
                        </div>
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
                                 <div class="inovices-amount">INR <?php echo $sumAmount; ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Gross Sales <span><?php echo $countInv; ?></span></p>
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
                                 <div class="inovices-amount">INR <?php echo $sumAAmount; ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Actuall Sales <span><?php echo $countAInv; ?></span></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 col-12">
                     <div class="card inovices-card">
                        <div class="card-body">
                           <div class="inovices-widget-header">
                              <span class="inovices-widget-icon">
                              <img src="assets/img/icons/invoices-icon4.svg" alt>
                              </span>
                              <div class="inovices-dash-count">
                                 <div class="inovices-amount">INR <?php echo $payment_not_done; ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Payment not done (Gross) <span><?php echo $countInv - $countAInv; ?></span></p>
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
                                       <th>Date of class</th>
                                       <th>Class / Activity</th>
                                       <th>Chlid Name</th>
                                       <th>Age</th>
                                       <th>Email ID</th>
                                       <th>Mobile Number</th>
                                       <th>Amount</th>
                                       <th>Status</th>


                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php foreach($txns->body as $value){  ?>
                                             
                                    <tr>
                                       <td><?php echo $value->inv_date ?></td>
                                       <td><?php echo $value->course_name ?></td>
                                       <td><?php echo $value->student_name ?></td>
                                       <td>12</td>
                                       <td>test@gmail.com</td>
                                       <td>7045767896</td>
                                       <td class="text-primary"><?php echo $value->c_gross_total ?> INR</td>
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