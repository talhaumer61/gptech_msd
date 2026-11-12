<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//---------------------------------------- 
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '23')) { 
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
	
	include_once("include/reports/ledgers/".$reptype."_".$repview.".php");
//--------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
//--------------------------------------------------
?>