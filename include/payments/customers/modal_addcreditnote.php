<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addCreditNoteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Credit Note</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<select id="id_paid_credit" name="id_paid" style="width:100%" autocomplete="off" required  onchange="get_customerbalanceCreditnote(this.value)">
				<option value="">Select Customer</option>';
				foreach($Customers as $listvendors) {  
					echo '<option value="'.$listvendors['customer_id'].'">'.$listvendors['customer_code'].' - '.$listvendors['customer_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
<div id="getcustomerbalanceCreditnote">
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Payable (Balance)</label>
			<input type="text" class="form-control" id="payable" name="payable" value="" autocomplete="off" readonly>
		</div> 
	</div>
</div>		
	
	<div style="clear:both;"></div>
	
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
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount" name="amount" required autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no" name="reference_no" autocomplete="off">
		</div> 
	</div>
	
<div style="clear:both;"></div>	
	
	<div class="col-sm-100">
		<div class="form_sep" style="margin-top:10px;">
			<label>Remarks</label>
			<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Method</label>
			<select id="method_modalcredit" name="method" style="width:100%" autocomplete="off" required  >
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].',0">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Category</label>
			<select id="cats-note" name="id_cat" style="width:100%" autocomplete="off" required >
				<option value="">Select Category</option>';
			foreach($Paycats as $listcat) {
				echo '<option value="'.$listcat['cat_id'].'">'.$listcat['cat_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Attach Receipt</b></label>
		<div class="col-lg-12">
			<input id="assign_file" name="assign_file" class="btn btn-mid btn-primary clearfix" type="file"  onChange="filevalidate(this.value)"> 
			<div style="font-weight:700;margin-top:5px;">File extension must be: ( <span style="color:blue; font-weight:700;">jpg,jpeg, gif, png, pdf</span> )</div>
		</div>
	</div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Save Record" id="submit_creditnotecountry" name="submit_creditnotecountry">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
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