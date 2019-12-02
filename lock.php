<?php 
session_start(); 
date_default_timezone_set('Asia/Kuala_Lumpur'); 

if(!isset($_SESSION["usr_id"]))
{
    session_destroy(); 
    header("Location: /attendance/index.php"); 
    die;
}

// load all classes
spl_autoload_register(function ($class) {
    include "classes/" . $class . ".php";
});

// db connection
$db = new Database();

/** GLOBAL VARIABLES
**
* USR_ID - which user is login to this system 
* USR_FULL_NAME - user full name 
* USR_TYPE - user type 
* MENU_DIR - the href for the menu 
* SEM_ID - what semester is it 
* SEM_START - semester date start
* SEM_END - semester date end
*/
define('USR_ID', $_SESSION["usr_id"]); 
define('USR_FULL_NAME', $_SESSION["full_name"]); 
define('USR_TYPE', $_SESSION["usr_type"]); 
switch(USR_TYPE)
{
    case 1: 
        define('MENU_DIR', '/attendance/student'); 
        break;
    case 2: 
        define('MENU_DIR', '/attendance/lecturer'); 
        include "functions/func_lecturer.php";
        break;
    case 3:
        define('MENU_DIR', '/attendance/admin'); 
        break;
} // end switch

// check what semester is
$sem_class = new Semester($db->conn); 
list($sem_id, $sem_start, $sem_end) = $sem_class->getCurrentSemester();
define("SEM_ID", $sem_id); 
define("SEM_START", $sem_start); 
define("SEM_END", $sem_end); 


// common function
include "functions/common.php"; 





?>