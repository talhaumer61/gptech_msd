<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '26', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Login Details Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Customer Name</b></label>
		<div class="col-lg-12">
			<select id="id_customer" name="id_customer" style="width:100%" autocomplete="off" required onchange="get_customerDetailforlogin(this.value)">
				<option value="">Select</option>';
			foreach($Customers as $listcustomer) {
				echo '<option value="'.$listcustomer['customer_id'].'">'.$listcustomer['customer_name'].'</option>';
			}
	echo '
			</select>
		</div>
	</div>	
<div id="getcustomerDetailforlogin">

	  <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Login ID/ Email</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_username" name="adm_username" required autocomplete="off">
		</div>
	</div>
	
    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Login Password</b></label>
		<div class="col-lg-12">
			<input type="password" class="form-control" id="adm_userpass" name="adm_userpass" autocomplete="off">
		</div>
	</div>	

    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Email Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_email" name="adm_email" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Cell No.</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_phone" name="adm_phone" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Whatsapp</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_personwhatsapp" name="adm_personwhatsapp" autocomplete="off">
		</div>
	</div>
</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="adm_status" name="adm_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($ad_status as $itemadmstatus) {
				echo '<option value="'.$itemadmstatus['status_id'].'">'.$itemadmstatus['status_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>

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
<script>
    $("#id_customer").select2({
        allowClear: true
    });
	$("#adm_status").select2({
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
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             company_name		: "required",
			 adm_username: {
						required: false,
						"remote":
							{
							  url: "include/ajax/validation/checkcustomerlogin.php",
							  type: "post",
							  data:
							  {
								  adm_username: function()
								  {
									  return $(\'#addNewCountry :input[name="adm_username"]\').val();
								  }
							  }
							}
					},
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required",
			adm_username: {
						remote: "This Customer login already exist."
					}
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}