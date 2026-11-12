<?php 

	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";

if($_POST['std_email']) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT std_email 
											  FROM ".STUDENTS." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND (std_status = '2' OR std_status = '7')  
											  AND std_email 	= '".cleanvars($_POST['std_email'])."' 
											  AND std_emailverify = '1'");
//--------------------------------------------
	$countlogin = mysqli_num_rows($sqllmsselect);
    if($countlogin == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

?>