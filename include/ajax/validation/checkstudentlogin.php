<?php 
error_reporting(0);
session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT adm_username
											  FROM ".ADMINS." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND adm_username 	= '".cleanvars($_POST['regno'])."' AND adm_logintype = '3' LIMIT 1");
//--------------------------------------------
	$countlogin = mysqli_num_rows($sqllmsselect);
    if($countlogin == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
?>