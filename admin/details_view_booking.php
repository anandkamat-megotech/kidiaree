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
      if(isset($_POST['submit_status'])){
         // print_r($_POST);
         // echo "UPDATE `products` SET `reason` = '".$_POST['reason']."',`status` = '".$_POST['status']."' WHERE `products`.`id` = '".$_POST['idClass']."';";
         $db->query("UPDATE `products` SET `reason` = '".$_POST['reason']."',`status` = '".$_POST['status']."' WHERE `products`.`id` = '".$_POST['idClass']."';");
         // die;
      }
      $where = '';
      // Get member rows
      $getClass = $db->query("SELECT * FROM `usercoursepaymentmapping` where id=$_GET[id]");
    
      // echo "<pre>";print_r($txns);
      // die;
     
      ?>
      
      <?php include('inc/sidebar.php');?>
      
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">All Details</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">All Details</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- <button type="button" id="model_approve" class="btn btn-info mt-1" data-bs-toggle="modal" data-bs-target="#approve-modal"> Modal</button> -->

                                 <?php if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){ ?>
                                             
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
                                 <div class="inovices-amount"><?php echo $row['course_name'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Title</p>
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
                                 <div class="inovices-amount"><?php echo $row['student_name'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Kid Name</p>
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
                                 <div class="inovices-amount"><?php echo $row['c_gross_total'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Price</p>
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
                                 <div class="inovices-amount"><?php echo $row['ccgst'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">CGST</p>
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
                                 <div class="inovices-amount"><?php echo $row['ssgst'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">SGST</p>
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
                                 <div class="inovices-amount"><?php echo $row['net_payable'] ?></div>
                              </div>
                           </div>
                           <p class="inovices-all">Net Payable</p>
                        </div>
                     </div>
                  </div>
               </div>
                                    <?php } }else{ ?>
                                             <p class="mt-3 text-center">No bookings found...</p>
                                       <?php } ?>
                                
            </div>
         </div>
      </div>

      
      <!-- Modal -->

      <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">
    <div class="text-center mt-2 mb-4">
    <form action="" class="px-3" method="POST">
    <div class="mb-3">
        <input class="form-control" type="hidden" id="idClass" name="idClass"  required>
        <input class="form-control" type="text" id="class_name" name="class_name" required placeholder="Class name">
    </div>
    <div class="mb-3">
        <input class="form-control" type="text" id="reason" name="reason" required placeholder="Reason">
    </div>
    <div class="mb-3">
    <select class="form-control" name="status">
    <option value="3">Approved</option>
    <option value="2">Rework</option>
    </select>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="closeModal('approve-modal')">Close</button>
    <button  type="submit" name="submit_status" class="btn btn-primary">Save changes</button>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>


      <?php include('inc/scripts.php');?>
   </body>
</html>
<script>
function functionChange (name, id){
   //  var btn = document.getElementById("model_approve");
	    // add event listener for the button, for action "click"
	   //  btn.addEventListener("click", displayMessage);
    var element = document.getElementById("approve-modal");
              element.classList.add("show");
              element.classList.add("d-block");
              var input = document.getElementById('class_name');
            input.setAttribute("value",name); 
              var inputid = document.getElementById('idClass');
            inputid.setAttribute("value",id); 
            //   document.getElementById("class_name").value(name);
            //   document.getElementById("idClass").value(id);

// alert(name+' - '+id);
}

function closeModal(data) {
  var element = document.getElementById(data);
  element.classList.remove("show");
  element.classList.remove("d-block");
}
</script>