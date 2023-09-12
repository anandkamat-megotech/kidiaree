
<?php include_once 'global.php'; ?>
<?php include_once 'dbConfig.php';
$where = '';
// Get member rows
$getClass = $db->query("SELECT * FROM products where id=".$_GET['id']);
$data = $getClass->fetch_assoc();
// print_r($data);
// echo "SELECT * FROM usersmaster where id=".$data['teacher_id'];
$getTeacher = $db->query("SELECT * FROM usersmaster where id=".$data['teacher_id']);
$dataTeachers = $getTeacher->fetch_assoc();
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
        <div class="section page-banner-section">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="playarea/WhatsApp Image 2023-09-11 at 10.01.50 AM.jpeg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="playarea/WhatsApp Image 2023-09-11 at 10.01.51 AM.jpeg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="playarea/WhatsApp Image 2023-09-11 at 10.01.53 AM.jpeg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
        </div>
        <!-- Page Banner End -->

        <!-- Course Details Start -->
        <div class="section section-padding" style="padding-top:0px !important;">
            <div class="container">

                <div class="row justify-content-between">
                    <div class="col-xl-7 col-lg-8">

                        <!-- Course Details Wrapper Start -->
                        <div class="course-details-wrapper">

                            <!-- Course Overview Start -->
                            <div class="course-overview">
                                <h3 class="title">Playseum</h3>
                                <p>Santacruz West, Mumbai | 2 km Away</p>
                                <p>₹ 1200 for 90 mins for 1 Child + 1 Adult</p>
                                <p><span class="bg-success-text">Open Now </span> | <span class=" bg-danger-text">Closes 7.30pm</span></p>
                            </div>
                            <!-- Course Overview End -->
                            <div class="action_playarea">
                                <button type="button" class="play-btn" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact</button>
                                <button onclick="window.open('https://goo.gl/maps/ZSnuxgHsn7vgnfb49')" type="button" class="play-btn">Directions</button>
                                <button type="button" class="play-btn">Share</button>
                            </div>
                            


                        </div>
                        <!-- Course Details Wrapper End -->

                    </div>
                </div>

                
                <div class="row justify-content-between mt-3">
                    <div class="col-xl-7 col-lg-8">

                        <!-- Course Details Wrapper Start -->
                        <div class="course-details-wrapper">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Activities</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Photos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Food</button>
                        </li>
                        </ul>
                        <div class="tab-content p-1" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h6 class="mt-1">Playseum - Children’s Museum</h6>
                            <p>7th Floor, DLH Mangal Murthi BuildingLinking Road, Santacruz West, Above Jack&Jones</p>
                            <p>Mumbai - 400054</p>
                            <p>Mumbai’s 1st children’s museum and play facility that opened in June 2023</p>
                            <p>✓ 14 interactive exhibits over 1234 sq feet!</p>
                            <p>✓ 50 hands on activities designed with specific learning objectives!</p>
                            <p>✓ 35 artists, educators and developmental psychologists have contributed their craft.</p>

                            <!-- Course Accordion Start -->
                            <div class="course-accordion accordion" id="accordionCourse">
                                    <div class="accordion-item">
                                        <button data-bs-toggle="collapse" data-bs-target="#collapseOne">How can I avail the services at Playseum? </button>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                                <p>You can pre book the visits via a call or via www.kidiaree.in</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo">What is the cost for each session?</button>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                                <p>90 mins - 1200 INR</p>
                                                <p>2 hours - 1400 INR</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree">Package includes one child and one adult</button>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>Child below 1 - 300 INR</p>
                                               <p>Extra Adult - 500 INR</p>
                                               <p>*Socks are mandatory</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse4">What is the duration of each session?</button>
                                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>Each standard session is 90 minutes long. The same can be extended at a nominal fee. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse5">Is there an eatery situated inside the premises?</button>
                                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>Yes, Playseum offers a  garden-themed café aimed to give families and kids a special eating experience. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse6">Will I need to bring anything?</button>
                                        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>You can choose to bring a change of clothes for your children </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse7">Are all the exhibits safe and child friendly?</button>
                                        <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>At Playseum, each exhibit is child friendly, secure and supervised, which lets the children’s imaginations run free.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse8">Do you have facilities for babies and toddlers?</button>
                                        <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>Yes, we do have designated spaces for them.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse9">Can I bring snacks for my children?</button>
                                        <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body" style="padding: 10px 20px;">
                                               <p>Yes, you can but they can only be consumed at eateries.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Course Accordion End -->

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>


                        </div>
                        <!-- Course Details Wrapper End -->

                    </div>
                </div>


            </div>
        </div>
        <!-- Course Details End -->

        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><a href="tel:+919819037944"><i class="flaticon-phone-call"></i> +91 9819037944</a></p>
        <p><a target="_blank" href="https://api.whatsapp.com/send?phone=919819037944&text=Hello" class="whatsapp-button"><i class="fab fa-whatsapp"></i> Send us a message</a></p>
        <p><a target="_blank" href="mailto:enquiries@playseum.in" class="whatsapp-button"><i class="far fa-envelope"></i> Send us an Email</a></p>
      </div>
    </div>
  </div>
</div>

<?php include('const/footer.php'); ?>

        <!-- back to top start -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- back to top end -->

    </div>
    <div id="mybutton">
<button class="book_now_play">Book Now</button>
</div>
    <?php include('const/scripts.php'); ?>

</body>

</html>