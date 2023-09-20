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
          include_once '../dbConfig.php';
          if(!empty($_GET['id'])){
            $getUser = $db->query("SELECT * FROM `enuiary_details` WHERE id = ".$_GET['id']);
            $data = $getUser->fetch_assoc();
          }
          
    
    //   echo "<pre>";print_r($data);
    //   die;
         ?>
         <?php include('inc/sidebar.php');?>
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row">
                     <div class="col">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">Profile</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="profile-header">
                        <div class="row align-items-center">
                           <div class="col-auto profile-image">
                              <a href="#">
                              <img class="rounded-circle" alt="User Image" src="assets/img/profiles/avatar-02.jpg">
                              </a>
                           </div>
                           <div class="col ms-md-n2 profile-user-info">
                              <h4 class="user-name mb-0"><?php echo $data['f_name'].' '.$data['l_name'] ?></h4>
                              <h6 class="text-muted"><?php if($data['type'] == 'INDV') { echo 'Individual';}else{echo 'Organization';} ?></h6>
                           </div>
                        </div>
                     </div>
                     <div class="profile-menu">
                        <ul class="nav nav-tabs nav-tabs-solid">
                           <li class="nav-item">
                              <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">Info</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="tab" href="#bank_details">Bank Details</a>
                           </li>
                        </ul>
                     </div>
                     <div class="tab-content profile-tab-cont">
                        <div class="tab-pane fade show active" id="per_details_tab">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">
                                       <h5 class="card-title d-flex justify-content-between">
                                          <span>Personal Details</span>
                                          <!-- <a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="far fa-edit me-1"></i>Edit</a> -->
                                       </h5>
                                       <div class="row mt-5">
                                          <p class="col-sm-3 text-muted  mb-0 mb-sm-3">Name</p>
                                          <p class="col-sm-9"><?php echo $data['f_name'].' '.$data['l_name'] ?></p>
                                       </div>
                                       <div class="row">
                                          <p class="col-sm-3 text-muted  mb-0 mb-sm-3">Address</p>
                                          <p class="col-sm-9"><?php echo $data['addressLine1'].', '.$data['addressLine2'].',<br> '.$data['area'].', '.$data['city'].',<br> '.$data['state'].', '.$data['country'].', '.$data['pincode'];?></p>
                                       </div>
                                       <div class="row">
                                          <p class="col-sm-3 text-muted  mb-0 mb-sm-3">Email ID</p>
                                          <p class="col-sm-9"><?php echo $data['email']; ?></p>
                                       </div>
                                       <div class="row">
                                          <p class="col-sm-3 text-muted  mb-0 mb-sm-3">Mobile</p>
                                          <p class="col-sm-9"><?php echo $data['mobile_number']; ?></p>
                                       </div>
                                       <div class="row">
                                          <p class="col-sm-3 text-muted  mb-0">GSTIN</p>
                                          <p class="col-sm-9 mb-0"><?php echo $data['GSTIN']; ?>
                                          </p>
                                       </div>
                                       <div class="row">
                                          <p class="col-sm-3 text-muted  mb-0">PAN</p>
                                          <p class="col-sm-9 mb-0"><?php echo $data['pan']; ?>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="bank_details" class="tab-pane fade">
                           <div class="card">
                              <div class="card-body">
                                 <h5 class="card-title">Bank Details</h5>
                                 <div class="row mt-5">
                                    <p class="col-sm-3 text-muted mb-0 mb-sm-3">Beneficiary Name</p>
                                    <p class="col-sm-9"><?php echo $data['bname']; ?></p>
                                 </div>
                                 <div class="row">
                                    <p class="col-sm-3 text-muted mb-0 mb-sm-3">Account Name</p>
                                    <p class="col-sm-9"><?php echo $data['account_name']; ?></p>
                                 </div>
                                 <div class="row">
                                    <p class="col-sm-3 text-muted mb-0 mb-sm-3">Bank Name</p>
                                    <p class="col-sm-9"><?php echo $data['bank_name']; ?></p>
                                 </div>
                                 <div class="row">
                                    <p class="col-sm-3 text-muted mb-0 mb-sm-3">Account Number</p>
                                    <p class="col-sm-9"><?php echo $data['account_number']; ?></p>
                                 </div>
                                 <div class="row">
                                    <p class="col-sm-3 text-muted mb-0 mb-sm-3">IFSC Code </p>
                                    <p class="col-sm-9"><?php echo $data['ifsc_code']; ?></p>
                                 </div>
                              </div>
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