<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
								'select' 		=> '*',
								
								'where' 		=> array( 
														    'id' => cleanvars($_GET['id'])
                                                          , 'jv_type' => 1
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(JOURANALVOUCHERS, $conditions);

	$orderdate = new DateTime($rowstdpro['dated']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Journal Voucher Detail</title>
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
	<td><strong>JV #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['jv_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="journalvoucherssprint.php?id='.$rowstdpro['id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>
<tr>	
	<td  width="15%"><strong>Dated:</strong></td>
	<td colspan="3">'.$orderdate->format('d/m/Y').'</td>
</tr>

<tr>
	<td><strong>Detail:</strong></td>
	<td colspan="3">'.$rowstdpro['jv_details'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Customer Name</th>
	<th style="text-align:center; font-weight:bold;">Credit</th>
	<th style="text-align:center; font-weight:bold;">Debit</th>
	<th style="text-align:center; font-weight:bold;">Remarks</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.JOURANALVOUCHERS_DETAIL.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOURANALVOUCHERS_DETAIL.".id_customer",
								'where' => array( 
													''.JOURANALVOUCHERS_DETAIL.'.id_jv' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.JOURANALVOUCHERS_DETAIL.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(JOURANALVOUCHERS_DETAIL, $Odconditions);

	foreach($Orderdetail as $rowbills) { 
//------------------------------------------------
$srno++;
		if(($rowbills['credit_debit'] == 1)) {
				$amountcredit = $rowbills['amount'];
			} else {
				$amountcredit = 0;	
			}if(($rowbills['credit_debit'] == 2)) {
				$amountdebit = $rowbills['amount'];
			} else {
				$amountdebit = 0;
			}	
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:left;">'.$rowbills['customer_code'].' - '.$rowbills['customer_name'].'</td>
	<td style="text-align:right; width:80px;">
		'.number_format($amountcredit).'
	</td>
	<td style="text-align:right; width:100px;">
		'.number_format($amountdebit).'
	</td>
	<td style="text-align:left;">'.$rowbills['detail'].'</td>
</tr>';
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="2" style="text-align:right; font-weight:bold;">Total: </th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['totalcredits']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['totaldebits']).'</th>
	<th style="text-align:right; font-weight:bold;"></th>
</tr>
      

</thead>
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