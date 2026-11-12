<?php 
if(LMS_VIEW == 'addstock' && !isset($_GET['id'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) { 	


echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'purchase-order.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Stock in</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">GRN</label>
			<input type="text" class="form-control" id="grn" name="grn" required value=""  autocomplete="off">
		</div> 
	</div>

	
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">GRN Date</label>
				<input type="text" class="form-control" id="grn_date" name="grn_date" required value="'.date("d/m/Y").'" readonly  autocomplete="off">
			</div> 
		</div>
	
	
	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Vendor</label>
			<select id="id_vendor" name="id_vendor" onchange="get_vendororder(this.value)" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				$sqllmsvendor  = $dblms->querylms("SELECT vendor_id , vendor_name 
														FROM ".VENDORS."   
														WHERE  vendor_status = 1 
														ORDER BY vendor_id DESC");
				while($rowvendor = mysqli_fetch_assoc($sqllmsvendor)) {
					echo '<option value="'.$rowvendor['vendor_id'].'">'.$rowvendor['vendor_name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>

	<div id="getVendorOrders">
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Vendor Orders</label>
				<select id="vendor_order" name="vendor_order" style="width:100%" autocomplete="off" required>
					<option value="">Select</option>
				</select>
			</div> 
		</div>
	</div>
	
	<div style="clear:both; padding:5px;"></div>

	<div id="getVendorOrderDetail"></div>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'purchase-order.php\'">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Stock in" id="submit_stockin" name="submit_stockin" onClick=\'return confirmSubmit()\'>
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>

<script>


	$("#id_vendor").select2({
        allowClear: true
    });
	$("#vendor_order").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
	$().ready(function() {
		$("#inv_form").validate({
			rules: {
				id_vendor		: "required",
				vendor_order	: "required"
			},
			messages: {
				id_vendor		: "This field is required",
				vendor_order	: "This field is required"
			},
			submitHandler: function(form) {
			form.submit();
			}
		});
	});
</script>';
}else {
	echo '<h1 style="margin-top: 200px; color: #f00; font-weight: 600; text-align: center;">Sorry, you have no right to access this page</h1>';
	
}
}