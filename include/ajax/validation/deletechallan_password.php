<?php 

	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";

		checkCpanelLMSALogin();

if($_POST['delete_password']) {
//--------------------------------------------
	$admin_pass1  = cleanvars($_POST['delete_password']);
	$admin_pass3  = md5($admin_pass1);
	
	$sqllmsselect = $dblms->querylms("SELECT adm_userpass 
											FROM ".ADMINS." 
											WHERE adm_userpass = '".$admin_pass3."'
											AND adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$countlogin   = mysqli_num_rows($sqllmsselect);
	
    if($countlogin == 1)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

?>