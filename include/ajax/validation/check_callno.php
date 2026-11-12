<?php 
// error_reporting(0);
// session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
if(isset($_POST['call_no'])) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT call_no 
											  FROM ".LRC_BOOKS." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND call_no 	= '".cleanvars($_POST['call_no'])."' LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

if(isset($_POST['call_no_edit'])) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT call_no 
											  FROM ".LRC_BOOKS." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND call_no 		= '".cleanvars($_POST['call_no_edit'])."' LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}
?>