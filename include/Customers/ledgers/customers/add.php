<?php 

if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '7', 'add' => '1'))) {	
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customerledger.php" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Balance Details</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<select id="id_customer" name="id_customer" style="width:100%" autocomplete="off" required >
				<option value="">Select Customer</option>';
				foreach($arrayvendors as $listvends) {  
					echo '<option value="'.$listvends['customer_id'].'">'.$listvends['customer_name'].' - '.$listvends['customer_cellno'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Opening Balance</label>
			<input type="number" class="form-control" id="balance_opening" name="balance_opening" autocomplete="off" required>
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	
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
	$("#addNewCountry").validate({
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
}