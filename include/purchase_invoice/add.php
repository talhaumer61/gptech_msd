<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 

//To Generate Invoice Number
$sqllmsOrder  = $dblms->querylms("SELECT i.purchaseinvoice_id
										FROM ".PURCHASE_INVOICE." i  
										ORDER BY i.purchaseinvoice_id DESC LIMIT 1");
if(mysqli_num_rows($sqllmsOrder) == 1){

	$rowOrder = mysqli_fetch_array($sqllmsOrder);

	$invoiceNumber = ($rowOrder['purchaseinvoice_id'] + 1);

} else{

	$invoiceNumber = 1;
}
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" id="purchaseinvoice_no" name="purchaseinvoice_no" value="PI-'.$invoiceNumber.'">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;">Add Purchase Invoice</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Vendor</label>
			<select id="id_vendor" name="id_vendor" style="width:100%" onchange="get_vendorpaymentdetail(this.value)" autocomplete="off" required>
				<option value="">Select Vendor</option>';
				$sqllmsVendor  = $dblms->querylms("SELECT vendor_id, vendor_name 
														FROM ".VENDORS."   
														WHERE  vendor_status = '1' 
														ORDER BY vendor_id DESC");
				while($rowVendor =  mysqli_fetch_assoc($sqllmsVendor)) {
					echo '<option value="'.$rowVendor['vendor_id'].'">'.$rowVendor['vendor_name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Purchase Invoice Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date('Y-m-d').'" name="dated" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Invoice Paid Amount</label>
			<input type="text" class="form-control" id="invoice_paid"  name="invoice_paid" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Payment Method</label>
			<select id="payment_method" class="select2" name="payment_method" onchange="get_paymethoddetail(this.value)" style="width:100%" required autocomplete="off">
				<option value="">Choose Method</option>';
					foreach($pay_types as $paymode) { 
						echo '<option value="'.$paymode['id'].'">'.$paymode['name'].'</option>';
					}
				echo'
			</select>
		</div> 
	</div>

	<div id="getpaymethoddetail"></div>

	<div id="getvendorpaymentdetail">

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Order #</label>
			<input type="text" class="form-control" id="id_po"  name="id_po" required autocomplete="off">
		</div> 
	</div>

	</div>

	<div style="clear:both; padding:5px;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Purchase Invoice" id="submit_purchase_invoice" name="submit_purchase_invoice">
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->
<script src="js/sales.js"></script>

<script>
function getPOdetails(id_po) {  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/getPOdetails.php",  
		data: "id_po="+id_po,  
		success: function(msg){  
			$("#getPOdetails").html(msg); 
		}
	});  
}
</script>
<script>
    $("#id_vendor").select2({
        allowClear: true
    });
    $(".select2").select2({
        allowClear: true
    });
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#id_company").select2({
        allowClear: true
    });

	$("#id_customer").select2({
        allowClear: true
    });
	
	$("#item_type").select2({
        allowClear: true
    });
	$("#id_cat").select2({
        allowClear: true
    });
	$("#id_cls").select2({
        allowClear: true
    });
	$("#id_ade").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
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
});
</script>';
}