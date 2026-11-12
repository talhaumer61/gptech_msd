<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
								'select' 		=> 'd.*, c.crs_name',
                                'join' 		=> "LEFT JOIN ".CRS." c ON c.crs_id =  d.id_crs",
								'where' 		=> array( 
														'd.pr_id' => cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(DONATIONGIFTS." d", $conditions);

	$orderdate = new DateTime($rowstdpro['dated']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Dontion / Gift Detail</title>
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
	<td><strong>DG #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['pr_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="donationgiftsprint.php?id='.$rowstdpro['pr_id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>
<tr>	
	<td  width="20%"><strong>Dated:</strong></td>
	<td colspan="3">'.$orderdate->format('d/m/Y').'</td>
</tr>
<tr>
	<td><strong>Customer Name:</strong></td>
	<td colspan="3">'.$rowstdpro['customer_name'].' '.$rowstdpro['customer_cell'].'</td>
</tr>
<tr>
	<td><strong>Address:</strong></td>
	<td colspan="3">'.$rowstdpro['customer_address'].'</td>
</tr>
<tr>
	<td><strong>CRS:</strong></td>
	<td colspan="3">'.$rowstdpro['crs_name'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>';


if($rowstdpro['dispatch_status'] == 1) {
	
	if($rowstdpro['dispatch_slip']) {
		$dispatchslip =  '<a class="btn btn-xs btn-info" href="downloads/dispatchslips/'.$rowstdpro['dispatch_slip'].'" target="_blank"> View Slip </a>';
	} else {
		$dispatchslip =  '';
	}
	
echo '<h4 style="font-weight:600;color:#00f;margin:0px;padding:0px;">Dispatch Detail</h4>
<table class="table table-bordered table-hover">
<tbody>

<tr>
	<td style="vertical-align: middle;"><strong>Dispatch #:</strong></td>
	<td colspan="3" style="vertical-align: middle;">'.$rowstdpro['dispatchno'].'
		<span style="float:right;">'.$dispatchslip.'</span>
	</td> 
</tr>
<tr>
	<td><strong>Contact #:</strong></td>
	<td>'.$rowstdpro['dispatchcellno'].'</td>
	<td  width="20%"><strong>Dispatch Date:</strong></td>
	<td>'.$rowstdpro['dispatchdate'].'</td>
</tr>
<tr>
	<td><strong>Bilty #:</strong></td>
	<td>'.$rowstdpro['biltyno'].'</td>
	<td><strong>Dispatch To:</strong></td>
	<td>'.$rowstdpro['dispatchto'].'</td>
</tr>

<tr>
	<td><strong>Dispatch Address:</strong></td>
	<td colspan="3">'.$rowstdpro['dispatchaddress'].'</td>
</tr>
</tbody>
</table>';
}
	
echo '

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Item Code</th>
	<th style="text-align:left; font-weight:bold;">Item Name</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Unit Price</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.DONATIONGIFTS_DETAILS.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".DONATIONGIFTS_DETAILS.".id_item",
								'where' => array( 
													''.DONATIONGIFTS_DETAILS.'.id_pr' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.DONATIONGIFTS_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(DONATIONGIFTS_DETAILS, $Odconditions);

	foreach($Orderdetail as $rowbills) { 
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:center; width:80px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:70px;">
		'.number_format($rowbills['total_qty']).'
	</td>
	<td style="text-align:right; width:80px;">
		'.number_format($rowbills['unit_price']).'
	</td>
	<td style="text-align:right; width:100px;">
		'.number_format($rowbills['total_price']).'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Total: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total']).'</th>
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