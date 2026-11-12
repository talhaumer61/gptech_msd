<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '10', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Customer Code</label>
			<input type="text" class="form-control" id="customer_code_edit" name="customer_code_edit" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Customer Type</label>
			<select id="id_type_edit" name="id_type_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($customertype as $listtype) {
				echo '<option value="'.$listtype['id'].'">'.$listtype['name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customer_name_edit" name="customer_name_edit" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;margin-bottom:10px;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>MES/LHS Campus Code</label>
			<input type="text" class="form-control" id="customer_codelhsmes_edit" name="customer_codelhsmes_edit" autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Organization Phone #</label>
			<input type="text" class="form-control" id="customer_cellno_edit" name="customer_cellno_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="customer_email_edit" name="customer_email_edit" autocomplete="off">
		</div> 
	</div>


	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Name of Contact Person</label>
			<input type="text" class="form-control" id="customer_contactperson_edit" name="customer_contactperson_edit" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="customer_personcell_edit" name="customer_personcell_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Whatsapp #</label>
			<input type="text" class="form-control" id="customer_personwhatsapp_edit" name="customer_personwhatsapp_edit" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Address</label>
			<input type="text" class="form-control" id="customer_address_edit" name="customer_address_edit" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">City</label>
			<select id="id_city_edit" name="id_city_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($Cities as $listcity) {
				echo '<option value="'.$listcity['city_id'].'">'.$listcity['city_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Brand</label>
			<select id="id_brand_edit" name="id_brand_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($brandnames as $listbrand) {
				echo '<option value="'.$listbrand['id'].'">'.$listbrand['name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Zone</label>
			<select id="id_company_edit" name="id_company_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($Company as $listcompany) {
				echo '<option value="'.$listcompany['company_id'].'">'.$listcompany['company_code'].'-'.$listcompany['company_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>

	<!-- div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">ADE</label>
			<select id="id_ade_edit" name="id_ade_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($Ades as $itemade) {
				echo '<option value="'.$itemade['ade_id'].'">'.$itemade['ade_name'].'('.$itemade['ade_cellno'].')</option>';
			}
	echo '
			</select>
		</div> 
	</div -->
	
	<!-- div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Invoice Logo</label>
			<select id="customer_invoicelogo_edit" name="customer_invoicelogo_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($invoicelogo as $listinvlogo) {
				echo '<option value="'.$listinvlogo['id'].'">'.$listinvlogo['name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div -->

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Status</label>
			<select id="customer_status_edit" name="customer_status_edit" style="width:100%" autocomplete="off" required>
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
	<input type="hidden" id="customer_id_edit" name="customer_id" value="">
	<input type="hidden" id="loginid_edit" name="loginid_edit" value="">
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
	$("#customer_status_edit").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_ade_edit").select2({
        allowClear: true
    });
	$("#id_brand_edit").select2({
        allowClear: true
    });
	$("#id_zone_edit").select2({
        allowClear: true
    });
	$("#id_city_edit").select2({
        allowClear: true
    });
	$("#id_type_edit").select2({
        allowClear: true
    });
	$("#customer_invoicelogo_edit").select2({
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
		var customer_status_edit 		= $(this).attr("data-com-status");
        var customer_code_edit 			= $(this).attr("data-com-code");
        var customer_name_edit 			= $(this).attr("data-com-name");
        var customer_codelhsmes_edit 	= $(this).attr("data-com-codelhsmes");
		var customer_cellno_edit 		= $(this).attr("data-com-phone");
		var customer_email_edit 		= $(this).attr("data-com-email");
		var customer_openingbalance_edit= $(this).attr("data-com-openingbalance");
		var customer_address_edit 		= $(this).attr("data-com-address");
		var customer_contactperson_edit = $(this).attr("data-com-person");
		var customer_personcell_edit 	= $(this).attr("data-com-personcell");
		var customer_personwhatsapp_edit= $(this).attr("data-com-personwhatsapp");
		var id_ade_edit 				= $(this).attr("data-com-ade");
		var id_company_edit 			= $(this).attr("data-com-company");
		var id_brand_edit 				= $(this).attr("data-com-brand");
		var id_zone_edit 				= $(this).attr("data-com-zone");
		var id_city_edit 				= $(this).attr("data-com-city");
		var id_type_edit 				= $(this).attr("data-com-idtype");
		var customer_invoicelogo_edit 	= $(this).attr("data-com-invoicelogo");
		var customer_id_edit 			= $(this).attr("data-com-id");
		var loginid_edit 				= $(this).attr("data-com-loginid");

        //set modal input values dynamically
		$("#customer_name_edit")			.val(customer_name_edit);
		$("#customer_codelhsmes_edit")		.val(customer_codelhsmes_edit);
		$("#customer_code_edit")			.val(customer_code_edit);
		$("#customer_cellno_edit")			.val(customer_cellno_edit);
		$("#customer_email_edit")			.val(customer_email_edit);
		$("#customer_address_edit")			.val(customer_address_edit);
		$("#customer_contactperson_edit")	.val(customer_contactperson_edit);
		$("#customer_personcell_edit")		.val(customer_personcell_edit);
		$("#customer_personwhatsapp_edit")	.val(customer_personwhatsapp_edit);
		$("#customer_openingbalance_edit")	.val(customer_openingbalance_edit);
		$("#customer_id_edit")				.val(customer_id_edit);
		$("#loginid_edit")					.val(loginid_edit);

       //pre-select data in pull down lists
       $("#customer_status_edit")		.select2().select2("val", customer_status_edit); 
       $("#id_ade_edit")				.select2().select2("val", id_ade_edit); 
       $("#id_city_edit")				.select2().select2("val", id_city_edit); 
       $("#id_company_edit")			.select2().select2("val", id_company_edit); 
       $("#id_brand_edit")				.select2().select2("val", id_brand_edit); 
       $("#id_zone_edit")				.select2().select2("val", id_zone_edit); 
       $("#id_type_edit")				.select2().select2("val", id_type_edit); 
       $("#customer_invoicelogo_edit")	.select2().select2("val", customer_invoicelogo_edit); 
  });
    
});
</script>';
}