

<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
               <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                     <li class="menu-title">
                        <span>Main Menu</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Admin Dashboard</a></li>
                        </ul>
                     </li>
                     <li class="menu-title">
                        <span>Ecommerce</span>
                     </li>
                     <li class="submenu <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ||  basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Sales</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="#" class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">Orders</a></li>
                           <li><a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">Transactions</a></li>
                        </ul>
                     </li>
                        </ul>
                     </li>
                  </ul>
               </div>
            </div>
         </div>