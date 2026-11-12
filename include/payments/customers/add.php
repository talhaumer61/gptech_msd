<?php 
if(!isset($_GET['id'])  && LMS_VIEW == 'add') { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'customerpayments.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Payments</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" value="'.date("Y-m-d").'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no" name="receipt_no" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Method</label>
			<select id="method" name="method" style="width:100%" autocomplete="off" required onchange="get_bankaccounts(this.value)" >
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].',0">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	<div id="getbankaccounts">
	</div>
	<div style="clear:both;"></div>
	
	

	<div style="clear:both;margin-top:5px;"></div>
	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<select id="id_paid" name="id_paid" style="width:100%" autocomplete="off" required  onchange="get_customerbalance(this.value)">
				<option value="">Select Customer</option>';
				foreach($Customers as $listvendors) { 
					echo '<option value="'.$listvendors['customer_id'].'">'.$listvendors['customer_code'].' - '.$listvendors['customer_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
<div id="getcustomerbalance">
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Payable (Balance)</label>
			<input type="text" class="form-control" id="payable" name="payable" value="" autocomplete="off" readonly>
		</div> 
	</div>
</div>		
	
	<div style="clear:both;"></div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'customerpayments.php\'" >Cancel</button>
	<input class="btn btn-primary" type="submit" value="Add Payment" id="submit_multipleadd" name="submit_multipleadd" onClick=\'return confirmSubmit()\'>
	
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
<script type="text/javascript">

function filevalidate(file) {
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["jpg" , "jpeg", "pdf", "gif", "png"];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Wrong extension type, please attach valid file.");
        $("#assign_file").val("");
    }
}
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             id_paid	: "required",
			 method		: "required"
		},
		messages: {
			id_paid		: "This field is required",
			method		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}
}