<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	$id_customer = $_GET['id_customer']; 
//--------------------------------------------
$sqllmsorders  = $dblms->querylms("SELECT b.order_id, b.order_no, b.order_date, b.order_status, b.order_datedelivery, b.order_design, 
										b.id_customer 
										FROM ".ORDERS." b 
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.id_customer =  '".cleanvars($id_customer)."' AND b.order_status = '4' 
										AND b.order_id NOT IN (SELECT id_order FROM ".INVOICE_DETAILS." GROUP BY id_order ) 
										ORDER BY b.order_id DESC");
//echo $id_prg.'abd ahahda dahda had a';
$sqllmscheck  = $dblms->querylms("SELECT customer_name, customer_cellno  
										FROM ".CUSTOMERS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND customer_id = '".cleanvars($id_customer)."' LIMIT 1");
$valuecustomer = mysqli_fetch_array($sqllmscheck);
if (mysqli_num_rows($sqllmsorders) > 0) {
//------------------------------------------------
echo '
<br>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th></th>
	<th>Job.#</th>
	<th> Dated</th>
	<th> Customer</th>
	<th> Cell #</th>
	<th> Status</th>
</tr>
</thead>
<tbody>';
$sri = 0;
//------------------------------------------------
while($roworders = mysqli_fetch_array($sqllmsorders)) { 

//------------------------------------------------
	$sqllmsbills  = $dblms->querylms("SELECT id_invoice FROM ".INVOICE_DETAILS." 
														WHERE id_order = '".cleanvars($roworders['order_id'])."' 
														GROUP BY id_order ");
	$rowbills	= mysqli_fetch_array($sqllmsbills);
	if($rowbills['id_invoice']) { 
		$iordstatus = '<span class="label label-info">Billed</span>';
		$addlink 	= '';
	} else { 
		$iordstatus = '<span class="label label-warning">Not Billed</span>';
		$addlink 	= '<input id="orderno[]" name="orderno[]" type="checkbox" value="'.$roworders['order_id'].'" class="checkbox-inline">';
	}
//------------------------------------------------
$sri++;
echo '
<tr>
	<td style="width:40px;">'.$addlink.'</td>
	<td style="width:60px;">'.$roworders['order_no'].'</td>
	<td style="width:100px;">'.$roworders['order_date'].' </td>
	<td>'.$valuecustomer['customer_name'].'</td>
	<td>'.substr($valuecustomer['customer_cellno'],0,-3).'...</td>
	<td style="width:75px; text-align:center;">'.$iordstatus.'</td>
</tr>
';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
<input type="hidden" name="id_customer" id="id_customer" value="'.cleanvars($id_customer).'">
<input type="hidden" name="customer_name" id="customer_name" value="'.cleanvars($valuecustomer['customer_name']).'">
<input type="hidden" name="customer_cell" id="customer_cell" value="'.cleanvars($valuecustomer['customer_cellno']).'">
</tbody>
</table>';
//--------------------------------------------
}

?>
<!--JS_SELECT_LISTS-->
