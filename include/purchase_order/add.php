<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'add' => '1'))) { 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'purchase-order.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Purchase Order</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Purchase Order #</label>
			<input type="text" class="form-control" id="po_order_no" name="po_order_no" required value="MSD-'.mt_rand(100000,999999).'" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Purchase Order Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date('Y-m-d').'" name="dated" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Vendor</label>
			<select id="id_vendor" name="id_vendor" onchange="get_vendordetail(this.value)" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($Vendors as $rowvendor) {  
					echo '<option value="'.$rowvendor['vendor_id'].'">'.$rowvendor['vendor_name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>

	<div id="getVendorDetails">

		<div class="col-sm-41">
			<div class="form_sep">
				<label>Vendor Phone #</label>
				<input type="text" class="form-control" id="vendor_cellno" name="vendor_cellno" readonly>
			</div> 
		</div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label>Vendor Email</label>
				<input type="text" class="form-control" id="vendor_email" name="vendor_email" readonly>
			</div> 
		</div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label>Vendor Opening Balance</label>
				<input type="text" class="form-control" id="vendor_openingbalance" name="vendor_openingbalance" readonly>
			</div> 
		</div>

		<div style="clear:both; padding:5px;"></div>

	</div>

	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. #</th>
				<th style="text-align:left;">Items </th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
		for ($i=1; $i <= 100; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off" onchange="getPrdPurchaseValue(this.value, '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:150px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="qty['.$i.']" id="qty_'.$i.'"  autocomplete="off" '.$required.' >
				</td>
				
				<td style="width:150px;">
					<div id="getPrdValue_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$i.']" id="unit_price_'.$i.'"  autocomplete="off" '.$required.' >
					</div>		
					
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
				</td>
			</tr>';	
		}
echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'purchase-order.php\'">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Purchase Order" id="submit_purchase_order" name="submit_purchase_order" onClick=\'return confirmSubmit()\'>
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>
<script>
    $(".select2").select2({
        allowClear: true
    });
    
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#id_vendor").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             company_name		: "required",
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}