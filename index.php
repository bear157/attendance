<?php 
session_start(); 
date_default_timezone_set('Asia/Kuala_Lumpur'); 
ini_set('display_errors', 'Off');
// assign page title
$page_title = "Login"; 

// db conn
include "classes/Database.php"; 
$db = new Database(); 

// if scan qr 
if(!empty($_GET["aid"]) && !empty($_GET["sub"]))
{
    $aid = $_GET["aid"]; 
    $sub = $_GET["sub"]; 
}
else
{
    $aid = "";
    $sub = "";
}


if(isset($_SESSION["login_error"]))
{
    $login_error = $_SESSION["login_error"]; 
}
else
{
    $login_error = 0;
}

if(isset($_POST["username"]))
{
    $username = $_POST["username"]; 
    $usr_password = $_POST["usr_password"]; 

    $info = null;
    $aid = $_POST["aid"] == "" ? null : $_POST["aid"]; 
    $sub = $_POST["sub"] == "" ? null : $_POST["sub"]; 

    if(!is_null($aid) && !is_null($sub))
    {
        $info = array(); 
        $info["act_id"] = $aid; 
        $info["sub_id"] = $sub; 
    }

    include "classes/User.php"; 
    $user_class = new User($db->conn); 
    $user_class->login($username, $usr_password, $info); 
}

include 'functions/common.php';
echo getRandomWord();

// include page header
include 'includes/header.php';
?>
<style type="text/css">
    #login-form .form-group *, 
    #login-form p 
    {
        font-size: 14px !important; 
    }

    #login-form legend 
    {
        font-size: 18px !important; 
        font-weight: 500; 
    }

    p#response_text 
    {
        color: red; 
    }
    
    body
    {
      background-image: url("assets/images/login-bg.png"); 
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    }
</style>

<div class="container-fluid" id="login-page">
    <div class="row no-gutter pt-5">
        <div class="card col-10 col-sm-4 mx-auto mt-5 shadow-lg border border-light rounded-lg">
            <div class="card-body">
                <form class="needs-validation" id="login-form" method="POST" action="index.php">
                    <input type="hidden" name="aid" value="<?= $aid; ?>" />
                    <input type="hidden" name="sub" value="<?= $sub; ?>" />

                    <legend>SUC Attendance System</legend>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input class="form-control" type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input class="form-control" type="password" name="usr_password" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">LOGIN</button>
                    </div>

                    <p class=" <?= ($login_error!=0) ? "show" : "hide"; ?>" id="response_text">
                        <?php 
                        switch($login_error) 
                        {
                            case 1: echo "Invalid username or password!"; break; 
                            case 2: echo "Your account is suspended."; break;
                        }
                        ?>
                    </p>
                </form>
            </div>
        </div>
    </div>    
</div>

<?php 
// include page footer
include 'includes/footer.php'; 
?>