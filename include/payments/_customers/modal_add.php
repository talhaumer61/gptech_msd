<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Payments</h4>
</div>

<div class="modal-body">

	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account Name</label>
			<select id="id_account" name="id_account" style="width:100%" autocomplete="off" required tabindex="1">
				<option value="">Select Account</option>';
			$sqllmsaccount	= $dblms->querylms("SELECT account_id, account_name 
													FROM ".ACCOUNTS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND account_status = '1' ORDER BY account_name ASC");
				while($valueaccount	= mysqli_fetch_array($sqllmsaccount)) {  
					if($valueaccount['account_id'] == 2) { 
						echo '<option value="'.$valueaccount['account_id'].'" selected>'.$valueaccount['account_name'].' </option>';
					} else { 
						echo '<option value="'.$valueaccount['account_id'].'">'.$valueaccount['account_name'].' </option>';
					}
					
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Customer Name</label>
			<select id="id_paid" name="id_paid" style="width:100%" autocomplete="off" required tabindex="2">
				<option value="">Select Customer</option>';
			$sqllmsloc	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
													FROM ".CUSTOMERS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND customer_status = '1' ORDER BY customer_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) {  
					echo '<option value="'.$valueloc['customer_id'].'">'.$valueloc['customer_name'].' - '.$valueloc['customer_cellno'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" value="'.date("Y-m-d").'" autocomplete="off" tabindex="3">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Slip #</label>
			<input type="text" class="form-control" id="slipno" name="slipno" autocomplete="off" tabindex="4">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount" name="amount" autocomplete="off" tabindex="5">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Payment Method</label>
			<select id="method" name="method" style="width:100%" autocomplete="off" required tabindex="6">
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Type</label>
			<select id="type" name="type" style="width:100%" autocomplete="off" required tabindex="7">';
			foreach($ptypes as $iteptypess) {
				echo '<option value="'.$iteptypess['id'].'">'.$iteptypess['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque #</label>
			<input type="text" class="form-control" id="cheque" name="cheque" autocomplete="off" tabindex="8">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque Date</label>
			<input type="text" class="form-control pickadate" id="cheque_date" name="cheque_date" autocomplete="off" tabindex="9">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Banks</label>
			<select id="id_bank" name="id_bank" style="width:100%" autocomplete="off" tabindex="10">
				<option value="">Select Bank</option>';
				$sqllmsbanks	= $dblms->querylms("SELECT bank_id, bank_name 
													FROM ".BANKS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND bank_status = '1' ORDER BY bank_name ASC");
				while($valuebanks 	= mysqli_fetch_array($sqllmsbanks)) {  
					echo '<option value="'.$valuebanks['bank_id'].'">'.$valuebanks['bank_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off" tabindex="11">
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" tabindex="12">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Payment" id="submit_country" name="submit_country" tabindex="13">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
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