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
         $db->query("UPDATE `enquiry` SET `reason` = '".$_POST['reason']."',`status` = '".$_POST['status']."' WHERE `enquiry`.`id` = '".$_POST['idClass']."';");
         // die;
      }
      $where = '';
      // Get member rows
      $getClass = $db->query("SELECT * FROM `enquiry` ORDER BY `enquiry`.`id` DESC");
    
      // echo "<pre>";print_r($txns);
      // die;
     
      ?>
      
      <?php include('inc/sidebar.php');?>
      
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Enquiry</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">Enquiry</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- <button type="button" id="model_approve" class="btn btn-info mt-1" data-bs-toggle="modal" data-bs-target="#approve-modal"> Modal</button> -->
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col"></div>
                     <div class="col-auto">
                        <a href="products.php" class="invoices-links active">
                        <i class="feather feather-list"></i>
                        </a>
                     </div>
                  </div>
               </div>
               
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card card-table">
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-stripped table-hover">
                                 <thead class="thead-light">
                                    <tr>
                                       <th>Name</th>
                                       <th>Contact</th>
                                       <th>Email</th>
                                       <th>Date</th>
                                       <th>Status</th>


                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){ ?>
                                             
                                    <tr >
                                       <td  style="color:blue;cursor: pointer;" onclick="functionChange('<?php echo $row['name']; ?>','<?php echo $row['id']; ?>')"><?php echo $row['name']; ?></td>
                                       <td><?php echo $row['contact']; ?></td>
                                       <td><?php echo $row['email']; ?></td>
                                       <td><?php echo date("d-m-Y", strtotime($row['created_at'])); ?></td>
                                       <td><?php if($row['status'] == 0 ){ echo '<badge class="badge bg-danger">Not Replied</badge>';} elseif($row['status'] == 1){ echo '<badge class="badge bg-success">Replied</badge>';}?></td>
                                    </tr>
                                    <?php } }else{ ?>
                                             <p class="mt-3 text-center">No Class(s) found...</p>
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

      
      <!-- Modal -->

      <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">
    <div class="text-center mt-2 mb-4">
    <form action="" class="px-3" method="POST">
    <div class="mb-3">
        <input class="form-control" type="hidden" id="id" name="id"  required>
        <input class="form-control" type="text" id="class_name" name="class_name" required placeholder="Class name">
    </div>
    <div class="mb-3">
    <select class="form-control" name="status">
    <option value="1">Replied</option>
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