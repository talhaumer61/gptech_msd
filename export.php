<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
//date_default_timezone_set('Europe/London');
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if($_POST['type'] == 'items') {
//----------------------------------------
	include("include/exports/items/items.php");
//----------------------------------------
}
//----------------------------------------
if($_POST['type'] == 'customers') {
	include("include/exports/customers.php");
//----------------------------------------
}

//----------------------------------------
if($_POST['type'] == 'customerslogin') {
	include("include/exports/customerslogin.php");
//----------------------------------------
}
//----------------------------------------
if($_POST['type'] == 'vendors') {
	include("include/exports/vendors.php");
//----------------------------------------
}

//----------------------------------------
?>