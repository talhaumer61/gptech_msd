<?php 


echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="CustomLedgerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customercustomledgerprint.php" method="post" id="Customform" enctype="multipart/form-data" target="_blank">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Custom Ledger Report</h4>
</div>

<div class="modal-body">

	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Customer Name</b></label>
		<div class="col-lg-12">
		
			<select id="custom_customer" name="id_customer" style="width:100%" autocomplete="off" required onchange="get_1stinvoicedate(this.value)" >
				<option value="">Select Customer</option>';
				foreach($Customers as $listvends) {  
					echo '<option value="'.$listvends['customer_id'].'">'.$listvends['customer_name'].' - '.$listvends['customer_cellno'].'</option>';
				}
	echo'
			</select>

		</div>
	</div>
	
	<div id="get1stinvoicedate">
		<div class="form-group" style="margin-bottom:10px;">
			<label class="control-label req col-lg-12" style="width:150px;"> <b>From Date</b></label>
			<div class="col-lg-12">
				<input type="text" class="form-control pickadate" id="fromdate" name="fromdate" autocomplete="off" required>
			</div>
		</div>
	</div>
	
		
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>To Date</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="todate" name="todate" value="'.date("Y-m-d").'" autocomplete="off" required>
		</div>
	</div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Balance" id="submit_payment" name="submit_payment">
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
	$("#Customform").validate({
		rules: {
             id_vendor			: "required",
			 balance_opening	: "required"
		},
		messages: {
			id_vendor		: "This field is required",
			balance_opening	: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
