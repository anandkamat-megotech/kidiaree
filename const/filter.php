<?php if($_GET['page'] == "subscription" || $_GET['category_id'] == 8){ ?>
    <div class="sidebar-wrap-02">

    <!-- Sidebar Wrapper Start -->
    <div class="sidebar-widget-02">
        <h3 class="widget-title">Search Subscriptions</h3>

        <div class="">
            <form>
                <!-- <li class="form-check"> -->
                    <input class="form-control mt-2" type="text" placeholder="e.g. Boxes, Magazines " value="" id="checkbox1">
                    <!-- <label class="form-check-label" for="checkbox1">Online (11)</label> -->
                <!-- </li> -->
            </form>
        </div>
    </div>
    <!-- Sidebar Wrapper End -->

    <div class="course-accordion accordion" id="accordionCourse">
    <div class="accordion-item">
            <button data-bs-toggle="collapse" data-bs-target="#collapseOne">Quick Filters </button>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                <div class="accordion-body mt-2">
                        <!-- Sidebar Wrapper Start -->
    <div class="sidebar-widget-02 mt-3">
        <h3 class="widget-title">Subscriptions </h3>
        <form id="filterable-subscription" class="filterable">
            <div class="widget-checkbox">
                <ul class="checkbox-list ">
                    <li class="form-check">
                        <input class="form-check-input" name="filter[subscriptions][type][]" type="checkbox" value="activity_boxes" id="checkbox3">
                        <label class="form-check-label" for="checkbox3">Activity Boxes </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" name="filter[subscriptions][type][]" type="checkbox" value="newspapers_magazines" id="checkbox4">
                        <label class="form-check-label" for="checkbox4">Newspapers & Magazines</label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" name="filter[subscriptions][type][]" type="checkbox" value="toy_book_libraries" id="checkbox5">
                        <label class="form-check-label" for="checkbox5">Toy & Book Libraries</label>
                    </li>
                </ul>
            </div>
        </form>
    </div>
    <!-- Sidebar Wrapper End -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php }elseif($_GET["page"] == "academic" || $_GET['category_id'] == 1){ ?> 
    <div class="sidebar-wrap-02">

    <!-- Sidebar Wrapper Start -->
    <div class="sidebar-widget-02">
        <h3 class="widget-title">Search Classes</h3>

        <div class="">
            <form>
                <!-- <li class="form-check"> -->
                    <input class="form-control mt-2" type="text" placeholder="e.g. math or english" value="" id="checkbox1">
                    <!-- <label class="form-check-label" for="checkbox1">Online (11)</label> -->
                <!-- </li> -->
            </form>
        </div>
    </div>
    <!-- Sidebar Wrapper End -->

    <div class="course-accordion accordion" id="accordionCourse">
    <div class="accordion-item">
            <button data-bs-toggle="collapse" data-bs-target="#collapseOne">Quick Filters </button>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                <div class="accordion-body mt-2">
                    <form id="filterable-academic" >
                        <!-- Sidebar Wrapper Start -->
                        <div class="sidebar-widget-02">
                            <h3 class="widget-title">Mode</h3>

                            <div class="widget-checkbox">
                                <ul class="checkbox-list">
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][mode][]" value='online' id="checkbox1" checked>
                                        <label class="form-check-label" for="checkbox1">Online</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][mode][]" value="offline" id="checkbox2" checked>
                                        <label class="form-check-label" for="checkbox2">Offline</label>
                                        <ul class="checkbox-list">
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" name="filter[academic][mode][]" value="" id="checkbox12">
                                                <label class="form-check-label" for="checkbox12">Teacher to travel</label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Wrapper End -->

                        <!-- Sidebar Wrapper Start -->
                        <div class="sidebar-widget-02">
                            <h3 class="widget-title">Subject(s) </h3>

                            <div class="widget-checkbox">
                                <ul class="checkbox-list">
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[acdemic][subject][]" value="english" id="checkbox3">
                                        <label class="form-check-label" for="checkbox3">English</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][subject][]" value="math" id="checkbox4">
                                        <label class="form-check-label" for="checkbox4">Math</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox"  name="filter[academic][subject][]" value="evs" id="checkbox5">
                                        <label class="form-check-label" for="checkbox5">EVS / Science</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][subject][]" value="physics" id="checkbox6">
                                        <label class="form-check-label" for="checkbox7">Physics</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][subject][]" value="chemistry" id="checkbox8">
                                        <label class="form-check-label" for="checkbox8">Chemistry</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][subject][]" value="biology" id="checkbox9">
                                        <label class="form-check-label" for="checkbox9">Biology</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][subject][]" value="computer_science" id="checkbox10">
                                        <label class="form-check-label" for="checkbox10">Computer Science</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checkbox11">
                                        <label class="form-check-label" for="checkbox11">Indian Languages</label>
                                        <div class="widget-checkbox">
                                            <ul class="checkbox-list">
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][languages][]" value="hindi" id="checkbox12">
                                                    <label class="form-check-label" for="checkbox12">Hindi</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][languages][]" value="marathi" id="checkbox13">
                                                    <label class="form-check-label" for="checkbox13">Marathi</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][languages][]" value="bengali" id="checkbox14">
                                                    <label class="form-check-label" for="checkbox14">Bengali</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][languages][]" value="kannada" id="checkbox15">
                                                    <label class="form-check-label" for="checkbox15">Kannada</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][languages][]" value="sanskrit" id="checkbox16">
                                                    <label class="form-check-label" for="checkbox16">Sanskrit</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checkbox11">
                                        <label class="form-check-label" for="checkbox11">Board</label>
                                        <div class="widget-checkbox">
                                            <ul class="checkbox-list">
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][board][]" value="ICSCE" id="checkbox12">
                                                    <label class="form-check-label" for="checkbox12">ICSCE</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][board][]" value="CBSE" id="checkbox13">
                                                    <label class="form-check-label" for="checkbox13">CBSE</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][board][]" value="IB" id="checkbox14">
                                                    <label class="form-check-label" for="checkbox14">IB</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][board][]" value="IGCSE" id="checkbox15">
                                                    <label class="form-check-label" for="checkbox15">IGCSE</label>
                                                </li>
                                                <li class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filter[academic][board][]" value="state_board" id="checkbox16">
                                                    <label class="form-check-label" for="checkbox16">State Board</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Wrapper End -->

                        <!-- Sidebar Wrapper Start -->
                        <div class="sidebar-widget-02">
                            <h3 class="widget-title">Grade</h3>

                            <div class="widget-checkbox">
                                <ul class="checkbox-list">
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="pre_school" id="checkbox17">
                                        <label class="form-check-label" for="checkbox17">Pre-school</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="nursery" id="checkbox18">
                                        <label class="form-check-label" for="checkbox18">Nursery</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="junior_kg" id="checkbox19">
                                        <label class="form-check-label" for="checkbox19">Junior KG</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="senior_kg" id="checkbox20">
                                        <label class="form-check-label" for="checkbox20">Senior KG</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_1" id="checkbox21">
                                        <label class="form-check-label" for="checkbox21">Grade 1</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_2" id="checkbox21">
                                        <label class="form-check-label" for="checkbox22">Grade 2</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_3" id="checkbox23">
                                        <label class="form-check-label" for="checkbox23">Grade 3</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_4" id="checkbox24">
                                        <label class="form-check-label" for="checkbox24">Grade 4</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_5" id="checkbox25">
                                        <label class="form-check-label" for="checkbox25">Grade 5</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_6" id="checkbox26">
                                        <label class="form-check-label" for="checkbox26">Grade 6</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_7" id="checkbox27">
                                        <label class="form-check-label" for="checkbox27">Grade 7</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_8" id="checkbox28">
                                        <label class="form-check-label" for="checkbox28">Grade 8</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_9" id="checkbox29">
                                        <label class="form-check-label" for="checkbox29">Grade 9</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="filter[academic][grade][]" value="grade_10" id="checkbox30">
                                        <label class="form-check-label" for="checkbox30">Grade 10</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Wrapper End -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php }else {?>
   
    <div class="sidebar-wrap-02">

    <!-- Sidebar Wrapper Start -->
    <div class="sidebar-widget-02">
        <h3 class="widget-title">Search Classes</h3>

        <div class="">
            <form>
                <!-- <li class="form-check"> -->
                    <input class="form-control mt-2" type="text" placeholder="e.g. math or english" value="" id="checkbox1">
                    <!-- <label class="form-check-label" for="checkbox1">Online (11)</label> -->
                <!-- </li> -->
            </form>
        </div>
    </div>
    <!-- Sidebar Wrapper End -->

</div>
<?php } ?>
 <!--  -->
 <?php 
    $hookManager->addHook('execute_jquery', function () {
        ?>
            <script>
            $(document).ready(function(){
                $("#filterable-subscription input").change(function(){
                    $.ajax({
                        url : "<?= base_url('ajax.php?action=product-subscription-filter')?>",
                        method: 'post',
                        data: $("#filterable-subscription").serialize(),
                        success:function(response){
                           $("#load-items").html(response);
                        }
                    });
                });
                $("#filterable-academic input").change(function(){
                    $.ajax({
                        url : "<?= base_url('ajax.php?action=product-academic-filter')?>",
                        method: 'post',
                        data: $("#filterable-academic").serialize(),
                        success:function(response){
                           $("#load-items").html(response);
                        }
                    });
                });
            });
            </script>
        <?php
    });
 ?>
