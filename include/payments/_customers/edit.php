<?php 

//------------------------------------------------
if(isset($_GET['id']) && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) { 



//--------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.pay_type = '1' AND b.id = '".cleanvars($_GET['id'])."' LIMIT 1 ");
	$rowspay = mysqli_fetch_array($sqllms);
//--------------------------------------------

echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="customerpayments.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Payment Detail</h4>
</div>

<div class="modal-body">
	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account Name</label>
			<select id="id_account_edit" name="id_account_edit" style="width:100%" autocomplete="off" required tabindex="1">
				<option value="">Select Account</option>';
			$sqllmsaccount	= $dblms->querylms("SELECT account_id, account_name 
													FROM ".ACCOUNTS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND account_status = '1' ORDER BY account_name ASC");
				while($valueaccount	= mysqli_fetch_array($sqllmsaccount)) {  
					if($rowspay['id_account'] == $valueaccount['account_id']) { 
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
			<select id="id_paid_edit" name="id_paid_edit" style="width:100%" autocomplete="off" required tabindex="2">
				<option value="">Select Customer</option>';
			$sqllmsloc	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
													FROM ".CUSTOMERS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND customer_status = '1' ORDER BY customer_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) {  
					if($rowspay['id_paid'] == $valueloc['customer_id']) { 
						echo '<option value="'.$valueloc['customer_id'].'" selected>'.$valueloc['customer_name'].' - '.$valueloc['customer_cellno'].'</option>';
					} else { 
						echo '<option value="'.$valueloc['customer_id'].'">'.$valueloc['customer_name'].' - '.$valueloc['customer_cellno'].'</option>';
					}
					
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated_edit" name="dated_edit" value="'.$rowspay['dated'].'" autocomplete="off" tabindex="3">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Slip #</label>
			<input type="text" class="form-control" id="slipno_edit" name="slipno_edit" value="'.$rowspay['slipno'].'" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_edit" name="amount_edit" value="'.$rowspay['amount'].'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Payment Method</label>
			<select id="method_edit" name="method_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				if($rowspay['method'] == $itempaytypes['id']) { 
					echo '<option value="'.$itempaytypes['id'].'" selected>'.$itempaytypes['name'].'</option>';
				} else { 
					echo '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Type</label>
			<select id="type_edit" name="type_edit" style="width:100%" autocomplete="off" required>';
			foreach($ptypes as $iteptypess) {
				if($rowspay['type'] == $iteptypess['id']) { 
					echo '<option value="'.$iteptypess['id'].'" selected>'.$iteptypess['name'].'</option>';
				} else { 
					echo '<option value="'.$iteptypess['id'].'">'.$iteptypess['name'].'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque #</label>
			<input type="text" class="form-control" id="cheque_edit" name="cheque_edit" value="'.$rowspay['cheque'].'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque Date</label>
			<input type="text" class="form-control pickadate" id="cheque_date_edit" name="cheque_date_edit" value="'.$rowspay['cheque_date'].'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Banks</label>
			<select id="id_bank_edit" name="id_bank_edit" style="width:100%" autocomplete="off">
				<option value="">Select Bank</option>';
				$sqllmsbanks	= $dblms->querylms("SELECT bank_id, bank_name 
													FROM ".BANKS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND bank_status = '1' ORDER BY bank_name ASC");
				while($valuebanks 	= mysqli_fetch_array($sqllmsbanks)) {  
					if($rowspay['id_bank'] == $valuebanks['bank_id']) { 
						echo '<option value="'.$valuebanks['bank_id'].'" selected>'.$valuebanks['bank_name'].'</option>';
					} else { 
						echo '<option value="'.$valuebanks['bank_id'].'">'.$valuebanks['bank_name'].'</option>';
					}
					
				}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks_edit" name="remarks_edit" value="'.$rowspay['remarks'].'" autocomplete="off">
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="submit" class="btn btn-primary" value="savechanges" id="billchanges" name="billchanges">Save Changes</button> 
	<button type="button" class="btn btn-default" onclick="location.href=\'customerpayments.php\'" >Cancel</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->';
}
}