<!-- Large, medium -->
<?php 
$active = 'dashboard';
if(isset($_GET['menu'])) $active = $_GET['menu'];

?>
<div class="app-sidebar  Large sidebar">
    <ul>
        <?php if($_SESSION['dashboard'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/" class=" <?php if($active == 'dashboard') echo 'active'; ?>">
                <i class="bi bi-columns-gap"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php } if($_SESSION['books'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/book" class=" <?php if($active == 'books') echo 'active'; ?>">
                <i class="bi bi-book"></i>
                <span>Books</span>
            </a>
        </li>
        <?php } if($_SESSION['categories'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/categories" class=" <?php if($active == 'categories') echo 'active'; ?>">
                <i class="bi bi-table"></i>
                <span>Categories</span>
            </a>
        </li>
        <?php } if($_SESSION['customers'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/customer" class=" <?php if($active == 'customers') echo 'active'; ?>">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
        </li>
        <?php } if($_SESSION['transactions'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/transactions" class=" <?php if($active == 'transactions') echo 'active'; ?>">
                <i class="bi bi-arrow-left-right"></i>
                <span>Transactions</span>
            </a>
        </li>
        <?php } if($_SESSION['reports'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/report" class=" <?php if($active == 'reports') echo 'active'; ?>">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Reports</span>
            </a>
        </li>
        <?php } if($_SESSION['users'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/users" class=" <?php if($active == 'users') echo 'active'; ?>">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li>
        <?php }  ?>

        <!-- <li>
            <a href="">
                <i class="bi bi-currency-dollar"></i>
                <span>Sales</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-graph-up"></i>
                <span>Reports</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li> -->
    </ul>
</div>
<div class="sidebar-overlay"></div>