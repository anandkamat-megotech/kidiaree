<?php include_once 'global.php'; ?>
<?php 

if(!empty($_GET['token'])){$_SESSION['token'] = $_GET['token'];}

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

        <!-- Header Start  -->
        <?php include('const/header.php'); ?>
        <!-- Header End -->


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
                                <h2 class="title">Kid's Details</h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Kid's Details </li>
                                </ul>
                            </div>
                            <!-- Page Banner Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Banner End -->

        <!-- Login & Register Start -->
        <div class="section login-register-section section-padding">
            <div class="container">

                <!-- Login & Register Wrapper Start -->
                <div class="login-register-wrap">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">

                             <!-- Login & Register Box Start -->
                             <div class="login-register-box">
                                <!-- Section Title Start -->
                                <div class="section-title">
                                    <h2>Add Kid's</h2>
                                </div>
                                <!-- Section Title End -->

                                <div class="login-register-form">
                                    <!-- <form action="#"> -->
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="k_name" name="k_name" placeholder="Name ">
                                        </div>
                                        <div class="single-form">
                                            <label class="display-mobile">Enter DOB</label>
                                            <input type="date" class="form-control" id="k_dob_start" name="k_dob" placeholder="dob ">
                                        </div>

                                        <div class="radio-button m-3">
                                            <input type="radio" id="gender" name="gender" value="Male" checked />
                                            <label for="huey">Male</label>
                                            <input type="radio" id="gender" style="margin-left: 10px;" name="gender" value="Female" />
                                            <label for="Female">Female</label>
                                        </div>

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

                                        <div class="form-btn mt-3">
                                            <button class="btn" onclick="saveKids()">Next</button>
                                        </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <!-- Login & Register Box End -->

                        </div>
                    </div>
                </div>
                <!-- Login & Register Wrapper End -->

            </div>
        </div>
        <!-- Login & Register End -->



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Otp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <input id="partitioned" type="text" maxlength="4" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

        <!-- Footer Start -->
        <?php include('const/footer.php'); ?>
        <!-- Footer End -->

        <!-- back to top start -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- back to top end -->




    </div>

    <!-- JS
    ============================================ -->
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
 });
 

    </script>

</body>

</html>