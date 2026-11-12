<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '10', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Customer Code</label>
			<input type="text" class="form-control" id="customer_code" name="customer_code" value="CS-'.mt_rand(100000,999999).'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Customer Type</label>
			<select id="id_type" name="id_type" style="width:100%" autocomplete="off" required>
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
			<input type="text" class="form-control" id="customer_name" name="customer_name" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Organization Phone #</label>
			<input type="text" class="form-control" id="customer_cellno" name="customer_cellno" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="customer_email" name="customer_email" autocomplete="off">
		</div> 
	</div>
	

	<div style="clear:both;"></div>
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Name of Contact Person</label>
			<input type="text" class="form-control" id="customer_contactperson" name="customer_contactperson" autocomplete="off">
		</div> 
	</div>
	

	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="customer_personcell" name="customer_personcell" autocomplete="off">
			<small id="cell_error" class="text-danger" style="display:none;"></small>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Whatsapp #</label>
			<input type="text" class="form-control" id="customer_personwhatsapp" name="customer_personwhatsapp" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>

	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Address</label>
			<input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">City</label>
			<select id="id_city" name="id_city" style="width:100%" autocomplete="off" required>
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
			<select id="id_brand" name="id_brand" style="width:100%" autocomplete="off" required>
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
			<select id="id_company" name="id_company" style="width:100%" autocomplete="off" required>
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
			<select id="id_ade" name="id_ade" style="width:100%" autocomplete="off" required>
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
			<select id="customer_invoicelogo" name="customer_invoicelogo" style="width:100%" autocomplete="off" required>
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
			<select id="customer_status" name="customer_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'"'; if($itemadm_status['status_id'] == 1){echo' selected';}echo'>'.$itemadm_status['status_name'].'</option>';
			}
			echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->
<script type="text/javascript">
    $("#customer_status").select2({
        allowClear: true
    });
	$("#id_company").select2({
        allowClear: true
    });
	$("#id_ade").select2({
        allowClear: true
    });
	$("#id_brand").select2({
        allowClear: true
    });
	$("#id_zone").select2({
        allowClear: true
    });
	$("#id_type").select2({
        allowClear: true
    });
	$("#customer_invoicelogo").select2({
        allowClear: true
    });
	$("#id_city").select2({
        allowClear: true
    });
	
	$().ready(function() {
		$("#addNewCountry").validate({
			rules: {
				company_name		: "required",
				company_status		: "required"
			},
			messages: {
				company_name		: "This field is required",
				company_status		: "This field is required"
			},
			submitHandler: function(form) {
			form.submit();
			}
		});
		$("#customer_personcell").on("blur", function() {
			var cell = $(this).val();

			if(cell != ""){
				$.ajax({
					url: "include/ajax/customer/check_duplicate_cell.php",
					type: "POST",
					data: { cell: cell },
					success: function(response){
						if(response == "exists"){
							$("#cell_error")
								.text("This cell number already exists.")
								.show();

							$("#customer_personcell").addClass("is-invalid");
							$("#customer_personcell").focus();
						} else {
							$("#cell_error").hide();
							$("#customer_personcell").removeClass("is-invalid");
						}
					}
				});
			}else {
				$("#cell_error").hide();
			}
		});

	});
</script>';
}