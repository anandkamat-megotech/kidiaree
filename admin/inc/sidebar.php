
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
                     <li class="menu-title">
                        <span>Main Menu</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Admin Dashboard</a></li>
                           <li><a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">Class /Activity</a></li>
                           <li><a href="enquiry.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'enquiry.php' ? 'active' : ''; ?>">Users</a></li>
                           <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Enquires</a></li>
                        </ul>
                     </li>
                     <li class="menu-title">
                        <span>Ecommerce</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ||  basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Sales</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">Orders</a></li>
                           <li><a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">Transactions</a></li>
                        </ul>
                     </li>
                        </ul>
                     </li>
                  </ul>
               </div>
               <?php } else{ $role_name = 'Partner'; ?>
                  <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                     <li class="menu-title">
                        <span>Main Menu</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                           <li><a href="teacher_products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'teacher_products.php' ? 'active' : ''; ?>">Class /Activity</a></li>
                        </ul>
                     </li>
                     <li class="menu-title">
                        <span>Ecommerce</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ||  basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Sales</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="all_the_class.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'all_the_class.php' ? 'active' : ''; ?>">My Bookings</a></li>
                           <li><a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">Transactions</a></li>
                        </ul>
                     </li>
                        </ul>
                     </li>
                  </ul>
               </div>
               <?php } ?>
            </div>
         </div>