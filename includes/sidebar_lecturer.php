<!-- Sidebar  -->
<nav class="col-2 no-gutter" id="sidebar">
    <div class="sidebar-logo">
        <img src="/attendance/assets/images/lanyangyang.jpg">
    </div>

    <div class="pt-2 sidebar-header border-bottom">
        <h5 class="text-center"><?= USR_FULL_NAME; ?></h5>
        <h6 class="text-center small" id="menu_datetime"></h6>
        <p class="text-right mb-1 pr-3 small" id="btn-logout"><a href="/attendance/logout.php">Logout <i class="fa fa-sign-out-alt"></i></a></p>
        <p class="text-right mb-2 pr-3 small"><a href="<?= MENU_DIR; ?>/index.php">Home <i class="fa fa-home"></i> </a></p> 
    </div>

    <ul class="list-unstyled components">
        <li>
            <a href="<?= MENU_DIR; ?>/view_subject.php">Subject</a>
        </li>
    </ul>  
</nav>
