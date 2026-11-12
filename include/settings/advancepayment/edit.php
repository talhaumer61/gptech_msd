<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'edit' => '1'))) { 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Advance Payment Detail</h4>
</div>

<div class="modal-body">
	
	
	<div class="col-sm-61">
		<div class="form_sep" >
			<label class="req">Balance From</label>
			<input type="text" class="form-control" id="balance_from_edit" name="balance_from_edit" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Balance To</label>
			<input type="text" class="form-control" id="balance_to_edit" name="balance_to_edit" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	<div style="clear:both; padding:10px;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Balance Percentage</label>
			<input type="text" class="form-control" id="balance_percentage_edit" name="balance_percentage_edit" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">New Order Percentage</label>
			<input type="text" class="form-control" id="neworder_percentage_edit" name="neworder_percentage_edit" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status_edit" name="status_edit" style="width:100%" required autocomplete="off">';
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
	<input type="hidden" id="id_edit" name="edit_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             vendor_name_edit		: "required",
			 vendor_status_edit	: "required"
		},
		messages: {
			vendor_name_edit		: "This field is required",
			vendor_status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var status_edit 				= $(this).attr("data-com-status");
        var balance_from_edit 			= $(this).attr("data-com-balancefrom");
		var balance_to_edit 			= $(this).attr("data-com-balanceto");
		var balance_percentage_edit 	= $(this).attr("data-com-balancepercentage");
		var neworder_percentage_edit 	= $(this).attr("data-com-neworderpercentage");
		var id_edit 					= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#balance_from_edit")			.val(balance_from_edit);
		$("#balance_to_edit")			.val(balance_to_edit);
		$("#balance_percentage_edit")	.val(balance_percentage_edit);
		$("#neworder_percentage_edit")	.val(neworder_percentage_edit);
		$("#id_edit")					.val(id_edit);

       //pre-select data in pull down lists
       $("#status_edit")			.select2().select2("val", status_edit); 
  });
    
});
</script>';
}