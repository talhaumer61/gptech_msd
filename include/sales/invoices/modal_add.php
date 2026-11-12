<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '3', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="invoices.php" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="view" name="view" value="add">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;"> Add Invoice Detail</h4>
</div>

<div class="modal-body">';
//------------------------------------------------
	$sqllmslstorder  = $dblms->querylms("SELECT invoice_id FROM ".INVOICES."   
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'  
										ORDER BY invoice_id DESC LIMIT 1");
	$valuelstorder 	= mysqli_fetch_assoc($sqllmslstorder);
//------------------------------------------------
echo '
		
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Invoice #</label>
			<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="'.($valuelstorder['invoice_id'] + 1).'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="invoice_dated" value="'.date("Y-m-d").'" name="invoice_dated" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer</label>
			<select id="id_customer" name="id_customer" style="width:100%"  onchange="get_joborders(this.value)" required autocomplete="off">
					<option value="">Choose Customer</option>';
					  $sqllmsloc	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
																FROM ".CUSTOMERS." 
																WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
																AND customer_status = '1' ORDER BY customer_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) { 
					echo '<option value="'.$valueloc['customer_id'].'">'.$valueloc['customer_name'].' - '.substr($valueloc['customer_cellno'],0,-3).'...</option>';
				}
		echo'
				</select>
		</div>
	</div>
	
	
	<div style="clear:both;"></div>
	<div id="getjoborders">';
//--------------------------------------------
$sqllmsorders  = $dblms->querylms("SELECT b.order_id, b.order_no, b.order_date, b.order_status, b.order_datedelivery, b.order_design, 
										b.id_customer, c.customer_name, c.customer_cellno  
										FROM ".ORDERS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'  
										AND b.order_id NOT IN (SELECT id_order FROM ".INVOICE_DETAILS." GROUP BY id_order )
										AND b.order_status = '4' ORDER BY b.order_id DESC");
//echo $id_prg.'abd ahahda dahda had a';
if (mysqli_num_rows($sqllmsorders) > 0) {
//------------------------------------------------
echo '
<br>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th> Sr #</th>
	<th> Ord.#</th>
	<th> Dated</th>
	<th> Customer</th>
	<th> Design by:</th>
	<th> Status</th>
</tr>
</thead>
<tbody>';
$srnoid = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllmsorders)) {
//------------------------------------------------
	$ctystatus = get_orders($rowstd['order_status']);
$srnoid++;
//------------------------------------------------
echo '
<tr>
	<td style="width:45px;">'.$srnoid.'</td>
	<td style="width:75px;">'.$rowstd['order_no'].'</td>
	<td style="width:90px;">'.$rowstd['order_date'].' </td>
	<td>'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)</td>
	<td style="width:100px;">'.get_designby($rowstd['order_design']).'</td>
	<td style="width:100px;"><span class="label label-warning">Not Billed</span></td>
</tr>';
//------------------------------------------------
} // end while loop

//------------------------------------------------
echo '
</tbody>
</table>';
}
//--------------------------------------------
echo '	
	</div>
	
<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Create Invoice" id="submit_orders" name="submit_orders">
	</button>
</div>

</div>
</form>
<script>
    $("#invoice_status").select2({
        allowClear: true
    });
	
	$("#order_design").select2({
        allowClear: true
    });
	
	$("#id_customer").select2({
        allowClear: true
    });
	
	$("#orderno").select2({
        allowClear: true
    });
	$("#top-list1").select2({
        allowClear: true
    });
	$("#top-list2").select2({
        allowClear: true
    });
	$("#top-list3").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}