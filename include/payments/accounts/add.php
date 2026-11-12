<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '22', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Chart of Account</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account Name</label>
			<input type="text" class="form-control" id="account_name" name="account_name" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account #</label>
			<input type="text" class="form-control" id="account_no" name="account_no" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Opening Balance</label>
			<input type="number" class="form-control" id="account_balance" name="account_balance" autocomplete="off">
		</div> 
	</div>

	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="account_status" name="account_status" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadmstatus) {
				echo "<option value='$itemadmstatus[status_id]'>$itemadmstatus[status_name]</option>";
			}
	echo'
			</select>
		</div> 
	</div>

	
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-top:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Bank</b></label>
		<div class="col-lg-12">
			<select id="id_bank" name="id_bank" style="width:100%" autocomplete="off" required >
				<option value="">Select Bank</option>';
			$sqllmsloc	= $dblms->querylms("SELECT bank_id, bank_name 
													FROM ".BANKS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND bank_status = '1' ORDER BY bank_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) {  
					echo '<option value="'.$valueloc['bank_id'].'">'.$valueloc['bank_name'].'</option>';
				}
	echo'
			</select>
		</div>
	</div>

	
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Bank Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="account_bankaddress" name="account_bankaddress" autocomplete="off">
		</div>
	</div>

    <div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input class="btn btn-primary" type="submit" value=" Add Account " id="submit_country" name="submit_country">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}