<?php 
error_reporting(0);
session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
if($_POST['std_formno']) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT std_formno 
											  FROM ".STUDENTS." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND std_formno 	= '".cleanvars($_POST['std_formno'])."' LIMIT 1");
//--------------------------------------------
	$countlogin = mysqli_num_rows($sqllmsselect);
    if($countlogin == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

?>