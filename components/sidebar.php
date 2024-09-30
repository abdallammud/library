<!-- Large, medium -->
<?php 
$active = 'dashboard';
if(isset($_GET['menu'])) $active = $_GET['menu'];

?>
<div class="app-sidebar sidebar">
    <ul>
        <?php if($_SESSION['dashboard'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/" class="<?php if($active == 'dashboard') echo 'active'; ?>">
                <i class="bi bi-columns-gap"></i>
                <span><?= $lang['dashboard']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['books'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/book" class="<?php if($active == 'books') echo 'active'; ?>">
                <i class="bi bi-book"></i>
                <span><?= $lang['books']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['categories'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/categories" class="<?php if($active == 'categories') echo 'active'; ?>">
                <i class="bi bi-table"></i>
                <span><?= $lang['categories']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['customers'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/customer" class="<?php if($active == 'customers') echo 'active'; ?>">
                <i class="bi bi-people"></i>
                <span><?= $lang['customers']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['transactions'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/transactions" class="<?php if($active == 'transactions') echo 'active'; ?>">
                <i class="bi bi-arrow-left-right"></i>
                <span><?= $lang['transactions']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['reports'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/report" class="<?php if($active == 'reports') echo 'active'; ?>">
                <i class="bi bi-graph-up-arrow"></i>
                <span><?= $lang['reports']; ?></span>
            </a>
        </li>
        <?php } if($_SESSION['users'] == 'on') { ?>
        <li>
            <a href="<?=BASE_URI;?>/users" class="<?php if($active == 'users') echo 'active'; ?>">
                <i class="bi bi-people"></i>
                <span><?= $lang['users']; ?></span>
            </a>
        </li>
        <?php } ?>

        <li>
            <a href="https://api.whatsapp.com/send?phone=252618211138">
                <i class="bi bi-info-circle"></i>
                <span><?= $lang['help']; ?></span>
            </a>
        </li>
    </ul>
</div>

<div class="sidebar-overlay"></div>