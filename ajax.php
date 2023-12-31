<?php 
include_once "global.php";
include_once 'dbConfig.php';

if ($_GET['action']){
    switch($_GET['action']){
        case "product-subscription-filter" : 
            echo action_product_subscription_filter($db,8);
        break;
        case "product-academic-filter":
            echo action_product_academic_filter($db,1);
        break;
    }
}
function action_product_academic_filter($db,$category_id=1){
    $filter = $_POST['filter'];
    $query = "SELECT * FROM products where 
            `service_type` = ".$category_id;
    if (isset($filter['academic']['type'])){
        $query .= "AND `type` IN('".implode('\',\'',$filter['academic']['type'])."')  ";
    }
    if (isset($filter['academic']['subject'])){
        $query .= "AND `subjects` IN('".implode('\',\'',$filter['academic']['subject'])."') ";
    }
    if (isset($filter['academic']['grade'])){
        $query .= "AND `grade` IN('".implode('\',\'',$filter['academic']['grade'])."')";
    }
    $query .= " order by id desc";
    $where = '';
    // Get member rows
    
    $getClass_md = $db->query($query);
    if($getClass_md->num_rows > 0){
        while($row_md = $getClass_md->fetch_assoc()){
        ?>
        <div class="col-lg-3 col-sm-6">
            <!-- Single Courses Start -->
            <div class="single-course">
                <div class="courses-image">
                    <a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><img src="<?php echo $row_md['thumbnail'] ?>" alt="Courses"></a>
                </div>
                <div class="courses-content">
                    <div class="top-meta">
                        <div class="tag-time">
                            <a class="tag" href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['type'] ;?></a>
                            <p class="time"><i class="fa fa-birthday-cake"></i> <?php echo $row_md['age'] ;?> Yrs</p>
                        </div>
                    </div>
                    <h3 class="title mt-2"><a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['name'] ;?></a></h3>
                    <div class="top-meta  mt-2">
                        <span class="price">
                        <span class="sale-price">INR <?php echo $row_md['price'] ;?></span>
                        </span>
                    </div>
                </div>
            </div>
            <!-- Single Courses End -->
        </div>
        <?php 
        } 
    }else{ ?>
        <p class="mt-3 text-center">No Class(s) found...</p>          
    <?php } 
    
}
function action_product_subscription_filter($db,$category_id=8){
    $filter = $_POST['filter'];
    $where = '';
    // Get member rows
    $getClass_md = $db->query("SELECT * FROM products where service_type = ".$category_id."  AND subscription_type IN('".implode('\',\'',$filter['subscriptions']['type'])."')  order by id desc");
    if($getClass_md->num_rows > 0){
        while($row_md = $getClass_md->fetch_assoc()){
        ?>
        <div class="col-lg-3 col-sm-6">
            <!-- Single Courses Start -->
            <div class="single-course">
                <div class="courses-image">
                    <a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><img src="<?php echo $row_md['thumbnail'] ?>" alt="Courses"></a>
                </div>
                <div class="courses-content">
                    <div class="top-meta">
                        <div class="tag-time">
                            <a class="tag" href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['type'] ;?></a>
                            <p class="time"><i class="fa fa-birthday-cake"></i> <?php echo $row_md['age'] ;?> Yrs</p>
                        </div>
                    </div>
                    <h3 class="title mt-2"><a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['name'] ;?></a></h3>
                    <div class="top-meta  mt-2">
                        <span class="price">
                        <span class="sale-price">INR <?php echo $row_md['price'] ;?></span>
                        </span>
                    </div>
                </div>
            </div>
            <!-- Single Courses End -->
        </div>
        <?php 
        } 
    }else{ ?>
        <p class="mt-3 text-center">No Class(s) found...</p>          
    <?php } 
    
}

?>