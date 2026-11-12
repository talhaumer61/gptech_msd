<?php 
error_reporting(0);
session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
if($_POST['formno']) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT formno 
											  FROM ".ADMISSION_INQUIRY." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND formno 	= '".cleanvars($_POST['formno'])."' LIMIT 1");
//--------------------------------------------
	$countlogin = mysqli_num_rows($sqllmsselect);
    if($countlogin == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

if($_POST['formno_edit']) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT formno 
											  FROM ".ADMISSION_INQUIRY." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND formno 		= '".cleanvars($_POST['formno_edit'])."' LIMIT 1");
//--------------------------------------------
	$countlogin = mysqli_num_rows($sqllmsselect);
    if($countlogin == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}
?>