
<?php 
$role = 1;
$role_name = 'Admin';
if(!empty($user_details)){
$role = $user_details->body[0]->idRole;
}
?>
<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
               <?php if($role == '1'){ ?>
               <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                  <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Admin Dashboard</a></li>
                  <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">Class /Activity</a></li>
                  <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'enquiry.php' ? 'active' : ''; ?>"><a href="enquiry.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'enquiry.php' ? 'active' : ''; ?>">Users</a></li>
                  <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Enquires</a></li>
                 
                  <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>"><a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">Transactions</a></li>
                        </ul>
                     </li>
                  </ul>
               </div>
               <?php } else{ $role_name = 'Partner'; ?>
                  <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                     <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="#" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                     <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'teacher_products.php' ? 'active' : ''; ?>"><a href="teacher_products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'teacher_products.php' ? 'active' : ''; ?>">Class /Activity</a></li>
                     <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'all_the_class.php' || basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>"><a href="all_the_class.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'all_the_class.php' || basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">My Bookings</a></li>
                     <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>"><a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">Transactions</a></li>
                  </ul>
               </div>
               <?php } ?>
            </div>
         </div>