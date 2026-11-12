<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	
	$Custconditions = array ( 
								'select' 	=> 'c.company_id, c.company_status, c.company_name, c.id_ade, c.company_address, c.company_code,
												ad.ade_name, ad.ade_whatsapp, ad.ade_email',
								'join' 		=> "INNER JOIN ".ADES." ad ON ad.ade_id =  c.id_ade",
								'where' 	=> array( 
													'c.company_id' => cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(COMPANY.' c', $Custconditions, $sql);
	
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Customer Ledger Detail</title>
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
<table class="table table-bordered table-hover">
<tbody>
<tr>
	<td width="150"><strong>ADE Name:</strong></td>
	<td colspan="3"> '.$rowstdpro['ade_name'].'</td>
</tr>
<tr>
	<td><strong>What\'s App #:</strong></td>
	<td>'.$rowstdpro['ade_whatsapp'].'</td>
	<td><strong>Email Address:</strong></td>
	<td>'.$rowstdpro['ade_email'].'</td>
</tr>
<tr>
	<td><strong>Address:</strong></td>
	<td colspan="3">'.$rowstdpro['company_address'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Date</th>
	<th style="text-align:left; font-weight:bold; ">Detail</th>
	<th style="text-align:center; font-weight:bold;">Amount</th>
	<th style="text-align:center; font-weight:bold;">What\'s App</th>
	<th style="text-align:center; font-weight:bold;">Status</th>
</tr>
</thead>
<tbody>';

	$waconditions = array ( 
								'select' 	=> '*',
								'not_equal' 	=> array( 
													'status' 	=> '0'
												), 
								'where' 	=> array( 
													'id_company' 	=> cleanvars($_GET['id']),
													'message_type' 	=> '1'
												), 
								'order_by' 		=> ' dated DESC',
								'return_type' 	=> 'all' 
							); 
    $messages 		= $dblms->getRows(WHATSAPP_MESSAGES, $waconditions, $sql);

	$srno = 0;

	foreach($messages as $rowbills) {
		$srno++;
		echo '
		<tr>
			<td style="text-align:center; width:50px;">'.$srno.'</td>
			<td style="text-align:left; width:100px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
			<td style="text-align:left;">'.html_entity_decode($rowbills['message']).'</td>
			<td style="text-align:right; width:120px;">'.number_format($rowbills['amount']).'</td>
			<td style="text-align:right; width:120px;">'.$rowbills['cellno'].'</td>
			<td style="text-align:center; width:120px;">'.get_wa_messagestatus($rowbills['status']).'</td>
		</tr>';
	}

echo '
</tbody>
</table>
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