<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Brand Wise Report Sale & CGS Detail</title>

<style type="text/css">
body {
	font: normal normal normal 16px/15px  "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
    overflow: -moz-scrollbars-vertical; margin:0; color:#111;
}
h1 { font-size:28px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
h2 { font-size:20px; font-weight:bold; margin-bottom:3px; color:#111; text-transform:uppercase; text-align:center; text-decoration:underline; }
h3 { font-size:18px; font-weight:bold; color:#333; text-transform:uppercase; text-align:center; }
h4 { font-size:14px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }

table td.label { font-weight:bold; margin: 0; text-align:left; padding:2px; vertical-align:middle !important; }

table.datatable { border: 1px solid #333; border-collapse: collapse; border-spacing: 0; margin-top:10px; }

table.datatable td { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:5px; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:15px; color:#000; 
}

table.datatable th { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:7px; background:#f4f4f4; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:14px; font-weight:600;  
}

@page {
  margin: 1cm; // margin for each printed piece of paper
}

@page :first {
  margin-top: 1cm; // top margin for first page of paper
}

@media print {
  body {
    margin: 0; // 
  }
}

</style>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<script language="JavaScript1.2">
function openwindow() {
	window.open("reportsalescgs.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
	$sql2 	= "";
//------------------------------------------------
		$Addedconditions = array ( 
								'select' 		=> 'adm_fullname',
								'where' 		=> array( 
														'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
		$rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);

		if(($idbrand)) { 
			if($idbrand == 'all') {
				$sql2 		.= "";
				$Brandname	 = 'All Brands';
			} else {
				$sql2 		.= " AND b.id_brand  = '".$idbrand."'";
				$Brandname	 = get_brandnames($idbrand);
			}
		}

echo '<div style="width:900px !important; min-height:700px !important; " class="page">
<table width="900" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:20px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		CGS Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:20px;padding:5px;margin-top:0px; font-weight:600;">
		Brand Wise CGS Report
	</td>
</tr>
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:20px;padding:5px;margin-top:0px; font-weight:600;">
		'.$Brandname.'
	</td>
</tr>
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		Date: '.date("d-m-Y", strtotime($datefrom)).' - '.date("d-m-Y", strtotime($dateto)).'
	</td>
</tr>

</table>



<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:100%;">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Item Name</th> 
	<th style="text-align:center; font-weight:bold;">Sales QTY</th>
	<th style="text-align:center; font-weight:bold;">Sales AMT</th>
	<th style="text-align:center; font-weight:bold;">Return QTY</th>
	<th style="text-align:center; font-weight:bold;">Return AMT</th>
	<th style="text-align:center; font-weight:bold;">AVG Rate</th>
	<th style="text-align:center; font-weight:bold;">CGS</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno 						= 0;
$grandtotalSales			= 0;
$grandtotalSalesQty			= 0;
$grandtotalReturn			= 0;
$grandtotalReturnQty		= 0;
$grandtotalCGS				= 0;

if($idbrand == 'all') { 
	
		$conditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_code, ".ITEMS.".item_name, 
												SUM(".SALES_INVOICE_DETAILS.".qty) as totalQty, 
												SUM(".SALES_INVOICE_DETAILS.".total) as totalSales",
								'join' 		=> "INNER JOIN ".SALES_INVOICE." ON ".SALES_INVOICE.".salesinvoice_id  =  ".SALES_INVOICE_DETAILS.".id_salesinvoice 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".SALES_INVOICE_DETAILS.".id_item",
								'not_equal' 	=> array( 
													''.CUSTOMERS.'.id_brand' => 0
												), 
								'search_by' 	=> " AND ".SALES_INVOICE.".salesinvoice_status IN(3,5) AND ".SALES_INVOICE.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)",
								'group_by' 		=> "".SALES_INVOICE_DETAILS.".id_item",
								'order_by' 		=> "".ITEMS.".item_name",
								'return_type' 	=> 'all'
							); 
		$Sales 	= $dblms->getRows(SALES_INVOICE_DETAILS, $conditions);

	foreach($Sales as $rowsSale) {

		if($rowsSale['totalQty']>0) {
			$srno++;
			
			/// Get Sales Return
			
			$reurnconditions = array ( 
								'select' 	=> "SUM(".SALES_RETURNS_DETAILS.".total_qty) as totalReturnQty, 
												SUM(".SALES_RETURNS_DETAILS.".total_price - round((".SALES_RETURNS_DETAILS.".deduction/100) * ".SALES_RETURNS_DETAILS.".total_price)) as TotalReturn",
								'join' 		=> "INNER JOIN ".SALES_RETURNS." ON ".SALES_RETURNS.".job_order_id =  ".SALES_RETURNS_DETAILS.".id_job_order 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_RETURNS.".id_customer",
								'where' 	=> array( 
													''.SALES_RETURNS.'.job_order_status' 	=> 3 ,
													''.SALES_RETURNS_DETAILS.'.id_item' 	=> cleanvars($rowsSale['item_id']) 
												), 
								'not_equal' 	=> array( 
															''.CUSTOMERS.'.id_brand' => 0 
														), 
								'search_by' 	=> " AND ".SALES_RETURNS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ",
								'return_type' 	=> 'single'
							); 
			$rowreturn 	= $dblms->getRows(SALES_RETURNS_DETAILS, $reurnconditions);
			
				/// Get average Purchase Price
			
			$purchaseconditions = array ( 
								'select' 	=> "ROUND(AVG(".PURCHASE_ORDER_DETAILS.".unit_price),0) AS AVgPrice",
								'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id =  ".PURCHASE_ORDER_DETAILS.".id_po",
								'where' 	=> array( 
													''.PURCHASE_ORDER.'.po_status' 			=> 1 ,
													''.PURCHASE_ORDER_DETAILS.'.id_item' 	=> cleanvars($rowsSale['item_id']) 
												), 
								'search_by' 	=> " AND ".PURCHASE_ORDER.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)",
								'return_type' 	=> 'single'
							); 
			$rowpurchase 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $purchaseconditions);
			
		//------------------------------------------------
			echo '
				<tr>
					<td style="text-align:center; width:40px;">'.$srno.'</td>
					<td>'.$rowsSale['item_code'].' - '.$rowsSale['item_name'].'</td>
					<td style="text-align:center; width:70px;">'.number_format($rowsSale['totalQty']).'</td>
					<td style="text-align:right; width:90px;">'.number_format($rowsSale['totalSales']).'</td>
					<td style="text-align:center; width:75px;">'.number_format($rowreturn['totalReturnQty']).'</td>
					<td style="text-align:right; width:90px;">'.number_format($rowreturn['TotalReturn']).'</td>
					<td style="text-align:center; width:60px;">'.$rowpurchase['AVgPrice'].'</td>
					<td style="text-align:right; width:90px;">'.number_format(($rowsSale['totalQty']-$rowreturn['totalReturnQty']) * $rowpurchase['AVgPrice']).'</td>
				</tr>';
				$grandtotalSalesQty = ($grandtotalSalesQty + $rowsSale['totalQty']);
				$grandtotalSales 	= ($grandtotalSales + $rowsSale['totalSales']);

				$grandtotalReturnQty= ($grandtotalReturnQty + $rowreturn['totalReturnQty']);
				$grandtotalReturn	= ($grandtotalReturn + $rowreturn['TotalReturn']);
				$grandtotalCGS		= ($grandtotalCGS + (($rowsSale['totalQty']-$rowreturn['totalReturnQty']) * $rowpurchase['AVgPrice']));
		}

	}
		
	//------------------------------------------------
	
} else {
	
	
		$conditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_code, ".ITEMS.".item_name, 
												SUM(".SALES_INVOICE_DETAILS.".qty) as totalQty, 
												SUM(".SALES_INVOICE_DETAILS.".total) as totalSales",
								'join' 		=> "INNER JOIN ".SALES_INVOICE." ON ".SALES_INVOICE.".salesinvoice_id  =  ".SALES_INVOICE_DETAILS.".id_salesinvoice 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".SALES_INVOICE_DETAILS.".id_item",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' => cleanvars($idbrand)
												), 
								'search_by' 	=> " AND ".SALES_INVOICE.".salesinvoice_status IN(3,5) AND ".SALES_INVOICE.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)",
								'group_by' 		=> "".SALES_INVOICE_DETAILS.".id_item",
								'order_by' 		=> "".ITEMS.".item_name",
								'return_type' 	=> 'all'
							); 
		$Sales 	= $dblms->getRows(SALES_INVOICE_DETAILS, $conditions);

	foreach($Sales as $rowsSale) {

		if($rowsSale['totalQty']>0) {
			$srno++;
			
			/// Get Sales Return
			
			$reurnconditions = array ( 
								'select' 	=> "SUM(".SALES_RETURNS_DETAILS.".total_qty) as totalReturnQty, 
												SUM(".SALES_RETURNS_DETAILS.".total_price - round((".SALES_RETURNS_DETAILS.".deduction/100) * ".SALES_RETURNS_DETAILS.".total_price)) as TotalReturn",
								'join' 		=> "INNER JOIN ".SALES_RETURNS." ON ".SALES_RETURNS.".job_order_id =  ".SALES_RETURNS_DETAILS.".id_job_order 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_RETURNS.".id_customer",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' 				=> cleanvars($idbrand) ,
													''.SALES_RETURNS.'.job_order_status' 	=> 3 ,
													''.SALES_RETURNS_DETAILS.'.id_item' 	=> cleanvars($rowsSale['item_id']) 
												), 
								'not_equal' 	=> array( 
															''.SALES_RETURNS.'.job_order_id' => 0 
														), 
								'search_by' 	=> " AND ".SALES_RETURNS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ",
								'return_type' 	=> 'single'
							); 
			$rowreturn 	= $dblms->getRows(SALES_RETURNS_DETAILS, $reurnconditions);
			
			/// Get average Purchase Price
			
			$purchaseconditions = array ( 
								'select' 	=> "ROUND(AVG(".PURCHASE_ORDER_DETAILS.".unit_price),0) AS AVgPrice",
								'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id =  ".PURCHASE_ORDER_DETAILS.".id_po",
								'where' 	=> array( 
													''.PURCHASE_ORDER.'.po_status' 			=> 1 ,
													''.PURCHASE_ORDER_DETAILS.'.id_item' 	=> cleanvars($rowsSale['item_id']) 
												), 
								'search_by' 	=> " AND ".PURCHASE_ORDER.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)",
								'return_type' 	=> 'single'
							); 
			$rowpurchase 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $purchaseconditions);
			
		//------------------------------------------------
			echo '
				<tr>
					<td style="text-align:center; width:40px;">'.$srno.'</td>
					<td>'.$rowsSale['item_code'].' - '.$rowsSale['item_name'].'</td>
					<td style="text-align:center; width:70px;">'.number_format($rowsSale['totalQty']).'</td>
					<td style="text-align:right; width:90px;">'.number_format($rowsSale['totalSales']).'</td>
					<td style="text-align:center; width:75px;">'.number_format($rowreturn['totalReturnQty']).'</td>
					<td style="text-align:right; width:90px;">'.number_format($rowreturn['TotalReturn']).'</td>
					<td style="text-align:center; width:60px;">'.$rowpurchase['AVgPrice'].'</td>
					<td style="text-align:right; width:90px;">'.number_format(($rowsSale['totalQty']-$rowreturn['totalReturnQty']) * $rowpurchase['AVgPrice']).'</td>
				</tr>';
				$grandtotalSalesQty = ($grandtotalSalesQty + $rowsSale['totalQty']);
				$grandtotalSales 	= ($grandtotalSales + $rowsSale['totalSales']);

				$grandtotalReturnQty= ($grandtotalReturnQty + $rowreturn['totalReturnQty']);
				$grandtotalReturn	= ($grandtotalReturn + $rowreturn['TotalReturn']);
				$grandtotalCGS		= ($grandtotalCGS + (($rowsSale['totalQty']-$rowreturn['totalReturnQty']) * $rowpurchase['AVgPrice']));
		}

	}

} // end single brand


//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Grand Total</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSalesQty).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalReturnQty).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalReturn).'</th>
		<th style="text-align:right;font-size:16px !important;"></th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalCGS).'</th>
	</tr>
	<tr>
		<th colspan="6" style="text-align:right;font-size:16px !important;"> Total Sales</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales).'</th>
	</tr>
	<tr>
		<th colspan="6" style="text-align:right;font-size:16px !important;"> Sale Return</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalReturn).'</th>
	</tr>
	<tr>
		<th colspan="6" style="text-align:right;font-size:16px !important;"> Net Sale</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales- $grandtotalReturn).'</th>
	</tr>
	<tr>
		<th colspan="6" style="text-align:right;font-size:16px !important;"> Cost of Good Sold (of Sold Item)</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalCGS).'</th>
	</tr>
	<tr>
		<th colspan="6" style="text-align:right;font-size:16px !important;"> Gross Profit</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales - $grandtotalCGS).'</th>
	</tr>
</thead>
</table>

</table>
	</td> 
</tr>
<tr>
  <td valign="bottom" align="left">
<table  border="0" style="margin:100px 0 0 0; width:130px;">
<tr>
	<td align="center" style="font-weight:500;">'.$rowdesigner['adm_fullname'].'</td>
</tr>
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #111;">Prepared By</td>
</tr>
</table>
	</td>
	<td valign="bottom" align="right">
<table  border="0" style="margin:20px 0 0 0; width:130px;">
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #111;">Director</td>
</tr>
</table>

	</td>
</tr>
</table>
</div>';


//----------------------------------
echo '	
</center>
</body>
<script type="text/javascript">
// setTimeout(function(){if (typeof(window.print) != "undefined") {
//     window.print();
//     window.close();
// }}, 3500);
</script>
</html>';