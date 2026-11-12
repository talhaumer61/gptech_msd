<?php 
//--------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="customerLedgerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customercustomledgerprint.php" method="post" target="_blank" id="FormCustomerLedger" name="FormCustomerLedger" enctype="multipart/form-data">

<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;">Custom Ledger Report</h4>
</div>

<div class="modal-body"> 
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Date From</label>
			<input type="text" class="form-control pickadate" id="fromdate" value="'.date("Y-m-d").'" name="fromdate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Date To</label>
			<input type="text" class="form-control pickadate" id="todate" value="'.date("Y-m-d").'" name="todate" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;margin:10px;"></div>
	
	<div class="form-group" style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Customer</b></label>
		<div class="col-lg-12">
			<select id="clidcustomer" name="id_customer" style="width:100%"  required autocomplete="off">
					<option value=""></option>';
				foreach($Customers as $listcustomer) { 
					echo '<option value="'.$listcustomer['customer_id'].'">'.$listcustomer['customer_code'].' - '.$listcustomer['customer_name'].'</option>';
				}
		echo'
				</select>
		</div>
	</div>
	
	
<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Generate Report" id="submit_orders" name="submit_orders">
	</button>
</div>

</div>
</form>

</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
    $("#clidcustomer").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#FormCustomerLedger").validate({
		rules: {
             itemcat	: "required"	,
			 datefrom	: "required"	,
			 dateto		: "required"
		},
		messages: {
			itemcat		: "This field is required"	,
			datefrom	: "This field is required"	,
			dateto		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
