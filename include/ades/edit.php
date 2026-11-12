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
	<h4 class="modal-title" style="font-weight:700;"> Edit ADE Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">ADE Code</label>
			<input type="text" class="form-control" id="ade_code_edit" name="ade_code_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Ade Name</label>
			<input type="text" class="form-control" id="ade_name_edit" name="ade_name_edit" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>


	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Cell #</label>
			<input type="text" class="form-control" id="ade_cellno_edit" name="ade_cellno_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Whatsapp #</label>
			<input type="text" class="form-control" id="ade_whatsapp_edit" name="ade_whatsapp_edit" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="ade_email_edit" name="ade_email_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">CNIC</label>
			<input type="text" class="form-control" id="ade_cnic_edit" name="ade_cnic_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="ade_address_edit" name="ade_address_edit" autocomplete="off">
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
			<select id="ade_status_edit" name="ade_status_edit" style="width:100%" autocomplete="off" required>
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
	<input type="hidden" id="ade_id_edit" name="ade_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#ade_status_edit").select2({
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
		var ade_status_edit 			= $(this).attr("data-com-status");
		var ade_code_edit 				= $(this).attr("data-com-code");
        var ade_name_edit 				= $(this).attr("data-com-name");
		var ade_cellno_edit 			= $(this).attr("data-com-cellno");
		var ade_cnic_edit 				= $(this).attr("data-com-cnic");
		var ade_whatsapp_edit 			= $(this).attr("data-com-whatsapp");
		var ade_email_edit 				= $(this).attr("data-com-email");
		var ade_address_edit 			= $(this).attr("data-com-address");
		var id_company_edit 			= $(this).attr("data-com-company");
		var ade_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#ade_code_edit")				.val(ade_code_edit);
		$("#ade_name_edit")				.val(ade_name_edit);
		$("#ade_cellno_edit")			.val(ade_cellno_edit);
		$("#ade_cnic_edit")				.val(ade_cnic_edit);
		$("#ade_whatsapp_edit")			.val(ade_whatsapp_edit);
		$("#ade_email_edit")			.val(ade_email_edit);
		$("#ade_address_edit")			.val(ade_address_edit);
		$("#ade_id_edit")				.val(ade_id_edit);

       //pre-select data in pull down lists
       $("#ade_status_edit")			.select2().select2("val", ade_status_edit); 
       $("#id_company_edit")			.select2().select2("val", id_company_edit); 
  });
    
});
</script>';
}