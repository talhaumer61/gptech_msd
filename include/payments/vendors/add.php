<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '5', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Vendor Payments</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Vendor Name</label>
			<select id="id_paid" name="id_paid" style="width:100%" autocomplete="off" required  onchange="get_vendorbalance(this.value)">
				<option value="">Select Vendor</option>';
				foreach($Vendors as $listvendors) {  
					echo '<option value="'.$listvendors['vendor_id'].'">'.$listvendors['vendor_name'].' - '.$listvendors['customer_cellno'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
<div id="getvendorbalance">
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Payable (Balance)</label>
			<input type="text" class="form-control" id="payable" name="payable" value="" autocomplete="off" readonly>
		</div> 
	</div>
</div>		
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" value="'.date("Y-m-d").'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no" name="receipt_no" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="text" class="numbers form-control" id="amount" name="amount" required autocomplete="off" onblur="numberWithCommas(this)">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no" name="reference_no" autocomplete="off">
		</div> 
	</div>
	
<div style="clear:both;"></div>	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Method</label>
			<select id="method" name="method" style="width:100%" autocomplete="off" required>
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:10px;">
			<label>Remarks</label>
			<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Payment" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             id_paid	: "required",
			 method		: "required"
		},
		messages: {
			id_paid		: "This field is required",
			method		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}