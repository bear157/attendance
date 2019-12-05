<!-- Sidebar  -->
<button class="btn float-right mr-1 d-block d-sm-none hamburger" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
<nav class="d-none d-sm-block col-12 col-sm-2 no-gutter" id="sidebar">
    <div class="sidebar-logo">
        <img src="/attendance/assets/images/southern_logo.jpg">
    </div>
    <button class="btn float-right mr-1 d-block d-sm-none hamburger text-light" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div class="pt-2 sidebar-header border-bottom">
        <h5 class="text-center"><?= USR_FULL_NAME; ?></h5>
        <h6 class="text-center small" id="menu_datetime"></h6>
        <p class="text-right mb-1 pr-3 small" id="btn-logout"><a href="/attendance/logout.php">Logout <i class="fa fa-sign-out-alt"></i></a></p>
        <p class="text-right mb-2 pr-3 small"><a href="<?= MENU_DIR; ?>/index.php">Home <i class="fa fa-home"></i> </a></p> 
    </div>

    <ul class="list-unstyled components">
        <li>
            <a href="<?= MENU_DIR; ?>/attendance_status.php">Attendance Status</a>
        </li>

        <li>
            <a href="<?= MENU_DIR; ?>/timetable.php" target="_blank">Timetable</a>
        </li>
    </ul>  
</nav>
