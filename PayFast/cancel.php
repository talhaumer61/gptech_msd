<?php 
//---------------------------------------
	include "../dbsetting/lms_vars_config.php";
	include "../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../functions/functions.php";
	include "../functions/login_func.php"; 
	include_once '../PHPMailer/PHPMailerAutoload.php';
//---------------------------------------
	$refchars = substr($_GET['refno'],0,3);
	if($refchars == 'CUS') {
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>'.$_GET['err_msg'].'</div>';
		header("Location: ".SITE_URL."/customerledger.php", true, 301);
		exit();
	} elseif($refchars == 'EST') { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>'.$_GET['err_msg'].'</div>';
		header("Location: ".SITE_URL."/customerestimates.php?view=convertjoborder&id=".$_GET['id']."", true, 301);
		exit();
	}
//---------------------------------------
?>