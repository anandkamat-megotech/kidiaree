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
         $getUser = $db->query("SELECT * FROM enuiary_details where id=".$_POST['idUser']);
         $data = $getUser->fetch_assoc();
         $name = $data['f_name'].' '.$data['l_name'];
         $db->query("Insert into usersmaster (email, idRole, isProfileSet, isActive,name,mobile) values ('".$data['email']."', 3, 0, 1,'".$name."','".$data['mobile_number']."');");
         $url_send_email = "name=".$data['f_name']."&email=".$data['email'];
         $ch = curl_init();
         $curlConfig = array(
            CURLOPT_URL            => "$url_curl_kidiaree_admin/main-file/welcome_email_partner.php",
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => array(
               'name' => $data['f_name'],
               'email' => $data['email'],
            )
         );
         curl_setopt_array($ch, $curlConfig);
         $result = curl_exec($ch);
         curl_close($ch);
         
         // echo "<pre>";print_r($data );
         // echo "here";
         // echo $data['email'];
         // die;
         $db->query("UPDATE `enuiary_details` SET `status` = '1' WHERE `enuiary_details`.`id` = '".$_POST['idUser']."';");
         // die;
      }
      $where = '';
      // Get member rows
      $getClass = $db->query("SELECT * FROM `enuiary_details` ORDER BY `enuiary_details`.`id` DESC");
    
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
                              <table class="table table-stripped table-hover datatable">
                                 <thead class="thead-light">
                                    <tr>
                                       <th>User Type</th>
                                       <th>Name</th>
                                       <th>Contact</th>
                                       <th>Pan</th>
                                       <th>Adhaar</th>
                                       <th>Status</th>
                                       <th></th>


                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){ ?>
                                             
                                    <tr >
                                       <td><?php if($row['type'] == 'INDV'){ echo 'Individual'; }else{ echo 'Org';}?></td>
                                       <td style="color:blue;cursor: pointer;"  onclick="functionChange('<?php echo $row['f_name'] ?>','<?php echo $row['id'] ?>')" ><?php echo $row['f_name'] ?></td>
                                       <td><?php echo $row['mobile_number'] ?></td>
                                       <td><a href="../<?php echo $row['panDoc'] ?>" target="_blank">View</a></td>
                                       <td><a href="../<?php echo $row['addDoc'] ?>" target="_blank">View</a></td>
                                       <td><?php if($row['status'] == 0 ){ echo '<badge class="badge bg-warning">Not Approved</badge>';} elseif($row['status'] == 1){ echo '<badge class="badge bg-success">Approved</badge>';}?></td>
                                       <td><a href="profile_view.php?id=<?php echo $row['id'] ?>" target="_blank">View Full Details</a></td>
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
        <input class="form-control" type="hidden" id="idUser" name="idUser"  required>
        <input class="form-control" type="text" id="class_name" name="class_name" required placeholder="Name">
    </div>
    <div class="mb-3">
    <select class="form-control" name="status">
    <option value="1">Approve</option>
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
              var inputid = document.getElementById('idUser');
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