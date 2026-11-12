<?php

	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	include "functions/db_functions.php";
	$mainclass	= new main();
	checkCpanelLMSALogin();

	$reptype		= (isset($_REQUEST['reptype']) && $_REQUEST['reptype'] != '') ? $_REQUEST['reptype'] : '';
	$repview		= (isset($_REQUEST['repview']) && $_REQUEST['repview'] != '') ? $_REQUEST['repview'] : '';
	$idcustomer		= (isset($_REQUEST['idcustomer']) && $_REQUEST['idcustomer'] != '') ? $_REQUEST['idcustomer'] : '';
	$iddept			= (isset($_REQUEST['iddept']) && $_REQUEST['iddept'] != '') ? $_REQUEST['iddept'] : '';
	$idzone			= (isset($_REQUEST['idzone']) && $_REQUEST['idzone'] != '') ? $_REQUEST['idzone'] : '';
	$idbrand		= (isset($_REQUEST['idbrand']) && $_REQUEST['idbrand'] != '') ? $_REQUEST['idbrand'] : '';
	$idcompany		= (isset($_REQUEST['idcompany']) && $_REQUEST['idcompany'] != '') ? $_REQUEST['idcompany'] : '';
	$datefrom		= (isset($_REQUEST['datefrom']) && $_REQUEST['datefrom'] != '') ? $_REQUEST['datefrom'] : '';
	$dateto			= (isset($_REQUEST['dateto']) && $_REQUEST['dateto'] != '') ? $_REQUEST['dateto'] : '';
	$monthfrom		= (isset($_REQUEST['monthfrom']) && $_REQUEST['monthfrom'] != '') ? $_REQUEST['monthfrom'] : '';
	$monthto		= (isset($_REQUEST['monthto']) && $_REQUEST['monthto'] != '') ? $_REQUEST['monthto'] : '';
	$idcat			= (isset($_REQUEST['idcat']) && $_REQUEST['idcat'] != '') ? $_REQUEST['idcat'] : '';
//----------------------------------------
if($_POST['reptype'] == 'zonecategorywisesales') {
//----------------------------------------
	include("include/exports/items/zonecategorywisesales.php");
//----------------------------------------
}

?>