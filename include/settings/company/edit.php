<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'edit' => '1'))) { 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Zone Detail</h4>
</div>

<div class="modal-body">


	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Code</label>
			<input type="text" class="form-control" id="company_code_edit" name="company_code_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Name</label>
			<input type="text" class="form-control" id="company_name_edit" name="company_name_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">ADE</label>
			<select id="id_ade_edit" name="id_ade_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($Ades as $itemade) {
					echo '<option value="'.$itemade['ade_id'].'">'.$itemade['ade_name'].'('.$itemade['ade_cellno'].')</option>';
				}
				echo '
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="company_status_edit" name="company_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
				foreach($admstatus as $itemadm_status) {
					echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="company_address_edit" name="company_address_edit" autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="company_id_edit" name="company_id" value="">
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
	$("#company_status_edit").select2({
        allowClear: true
    });

	$("#id_ade_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             company_name_edit		: "required",
			 company_status_edit	: "required"
		},
		messages: {
			company_name_edit		: "This field is required",
			company_status_edit		: "This field is required"
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
		var company_status_edit 		= $(this).attr("data-com-status");
        var company_code_edit 			= $(this).attr("data-com-code");
        var company_name_edit 			= $(this).attr("data-com-name");
        var id_ade_edit 				= $(this).attr("data-com-ade");
		var company_address_edit 		= $(this).attr("data-com-address");
		var company_id_edit 			= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#company_name_edit")				.val(company_name_edit);
		$("#company_code_edit")				.val(company_code_edit);
		$("#company_address_edit")			.val(company_address_edit);
		$("#company_id_edit")				.val(company_id_edit);

       //pre-select data in pull down lists
       $("#company_status_edit")		.select2().select2("val", company_status_edit); 
       $("#id_ade_edit")				.select2().select2("val", id_ade_edit); 
  });
    
});
</script>';
}