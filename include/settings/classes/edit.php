<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '14', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Class Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Class Code</label>
			<input type="text" class="form-control" id="cls_code_edit" name="cls_code_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Class Name</label>
			<input type="text" class="form-control" id="cls_name_edit" name="cls_name_edit" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>


	
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Details</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="cls_detail_edit" name="cls_detail_edit" autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Company</label>
			<select id="id_company_edit" name="id_company_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($Company as $itemcompany) {
				echo '<option value="'.$itemcompany['company_id'].'">'.$itemcompany['company_code'].'-'.$itemcompany['company_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="cls_status_edit" name="cls_status_edit" style="width:100%" autocomplete="off" required>
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
	<input type="hidden" id="cls_id_edit" name="cls_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#cls_status_edit").select2({
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
		var cls_status_edit 			= $(this).attr("data-com-status");
		var cls_code_edit 				= $(this).attr("data-com-code");
        var cls_name_edit 				= $(this).attr("data-com-name");
		var cls_detail_edit 			= $(this).attr("data-com-detail");
		var id_company_edit 			= $(this).attr("data-com-company");
		var cls_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#cls_code_edit")				.val(cls_code_edit);
		$("#cls_name_edit")				.val(cls_name_edit);
		$("#cls_detail_edit")			.val(cls_detail_edit);
		$("#cls_id_edit")				.val(cls_id_edit);

       //pre-select data in pull down lists
       $("#cls_status_edit")			.select2().select2("val", cls_status_edit); 
       $("#id_company_edit")			.select2().select2("val", id_company_edit); 
  });
    
});
</script>';
} else {
	echo '<h1 style="margin-top: 200px; color: #f00; font-weight: 600; text-align: center;">Sorry, you have no right to access this page</h1>';
	
}