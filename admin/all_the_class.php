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
      $getClass = $db->query("SELECT p.*, u.name as teacher_name FROM products p left join usersmaster u on u.id = p.teacher_id where status=2  order by p.id desc");
    
      // echo "<pre>";print_r($txns);
      // die;
     
      ?>
      
      <?php include('inc/sidebar.php');?>
      
         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">My Booking</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                           <li class="breadcrumb-item active">My Booking</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- <button type="button" id="model_approve" class="btn btn-info mt-1" data-bs-toggle="modal" data-bs-target="#approve-modal"> Modal</button> -->
              
               <div class="card report-card">
                  <div class="card-body pb-0">
                     <div class="row">
                        <div class="col-md-12">
                           <ul class="app-listing">
                              <li>
                                 <div class="multipleSelection">
                                    <div class="selectBox">
                                       <p class="mb-0"><i class="fas fa-user-plus me-1 select-icon"></i> <?php if(!empty($_GET['teacher'])){ echo $_GET['teacher'];}else{ echo 'Category';} ?></p>
                                       <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div id="checkBoxes">
                                       <form action="" method="GET">
                                          <p class="checkbox-title">Category</p>
                                          <!-- <div class="form-custom">
                                             <input type="text" class="form-control bg-grey" placeholder="Enter Teacher Name">
                                          </div> -->
                                          <div class="selectBox-cont">
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="zenny">
                                             <span class="checkmark"></span> Single
                                             </label>
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="Purva">
                                             <span class="checkmark"></span> Multiple
                                             </label>
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="Purva">
                                             <span class="checkmark"></span> Regular
                                             </label>
                                          </div>
                                          <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                          <a href="all_the_class.php" type="reset" class="btn w-100 btn-grey">Reset</a>
                                       </form>
                                    </div>
                                 </div>
                              </li>
                              <li>
                                 <div class="multipleSelection">
                                    <div class="selectBox">
                                       <p class="mb-0"><i class="fas fa-user-plus me-1 select-icon"></i> <?php if(!empty($_GET['teacher'])){ echo $_GET['teacher'];}else{ echo 'Status';} ?></p>
                                       <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div id="checkBoxes">
                                       <form action="" method="GET">
                                          <p class="checkbox-title">Status</p>
                                          <!-- <div class="form-custom">
                                             <input type="text" class="form-control bg-grey" placeholder="Enter Teacher Name">
                                          </div> -->
                                          <div class="selectBox-cont">
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="zenny">
                                             <span class="checkmark"></span> Upcoming
                                             </label>
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="Purva">
                                             <span class="checkmark"></span> Underway
                                             </label>
                                             <label class="custom_check w-100">
                                             <input type="radio" name="teacher" value="Purva">
                                             <span class="checkmark"></span> Completed
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
                                                   <li><a href="all_the_class.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; }echo '&date='.date("Y-m-d"); ?>" class="btn date-btn">Today</a></li>
                                                   <li><a href="all_the_class.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&date='.date('Y-m-d', strtotime('-1 days')); ?>" class="btn date-btn">Yesterday</a></li>
                                                   <li><a href="all_the_class.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&date='.date('Y-m-d', strtotime('-7 days')); ?>" class="btn date-btn">Last 7 days</a></li>
                                                   <li><a href="all_the_class.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&from='.date('Y-m-01', strtotime(date('Y-m-d'))).'&to='.date('Y-m-t', strtotime(date('Y-m-d')));?>" class="btn date-btn">This month</a></li>
                                                   <li><a href="all_the_class.php?teacher=<?php if(!empty($_GET['teacher'])){ echo $_GET['teacher']; } echo '&from='.date("Y-n-j", strtotime("first day of previous month")).'&to='.date("Y-n-j", strtotime("last day of previous month")); ?>" class="btn date-btn">Last month</a></li>
                                                </ul>
                                             </div>
                                             <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                             <a href="all_the_class.php" type="reset" class="btn w-100 btn-grey">Reset</a>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </li>
                             
                           </ul>
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
                                       <th>listing ID</th>
                                       <th>Name</th>
                                       <th>Category</th>
                                       <th>Status</th>
                                       <th>Total Seats</th>
                                       <th>Booked Seats</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){ ?>
                                             
                                    <tr>
                                       <td><?php echo '00'.$row['id'] ?></td>
                                       <td><?php echo $row['name'] ?></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td><a href="orders.php?id=<?php echo $row['id']; ?>">View details</a></td>
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