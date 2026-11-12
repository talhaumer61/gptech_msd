<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Payment Setting Detail</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-61">
		<div class="form_sep" >
			<label class="req">Balance From</label>
			<input type="text" class="form-control" id="balance_from" name="balance_from" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Balance To</label>
			<input type="text" class="form-control" id="balance_to" name="balance_to" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	<div style="clear:both; padding:10px;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Balance Percentage</label>
			<input type="text" class="form-control" id="balance_percentage" name="balance_percentage" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">New Order Percentage</label>
			<input type="text" class="form-control" id="neworder_percentage" name="neworder_percentage" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status" name="status" style="width:100%" required autocomplete="off">';
			foreach($admstatus as $itemadms_tatus) {
				echo "<option value='$itemadms_tatus[status_id]'>$itemadms_tatus[status_name]</option>";
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value=" Add Record " id="submit_country" name="submit_country">
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
             vendor_name		: "required",
			 vendor_status		: "required"
		},
		messages: {
			vendor_name		: "This field is required",
			vendor_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}