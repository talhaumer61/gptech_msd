<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$sqllmspro  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid     
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.pay_type = '1' AND b.id = '".cleanvars($_GET['id'])."' LIMIT 1");
//----------------------------------------
	$rowstdpro = mysqli_fetch_array($sqllmspro);
	$orderdate = new DateTime($rowstdpro['dated']); 
if($rowstdpro['cheque_date'] != '0000-00-00') { 
	$chequedate = new DateTime($rowstdpro['cheque_date']); 
	$datecheque = $chequedate->format('d/m/Y'); 
} else {
	$datecheque = ''; 
}
//------------------------------------------------
if($rowstdpro['id_bank']) {
//------------------------------------------------
$sqllmsbank	= $dblms->querylms("SELECT bank_name FROM ".BANKS."
											 WHERE bank_id = '".$rowstdpro['id_bank']."' LIMIT 1");
$rowbank 	= mysqli_fetch_array($sqllmsbank);
$bankname	= ' ('.$rowbank['bank_name'].') ';
//------------------------------------------------
} else { 
	$bankname	= '';
}
//------------------------------------------------

$sqllmsadded	= $dblms->querylms("SELECT adm_fullname FROM ".ADMINS."
											 WHERE adm_id = '".$rowstdpro['id_added']."' LIMIT 1");
$rowadded = mysqli_fetch_array($sqllmsadded);
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Receipt Detail</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.png">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element, #tawkchat-minified-container { border:0 !important; }
</style>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp">
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12">
<div style="float:right;">
	<a class="btn btn-xxs btn-info" href="receiptprint.php?id='.$rowstdpro['id'].'" target="_blank"><i class="icon-print"></i></a>
</div>
<div style="clear:both;"></div>
<div>
	<strong>Slip #:</strong> <span class="label label-info">'.$rowstdpro['slipno'].'</span>
	<span style="float:right;"><strong>Dated:</strong> '.$orderdate->format('d/m/Y').'</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;">
	<strong>Customer Name:</strong> <span style="width:80%; border-bottom:1px solid #666; display:inline-block;margin-left:10px;"> '.$rowstdpro['customer_name'].'</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;">
	<strong>Rupess:</strong> <span style="width:200px; display:inline-block; border-bottom:1px solid #666;margin-left:10px;"> '.number_format($rowstdpro['amount']).'/</span>
	<strong>In words</strong> <span style="width:45%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;"> ( '.convert_number_to_words($rowstdpro['amount']).') </span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px;">
	<strong>in Cash / Bank Name Cheque No :</strong> <span style="width:45%; display:inline-block; border-bottom:1px solid #666;margin-left:5px;"> '.get_paytypes($rowstdpro['method']).' '.$bankname.$rowstdpro['cheque'].'</span>
	<strong>Cash Date</strong> <span style="width:12%; display:inline-block; border-bottom:1px solid #666;margin-left:5px;"> '.$datecheque.'</span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px;">
	Remarks : <span style="border-bottom:1px solid #666;margin-left:10px;"> '.$rowstdpro['remarks'].'</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;">
	Received By : <span style="border-bottom:1px solid #666;margin-left:10px;"> '.$rowadded['adm_fullname'].'</span>
</div>

<div style="clear:both;"></div>


</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>