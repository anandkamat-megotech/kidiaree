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
      $getClass = $db->query("SELECT p.*, u.name as teacher_name FROM products p left join usersmaster u on u.id = p.teacher_id  order by p.id desc");
    
      // echo "<pre>";print_r($txns);
      // die;
     
      ?>
      
      <?php include('inc/sidebar.php');?>
      
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Products</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">Products</li>
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
                        <a href="../add_new_class.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Class/Activity</a>
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
                                       <th>Name</th>
                                       <!-- <th>Teacher Name</th> -->
                                       <th>Product Links</th>
                                       <th>Status</th>
                                       <th>Reason</th>



                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){ ?>
                                             
                                    <tr onclick="functionChange('<?php echo $row['name'] ?>','<?php echo $row['id'] ?>')">
                                       <td><?php echo $row['name'] ?></td>
                                       <td><a target="_blank" href="../<?php echo $row['product_url'].'?id='.$row['id'] ?>"><?php echo $row['product_url'] ?></a></td>
                                       <td><?php if($row['status'] == 0 && $row['reason'] != ''){ echo '<badge class="badge bg-danger">Not approved</badge>';} elseif($row['status'] == 2){ echo '<badge class="badge bg-warning">Rework</badge>';}elseif($row['status'] == 0 && $row['reason'] == ''){ echo '<badge class="badge bg-dark">Not reviewed</badge>';}else{ echo '<badge class="badge bg-success">Approved</badge>';} ?></td>
                                       <td><?php echo $row['reason'] ?></td>
                                    
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