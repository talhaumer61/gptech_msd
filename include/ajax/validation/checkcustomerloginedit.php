<?php 

	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
	checkCpanelLMSALogin();


if(!empty($_POST['adm_username_edit'])) {
//--------------------------------------------
		$conditions 	= array ( 
								'select' 		=> 'adm_id, adm_username, adm_userpass',
								'where' 		=> array ( 
															  'adm_username'  => cleanvars(trim($_POST['adm_username_edit'])) 
															, 'adm_logintype' => 2 
															 
														), 

								'return_type' 	=> 'count' 
							); 
    	$countlogin 	= $dblms->getRows(ADMINS,  $conditions);
//--------------------------------------------

    if($countlogin == 0)  {
        echo "true";  //good to register
    } elseif($countlogin == 1)  {
        echo "true";  //good to register
    }  else {
        echo "false"; //already registered
    }
}

