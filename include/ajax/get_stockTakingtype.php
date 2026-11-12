<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['idtype'])) {
//--------------------------------------------	
	if($_POST['idtype'] == 1) {
		include_once("get_AllItems.php");
	} else if($_POST['idtype'] == 2) {
		include_once("get_PartialItems.php");
	}
}
//--------------------------------------------