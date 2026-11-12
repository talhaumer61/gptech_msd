<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Holiday Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12"> <b>Holiday Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption_edit" name="caption_edit" required autofocus autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label class="req"> Start Date </label>
			<input type="text" class="form-control pickadate" id="date_start_edit" name="date_start_edit" autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label class="req"> End Date </label>
			<input type="text" class="form-control pickadate" id="date_end_edit" name="date_end_edit" required autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="id_edit" name="id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<!--JS_SELECT_LISTS-->
<script>
	$("#status_edit").select2({
        allowClear: true
    });

</script>
<!--JS_ADD_NEW_TASK_MODAL-->
<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editCountry").validate({
		rules: {
             date_start_edit		: "required",
			 status_edit			: "required"
		},
		messages: {
			date_start_edit			: "This field is required",
			status_edit				: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
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
        var date_start_edit 	= $(this).attr("data-cls-start");
		var caption_edit 			= $(this).attr("data-cls-title");
		var date_end_edit 		= $(this).attr("data-cls-end");
		var status_edit 		= $(this).attr("data-cls-status");
		var id_edit 			= $(this).attr("data-cls-id");

        //set modal input values dynamically
		$("#date_start_edit")	.val(date_start_edit);
		$("#caption_edit")		.val(caption_edit);
		$("#date_end_edit")		.val(date_end_edit);
		$("#id_edit")			.val(id_edit);

       //pre-select data in pull down lists
       $("#status_edit").select2().select2("val", status_edit); 
  });
    
});
</script>';
}