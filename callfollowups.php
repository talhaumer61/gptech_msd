<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	require_once('functions/callfollowups.php');
	include "functions/db_functions.php";
	include "functions/pagination.php";
	$mainclass	= new main();
	$Pagination	= new Pagination();
	checkCpanelLMSALogin();
	include_once("include/header.php");
	include_once("include/".get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/callfollowups.php");
?>