<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Representatives Detail</h4>
</div>

<div class="modal-body">
		
	<div class="col-sm-100">
		<div class="form_sep">
			<label class="req">Full Name</label>
			<input type="text" class="form-control" id="crs_name_edit" name="crs_name_edit" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>


	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Mobile #</label>
			<input type="text" class="form-control" id="crs_mobile_edit" name="crs_mobile_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Whatsapp #</label>
			<input type="text" class="form-control" id="crs_whatsapp_edit" name="crs_whatsapp_edit" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="crs_email_edit" name="crs_email_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<input type="text" class="form-control" id="crs_designation_edit" name="crs_designation_edit" required autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="crs_status_edit" name="crs_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="crs_id_edit" name="crs_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#crs_status_edit").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
</script>

<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             customer_name_edit		: "required",
			 customer_status_edit	: "required"
		},
		messages: {
			customer_name_edit		: "This field is required",
			customer_status_edit		: "This field is required"
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
		var crs_status_edit 			= $(this).attr("data-com-status");
        var crs_name_edit 				= $(this).attr("data-com-name");
		var crs_cellno_edit 			= $(this).attr("data-com-cellno");
		var crs_designation_edit 		= $(this).attr("data-com-designation");
		var crs_whatsapp_edit 			= $(this).attr("data-com-whatsapp");
		var crs_email_edit 				= $(this).attr("data-com-email");
		var crs_id_edit 				= $(this).attr("data-com-id");
        //set modal input values dynamically	
		$("#crs_name_edit")				.val(crs_name_edit);
		$("#crs_mobile_edit")			.val(crs_cellno_edit);
		$("#crs_designation_edit")		.val(crs_designation_edit);
		$("#crs_whatsapp_edit")			.val(crs_whatsapp_edit);
		$("#crs_email_edit")			.val(crs_email_edit);
		$("#crs_id_edit")				.val(crs_id_edit);

       //pre-select data in pull down lists
       $("#crs_status_edit")			.select2().select2("val", crs_status_edit);  
  });
    
});
</script>';
}