<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Company Wise Sale Items Detail</title>

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
	window.open("reportitems.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';

	$Addedconditions = array ( 
								  'select' 		=> 'adm_fullname'
								, 'where' 		=> array( 
														'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													) 
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
    $rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);

	if(!empty($idcompany) && !in_array('all', $idcompany)) { 
		$companies = " AND ".CUSTOMERS.".id_company  IN (".implode(',', $idcompany).")";

		$companyconditions = array ( 
										'select' 		=> 'GROUP_CONCAT(company_name) as company_name',
										'where' 		=> array( 
																'company_status' => '1'
															), 
										'search_by' 	=> " AND company_id IN (".implode(',', $idcompany).")",
										'order_by' 		=> 'company_name ASC',
										'return_type' 	=> 'single' 
									); 
		$Company = $dblms->getRows(COMPANY, $companyconditions);
		$Companyname 	= $Company['company_name'].' SALE';

	}else{
		$companies = "";
		$Companyname 	= 'ALL COMPANIES SALE';
	}

	if(!empty($idbrand) && !in_array('all', $idbrand)) { 
		$brands = " AND ".CUSTOMERS.".id_brand  IN (".implode(',', $idbrand).")";
	}

	if(!empty($idcustomer) && $idcustomer != 'all') { 

		$customer = " AND ".CUSTOMERS.".customer_id = ".cleanvars($idcustomer);

		$conditions = array ( 
								'select'       => CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_code',
								'where'        => array ( 
													CUSTOMERS.'.customer_id' => cleanvars($idcustomer)
												),
								'return_type'  => 'single' 
							); 
        $Customer = $dblms->getRows(CUSTOMERS, $conditions);
		$Customername 	= $Customer['customer_code'].' - '.$Customer['customer_name'].' SALE';
	}else{
		$customer 		= "";
		$Customername 	= 'ALL CUSTOMERS SALE';
	}




echo '<div style="width:800px !important; min-height:700px !important; " class="page">
<table width="800" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Item Sales Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		'.$Companyname.' (FROM: '.date("F j, Y", strtotime($datefrom)).' TO: '.date("F j, Y", strtotime($dateto)).')
	</td>
</tr>
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		'.$Customername.'
	</td>
</tr>

</table>



<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2"> 
<table class="datatable" style="margin:3px 0; width:100%;">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;" rowspan="2">Sr #</th>
	<th style="text-align:left; font-weight:bold; " rowspan="2">Item Name</th>
	<th style="text-align:center; font-weight:bold;" colspan="2">Sales</th>
	<th style="text-align:center; font-weight:bold;" colspan="2">Returns</th>
	<th style="text-align:center; font-weight:bold;" colspan="2">Net Sales</th>
</tr>

<tr>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold; ">Amount</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold; ">Amount</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold; ">Amount</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno 					= 0;
$grandtotalSales 		= 0;
$grandtotalSalesQTY 	= 0;
$grandtotalRetrun 		= 0;
$grandtotalRetrunQTY 	= 0;
	
if(in_array("all",$iditem)) {			
		///totla sales
		$salesconditions = array ( 
								'select' 	=> "SUM(".SALES_INVOICE_DETAILS.".total) as totalSales, 
												SUM(".SALES_INVOICE_DETAILS.".qty) as totalSalesQTY, 
												".ITEMS.".item_id, ".ITEMS.".item_code, ".ITEMS.".item_name",
								'join' 		=> "INNER JOIN ".SALES_INVOICE." ON ".SALES_INVOICE.".salesinvoice_id =  ".SALES_INVOICE_DETAILS.".id_salesinvoice 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".SALES_INVOICE_DETAILS.".id_item 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'not_equal' 	=> array( 
													''.ITEMS.'.item_id' => 0 
												),  
								'search_by' 	=> " $companies AND ".SALES_INVOICE.".salesinvoice_status IN(3,5) AND ".SALES_INVOICE.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ".$brands . $customer ."",
								'group_by' 		=> ''.SALES_INVOICE_DETAILS.'.id_item',
								'having' 		=> ' totalSales>0',
								'order_by' 		=> ' totalSales '.$orderby.'',
								'return_type' 	=> 'all'
							); 
		$Items 	= $dblms->getRows(SALES_INVOICE_DETAILS, $salesconditions);
	foreach($Items as $rowsales) { 
		if(isset($rowsales['totalSales'])) {
			$totalSales = $rowsales['totalSales'];
		} else {
			$totalSales = 0;
		}
			
		if(isset($rowsales['totalSalesQTY'])) {
			$totalSalesQTY = $rowsales['totalSalesQTY'];
		} else {
			$totalSalesQTY = 0;
		}
	
		/// sale return
			
		$returnsconditions = array ( 
								'select' 	=> "SUM((".SALES_RETURNS_DETAILS.".total_price - round((".SALES_RETURNS_DETAILS.".total_price * ".SALES_RETURNS_DETAILS.".deduction)/100))) as totalReturn, SUM(".SALES_RETURNS_DETAILS.".total_qty) as totalReturnQTY",
								'join' 		=> "INNER JOIN ".SALES_RETURNS." ON ".SALES_RETURNS.".job_order_id =  ".SALES_RETURNS_DETAILS.".id_job_order 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".SALES_RETURNS_DETAILS.".id_item 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_RETURNS.".id_customer",
								'where' 	=> array( 
													''.ITEMS.'.item_id' => cleanvars($rowsales['item_id']) ,
													''.SALES_RETURNS.'.job_order_status' => 3 
												),  
								'search_by' 	=> " $companies AND ".SALES_RETURNS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ".$brands . $customer ."",
								'return_type' 	=> 'single'
							); 
		$rowreturn 	= $dblms->getRows(SALES_RETURNS_DETAILS, $returnsconditions);
		
		if(isset($rowreturn['totalReturn'])) {
			$totalReturn = $rowreturn['totalReturn'];
		} else {
			$totalReturn = 0;
		}
			
		if(isset($rowreturn['totalReturnQTY'])) {
			$totalReturnQTY = $rowreturn['totalReturnQTY'];
		} else {
			$totalReturnQTY = 0;
		}
		
	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:40px;">'.$srno.'</td>
		<td><a href="reportitems.php?reptype=companywisesales&repview=detail&iditem='.$rowsales['item_id'].'&orderby='.$orderby.'&idcompany='.$idcompany.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail of '.$rowsales['item_code'].' - '.$rowsales['item_name'].'" target="_blank">'.$rowsales['item_code'].' - '.$rowsales['item_name'].'</a></td>
		<td style="text-align:right; width:60px;">'.number_format($totalSalesQTY).'</td>
		<td style="text-align:right; width:80px;">'.number_format($totalSales).'</td>
		<td style="text-align:right; width:55px;">'.number_format($totalReturnQTY).'</td>
		<td style="text-align:right; width:70px;">'.number_format($totalReturn).'</td>
		<td style="text-align:right; width:60px;">'.number_format($totalSalesQTY - $totalReturnQTY).'</td>
		<td style="text-align:right; width:80px;">'.number_format($totalSales - $totalReturn).'</td>
	</tr>';
		$grandtotalSalesQTY 	= ($grandtotalSalesQTY + $totalSalesQTY);
		$grandtotalSales 		= ($grandtotalSales + $totalSales);
		$grandtotalRetrun 		= ($grandtotalRetrun + $totalReturn);
		$grandtotalRetrunQTY 	= ($grandtotalRetrunQTY + $totalReturnQTY);
	//------------------------------------------------
	} // end category loop
		
} else {
	$explodeItems = $iditem;
	//echo count($explodeItems);

	foreach($explodeItems as $listiditem) { 
			///totla sales
		$salesconditions = array ( 
								'select' 	=> "SUM(".SALES_INVOICE_DETAILS.".total) as totalSales, 
												SUM(".SALES_INVOICE_DETAILS.".qty) as totalSalesQTY, 
												".ITEMS.".item_id, ".ITEMS.".item_code, ".ITEMS.".item_name",
								'join' 		=> "INNER JOIN ".SALES_INVOICE." ON ".SALES_INVOICE.".salesinvoice_id =  ".SALES_INVOICE_DETAILS.".id_salesinvoice 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".SALES_INVOICE_DETAILS.".id_item 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' 	=> array( 
													''.ITEMS.'.item_id' => cleanvars($listiditem) 
												), 
								'search_by' 	=> " $companies AND ".SALES_INVOICE.".salesinvoice_status IN(3,5) AND ".SALES_INVOICE.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ".$brands . $customer ."",
								'return_type' 	=> 'single'
							); 
		$rowsales 	= $dblms->getRows(SALES_INVOICE_DETAILS, $salesconditions);
 
		if(isset($rowsales['totalSales'])) {
			$totalSales = $rowsales['totalSales'];
		} else {
			$totalSales = 0;
		}
			
		if(isset($rowsales['totalSalesQTY'])) {
			$totalSalesQTY = $rowsales['totalSalesQTY'];
		} else {
			$totalSalesQTY = 0;
		}
	
		/// sale return
			
		$returnsconditions = array ( 
								'select' 	=> "SUM((".SALES_RETURNS_DETAILS.".total_price - round((".SALES_RETURNS_DETAILS.".total_price * ".SALES_RETURNS_DETAILS.".deduction)/100))) as totalReturn, SUM(".SALES_RETURNS_DETAILS.".total_qty) as totalReturnQTY",
								'join' 		=> "INNER JOIN ".SALES_RETURNS." ON ".SALES_RETURNS.".job_order_id =  ".SALES_RETURNS_DETAILS.".id_job_order 
												INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".SALES_RETURNS_DETAILS.".id_item 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_RETURNS.".id_customer",
								'where' 	=> array( 
													''.ITEMS.'.item_id' => cleanvars($listiditem) ,
													''.SALES_RETURNS.'.job_order_status' => 3 
												),  
								'search_by' 	=> " $companies AND ".SALES_RETURNS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ".$brands . $customer ."",
								'return_type' 	=> 'single'
							); 
		$rowreturn 	= $dblms->getRows(SALES_RETURNS_DETAILS, $returnsconditions);
		
		if(isset($rowreturn['totalReturn'])) {
			$totalReturn = $rowreturn['totalReturn'];
		} else {
			$totalReturn = 0;
		}
			
		if(isset($rowreturn['totalReturnQTY'])) {
			$totalReturnQTY = $rowreturn['totalReturnQTY'];
		} else {
			$totalReturnQTY = 0;
		}
		
	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:40px;">'.$srno.'</td>
		<td><a href="reportitems.php?reptype=companywisesales&repview=detail&iditem='.$rowsales['item_id'].'&orderby='.$orderby.'&idcompany='.$idcompany.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail of '.$rowsales['item_code'].' - '.$rowsales['item_name'].'" target="_blank">'.$rowsales['item_code'].' - '.$rowsales['item_name'].'</a></td>
		<td style="text-align:right; width:60px;">'.number_format($totalSalesQTY).'</td>
		<td style="text-align:right; width:80px;">'.number_format($totalSales).'</td>
		<td style="text-align:right; width:55px;">'.number_format($totalReturnQTY).'</td>
		<td style="text-align:right; width:70px;">'.number_format($totalReturn).'</td>
		<td style="text-align:right; width:60px;">'.number_format($totalSalesQTY - $totalReturnQTY).'</td>
		<td style="text-align:right; width:80px;">'.number_format($totalSales - $totalReturn).'</td>
	</tr>';
		$grandtotalSalesQTY 	= ($grandtotalSalesQTY + $totalSalesQTY);
		$grandtotalSales 		= ($grandtotalSales + $totalSales);
		$grandtotalRetrun 		= ($grandtotalRetrun + $totalReturn);
		$grandtotalRetrunQTY 	= ($grandtotalRetrunQTY + $totalReturnQTY);
	//------------------------------------------------
	} // end category loop
	
}
//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Grand Total</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSalesQTY).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalRetrunQTY).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalRetrun).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSalesQTY - $grandtotalRetrunQTY).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales - $grandtotalRetrun).'</th>
	</tr>
</thead>
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
</div> 
</center>
</body>
</html>';