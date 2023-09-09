<?php include_once 'global.php'; ?>
<?php 
if(!empty($_GET['token'])){
   $_SESSION['token'] = $_GET['token'];
}

$token = $_SESSION['token'];


?>
<?php

   //
   // A very simple PHP example that sends a HTTP POST to a remote site
   //
   
   // print_r($token);
   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree."/main-file/get_all_user_details.php");
   $authorization = "Authorization: Bearer ".$token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   $result = curl_exec($ch);
   curl_close($ch);
//    print_r($result);
   $kids =json_decode($result);


   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree."/main-file/get_user_profile_details.php");
   $authorization = "Authorization: Bearer ".$token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   $resultProfile = curl_exec($ch);
   curl_close($ch);
//    print_r($result);
   $profile =json_decode($resultProfile);
   // print_r($profile->code);
   // print_r($profile->body);
   // Further processing ...
   // if ($server_output == "OK") { ... } else { ... }
   ?>
<?php include_once 'dbConfig.php';
$where = '';
// Get member rows
$getClass = $db->query("SELECT * FROM products where teacher_id = ".$profile->body[0]->id."  order by id desc");
?>
<!doctype html>
<html class="no-js" lang="en">
<?php include('const/head.php'); ?>
   <body>
      <div class="main-wrapper">
         <!-- Preloader start -->
         <div id="preloader">
            <div class="preloader">
               <span></span>
               <span></span>
            </div>
         </div>
         <!-- Preloader End -->
         <?php include('const/header.php'); ?>
         <!-- Page Banner Start -->
         <div class="section page-banner-section" style="background-image: url(assets/images/bg/page-banner.jpg);">
            <div class="shape-1">
               <img src="assets/images/shape/shape-7.png" alt="">
            </div>
            <div class="shape-2">
               <img src="assets/images/shape/shape-1.png" alt="">
            </div>
            <div class="shape-3"></div>
            <div class="container">
               <div class="page-banner-wrap">
                  <div class="row">
                     <div class="col-lg-12">
                        <!-- Page Banner Content Start -->
                        <div class="page-banner text-center">
                           <h2 class="title">Profile</h2>
                           <ul class="breadcrumb justify-content-center">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Profile (Teacher) </li>
                           </ul>
                        </div>
                        <!-- Page Banner Content End -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Banner End -->
         <!-- Course Details Start -->
         <div class="section section-padding">
            <div class="container">
               <div class="row justify-content-between">
                  <div class="col-xl-7 col-lg-8 mx-auto">
                     <!-- Course Details Wrapper Start -->
                     <div class="course-details-wrapper">
                        <!-- Course Lessons Start -->
                        <div class="course-lessons">
                           <div class="lessons-top">
                              <h3 class="title">Settings</h3>
                              <div class="lessons-time">
                                 <a href="add_new_class.php" class="btn btn-primary btn-sm-add-student">  Add New Class</a> 
                                 <?php if($profile->body[0]->parents_teacher == "YES"){ ?>
                                 <button class="btn btn-primary btn-sm-add-student" href="#" data-bs-toggle="modal" data-bs-target="#kidsModal">  Add New Child</button> 
                                 <?php } ?>
                              </div>
                           </div>
                           <!-- Course Accordion Start -->
                           <div class="course-accordion accordion" id="accordionCourse">
                           <div class="accordion-item">
                                 <button  data-bs-toggle="collapse" data-bs-target="#collapseCourseManage">Manage Course</button>
                                 <div id="collapseCourseManage" class="accordion-collapse collapse show" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body">
                                    <?php
                                                    if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){
                                                            // print_r($row );
                                                            // die;
                                                            $msg_div = '';
                                                            if($row['status'] == 0){
                                                               $msg_div = '<div class="order-date" style="color:red">Not Approved by admin yet</div>';
                                                            }elseif($row['status'] == 2){
                                                               $msg_div = '<div class="order-date" style="color:#fbba41">Rework</div>';
                                                            }else{
                                                               $msg_div = '<div class="order-date">Uploaded on : '.$new_date = date('d F  y -  h:i:s A', strtotime($row['created_at'])) .'</div>';
                                                            }
                                                            echo $msg_div;
                                                    ?>
                                    
                                                   <div class="single-course-list single-course mb-3" style="border-radius: 10px;border:1px solid #ddd;display:inline-block !important;border-style: dashed;">
                                                            <div class="action-course"><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </div>        
                                                            <div class="course-image width-thumb">
                                                               <a href="#"><img src="<?php echo $row['thumbnail']; ?>" alt="Courses"></a>
                                                         </div>
                                                         <div class="courses-content width-content" style="padding-top: 0px !important;">
                                                               <h3 class="title" style="margin-top: 0px !important;"><a href="<?php echo $row['product_url'].'?id='.$row['id']; ?>" style="font-size: 14px !important;"><?php echo $row['name']; ?></a></h3>

                                                               <div class="top-meta">
                                                                     <span class="price">
                                                                     <span class="sale-price" style="font-size: 12px !important;">INR <?php echo $row['price']; ?></span>
                                                                     </span>
                                                               </div>
                                                               <ul class="description-list">
                                                                  <li><i class="flaticon-location-pin creative-page-icons"></i> <?php echo $row['type']; ?></li>
                                                                  <li><i class="far fa-calendar-alt creative-page-icons"></i> 16-20 Jul, 2023 </li>
                                                                  <li><i class="fa fa-stopwatch creative-page-icons"></i> 60 mins per session</li>
                                                               </ul>
                                                            </div>
                                                      </div>
                                       <?php } }else{ ?>
                                             <p class="mt-3 text-center">No Class(s) found...</p>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                              <?php if($profile->body[0]->parents_teacher == "YES"){ ?> 
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse"  data-bs-target="#collapseOne">Kids Details </button>
                                 <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                <!-- <th scope="col">#</th> -->
                                                <th scope="col">Name</th>
                                                <th scope="col">D.O.B (Age)</th>
                                                <th scope="col">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php foreach($kids->body as $value){   $year = (date('Y') - date('Y',strtotime($value->dob))); ?>
                                             <tr>
                                                <!-- <th scope="row"><?php echo $value->id ?></th> -->
                                                <td><?php echo $value->kid_name ?></td>
                                                <td><?php echo  $newDate = date("d/m/Y", strtotime( $value->dob)); ?> (<?php echo $year; ?> yrs)</td>
                                                <td><i class="fa fa-user-edit icon-style" onclick="getKidsDashboard('<?php echo $value->id ?>')"></i><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo">Upcoming Classes & Activities</button>
                                 <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body">
                                       <div class="accordion-body table-responsive">
                                          <table class="table table-striped mt-3">
                                             <tbody>
                                                <tr>
                                                   <th scope="row">1</th>
                                                   <td>Class One</td>
                                                   <td>Today 10:00pm</td>
                                                   <td><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">2</th>
                                                   <td>Class two</td>
                                                   <td>Tomorrow 02:00pm</td>
                                                   <td><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </td>
                                                </tr>
                                                <tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree">My Bookings</button>
                                 <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body">
                                    <div class="order-date">Booked on : 12 July 2023, 12:45:00 pm</div>
                                    <div class="single-course-list single-course" style="border-radius: 10px;border:1px solid #ddd;display:inline-block !important;border-style: dashed;">
                                            <div class="course-image width-thumb">
                                                <a href="course-details.html"><img src="assets/images/two_z.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="courses-content width-content" style="padding-top: 0px !important;">
                                                <h3 class="title" style="margin-top: 0px !important;"><a href="creative_writing_lab_single.php" style="font-size: 14px !important;">Creative Writing Lab 4</a></h3>

                                                <div class="top-meta">
                                                      <span class="price">
                                                      <span class="sale-price" style="font-size: 12px !important;">INR 6000</span>
                                                      </span>
                                                </div>
                                                <ul class="description-list">
                                                   <li><i class="flaticon-location-pin creative-page-icons"></i> Online</li>
                                                   <li><i class="far fa-calendar-alt creative-page-icons"></i> 16-20 Jul, 2023 </li>
                                                   <li><i class="fa fa-stopwatch creative-page-icons"></i> 60 mins per session</li>
                                                </ul>
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour">My Favorites </button>
                                 <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body table-responsive">
                                       <table class="table table-striped mt-3">
                                          <tbody>
                                             <tr>
                                                <th scope="row">1</th>
                                                <td>Creative class lab</td>
                                                <td><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <tr>
                                                <th scope="row">2</th>
                                                <td>The Drum</td>
                                                <td><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive">Profile Settings </button>
                                 <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body mt-2">
                                       <ul class="lessons-list">
                                          <li><a href=""><i class="fa fa-user"></i> <?php echo strtok($profile->body[0]->email, '@') ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-blender-phone"></i> <?php echo $profile->body[0]->mobile; ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-envelope"></i> <?php echo $profile->body[0]->email; ?><span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-map-marker"></i> <?php echo $profile->body[0]->addressLine2; ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Course Accordion End -->
                           <!-- Modal -->
                           <div class="modal fade" id="kidsModal" tabindex="-1" aria-labelledby="kidsModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="kidsModalLabel">Kid Details</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <!-- Contact Form Wrap Start -->
                                       <div class="contact-form-wrap">
                                          <form action="#">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Name</label>
                                                      <input class="form-control" type="text" id="k_name" name="k_name" placeholder="e.g Amit Singh">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Select Date of birth</label>
                                                      <input class="form-control" type="date"  placeholder="Dob" id="k_dob_start">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="radio-button m-3">
                                                        <input type="radio" id="gender" name="gender" value="Male" checked />
                                                        <label for="huey">Male</label>
                                                        <input type="radio" id="gender" style="margin-left: 10px;" name="gender" value="Female" />
                                                        <label for="Female">Female</label>
                                                    </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <select class="mt-3 mb-3 w-100" name="grade" id="grade">
                                                        <option>Pre-school</option>
                                                        <option>Nursery</option>
                                                        <option>Junior KG</option>
                                                        <option>Senior KG</option>
                                                        <option>Grade 1</option>
                                                        <option>Grade 2</option>
                                                        <option>Grade 3</option>
                                                        <option>Grade 4</option>
                                                        <option>Grade 5</option>
                                                        <option>Grade 6</option>
                                                        <option>Grade 7</option>
                                                        <option>Grade 8</option>
                                                        <option>Grade 9</option>
                                                        <option>Grade 10</option>
                                                    </select>
                                                   <!-- Single Form End -->
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!-- Contact Form Wrap End -->
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" onclick="saveKidsDashboardAdd('none')">Save</button>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <!-- Modal -->
                           <div class="modal fade" id="kidsModalEdit" tabindex="-1" aria-labelledby="kidsModalEditLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="kidsModalEditLabel">Kid Details</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <!-- Contact Form Wrap Start -->
                                       <div class="contact-form-wrap">
                                          <form action="#">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Name</label>
                                                      <input class="form-control" type="hidden" id="k_id" name="k_id" >
                                                      <input class="form-control" type="text" id="k_name_edit" name="k_name" placeholder="e.g Amit Singh">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Select Date of birth</label>
                                                      <input class="form-control" type="date"  placeholder="Dob" id="k_dob_start_edit">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="radio-button m-3">
                                                        <input type="radio" id="gender_Male" name="gender" value="Male" checked />
                                                        <label for="huey">Male</label>
                                                        <input type="radio" id="gender_Female" style="margin-left: 10px;" name="gender" value="Female" />
                                                        <label for="Female">Female</label>
                                                    </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <select class="mt-3 mb-3 w-100" name="grade" id="grade_edit">
                                                        <option>Pre-school</option>
                                                        <option>Nursery</option>
                                                        <option>Junior KG</option>
                                                        <option>Senior KG</option>
                                                        <option>Grade 1</option>
                                                        <option>Grade 2</option>
                                                        <option>Grade 3</option>
                                                        <option>Grade 4</option>
                                                        <option>Grade 5</option>
                                                        <option>Grade 6</option>
                                                        <option>Grade 7</option>
                                                        <option>Grade 8</option>
                                                        <option>Grade 9</option>
                                                        <option>Grade 10</option>
                                                    </select>
                                                   <!-- Single Form End -->
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!-- Contact Form Wrap End -->
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" onclick="saveKidsDashboard('none')">Save</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Course Lessons End -->
                     </div>
                     <!-- Course Details Wrapper End -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Course Details End -->
         <?php include('const/footer.php'); ?>
         <!-- back to top start -->
         <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
               <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
         </div>
         <!-- back to top end -->
      </div>
      <?php include('const/scripts.php'); ?>
      <script>
        
$(document).ready(function() {
  // executes when HTML-Document is loaded and DOM is ready
  var date = new Date();
  console.log(date);
  var dd = date.getDate();
  var mm = date.getMonth() + 1;
  var yyyy = date.getFullYear();

  //Add a zero if one Digit (eg: 05,09)
  if (dd < 10) {
    dd = "0" + dd;
  }

  //Add a zero if one Digit (eg: 05,09)
  if (mm < 10) {
    mm = "0" + mm;
  }

  minYear = yyyy - 18; //Calculate Minimun Age (<80)
  maxYear = yyyy - 1; //Calculate Maximum Age (>18)

  var min = minYear + "-" + mm + "-" + dd;
  var max = maxYear + "-" + mm + "-" + dd;
  console.log(min);
  console.log(max);

  document.getElementById("k_dob_start").setAttribute("min", min);
  document.getElementById("k_dob_start").setAttribute("max", max);
  document.getElementById("k_dob_start_edit").setAttribute("min", min);
  document.getElementById("k_dob_start_edit").setAttribute("max", max);
 });
 

    </script>
   </body>
</html>