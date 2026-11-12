<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'edit' => '1'))) { 
if(isset($_GET['id'])  && !LMS_VIEW) { 
	
	$conditions = array ( 
								'select' 	=> '*',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													''.PAYMENTS.'.id' 			=> cleanvars($_GET['id']), 
													''.PAYMENTS.'.ledgerfor' 	=> 1, 
													''.PAYMENTS.'.debit_credit' => 1 
												), 
								'not_in' 		=> " AND ".PAYMENTS.".docs_types NOT IN(3)",
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowEdit 	= $dblms->getRows(PAYMENTS, $conditions);
	
	
	$Invconditions = array ( 
								'select' 	=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, '.SALES_INVOICE.'.grand_total,
												'.SALES_INVOICE.'.paid, '.SALES_INVOICE.'.balance, '.SALES_INVOICE.'.dated, '.SALES_INVOICE.'.total, 
												'.SALES_INVOICE.'.prev_balance, '.SALES_INVOICE.'.salesinvoice_status ',
								'join' 		=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' => array( 
													''.SALES_INVOICE.'.id_customer' => cleanvars($rowEdit['id_user'])
												), 
								'order_by' 		=> " ".SALES_INVOICE.".salesinvoice_id DESC",
								'return_type' 	=> 'all' 
							); 
    $totalInvoices 	= $dblms->getRows(SALES_INVOICE, $Invconditions);
		

echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="#" method="post" id="editCountry" enctype="multipart/form-data">
<input type="hidden" id="id_edit" name="id_edit" value="'.$rowEdit['id'].'">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'customerpayments.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Payment</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">System Slip #</label>
			<input type="text" class="form-control" id="systemslip_no" name="systemslip_no" value="'.$rowEdit['systemslip_no'].'" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label>Customer</label>
			<input type="text" class="form-control" id="vendorname_edit" name="vendorname_edit" value="'.$rowEdit['customer_code'].'- '.$rowEdit['customer_name'].'" autocomplete="off" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Payment Category</label>
			<select id="cats-note" name="id_cat" style="width:100%" autocomplete="off" required >
				<option value="">Select Category</option>';
			foreach($Paycats as $listcat) { 
				echo ($listcat['cat_id'] == $rowEdit['id_cat']) ? '<option value="'.$listcat['cat_id'].'" selected>'.$listcat['cat_name'].'</option>' : '<option value="'.$listcat['cat_id'].'">'.$listcat['cat_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" value="'.$rowEdit['dated'].'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no" name="receipt_no" value="'.$rowEdit['receipt_no'].'" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="text" class="numbers form-control" id="amount" name="amount" onblur="numberWithCommas(this)" value="'.number_format($rowEdit['amount']).'" required autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no" name="reference_no" value="'.$rowEdit['reference_no'].'" autocomplete="off">
		</div> 
	</div>
	
	
<div style="clear:both;"></div>	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Method</label>
			<select id="method" name="method" style="width:100%" autocomplete="off" required onchange="get_bankaccounts(this.value)" >';
			foreach($pay_types as $itempaytypes) {
				if($rowEdit['pay_mode'] == $itempaytypes['id']) {
					echo '<option value="'.$itempaytypes['id'].','.$rowEdit['id_account'].'" selected>'.$itempaytypes['name'].'</option>';
				} else {
					echo '<option value="'.$itempaytypes['id'].','.$rowEdit['id_account'].'">'.$itempaytypes['name'].'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
	<div id="getbankaccounts">';
if($rowEdit['pay_mode'] == 1) {
	echo ' 
		<div class="col-sm-41">
			<div class="form_sep" style="margin-top:10px;">
				<label class="req">Account #</label>
				<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off">
					<option value="">Select Account</option>';
						foreach($bankAccounts as $account) { 
							if($rowEdit['id_account'] == $account['id']) {
								echo '<option value="'.$account['id'].'" selected>'.$account['bank'].' - '.$account['acc_number'].'</option>';
							} else {
								echo '<option value="'.$account['id'].'">'.$account['bank'].' - '.$account['acc_number'].'</option>';
							}
							
						}
				echo'
				</select>
			</div> 
		</div>
		<script>
			$("#id_account").select2({
				allowClear: true
			});			
		</script>';
}
	
echo '
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Invoice #</label>
			<select id="invoice-list" name="id_invoice" style="width:100%" autocomplete="off" >
			<option value="">Select Invoice</option>';
			foreach($totalInvoices as $rowInvoice) {
				if($rowEdit['id_invoice'] == $rowInvoice['salesinvoice_id']) {
					echo '<option value="'.$rowInvoice['salesinvoice_id'].'" selected>'.$rowInvoice['salesinvoice_no'].' ('.$rowInvoice['total'].')</option>';
				} else {
					echo '<option value="'.$rowInvoice['salesinvoice_id'].'">'.$rowInvoice['salesinvoice_no'].' ('.$rowInvoice['total'].')</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" value="'.$rowEdit['remarks'].'" autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>

	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Attach Receipt</b></label>
		<div class="col-lg-12">
			<input id="assign_file_edit" name="assign_file_edit" class="btn btn-mid btn-primary clearfix" type="file"  onChange="filevalidateedit(this.value)"> 
			<div style="font-weight:700;margin-top:5px;">File extension must be: ( <span style="color:blue; font-weight:700;">jpg,jpeg, gif, png, pdf</span> )</div>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'customerpayments.php\'" >Cancel</button>
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>

</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             id_paid_edit	: "required",
			 method_edit	: "required"
		},
		messages: {
			id_paid_edit	: "This field is required",
			method_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
';
}
}