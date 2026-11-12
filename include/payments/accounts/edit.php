<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '22', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Chart of Account Detail</h4>
</div>
<div class="modal-body">
	
		<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account Name</label>
			<input type="text" class="form-control" id="account_name_edit" name="account_name_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account #</label>
			<input type="text" class="form-control" id="account_no_edit" name="account_no_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Opening Balance</label>
			<input type="number" class="form-control" id="account_balance_edit" name="account_balance_edit" autocomplete="off">
		</div> 
	</div>

	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="account_status_edit" name="account_status_edit" style="width:100%" autocomplete="off">
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
			<select id="id_bank_edit" name="id_bank_edit" style="width:100%" autocomplete="off" required>
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
			<input type="text" class="form-control" id="account_bankaddress_edit" name="account_bankaddress_edit" autocomplete="off">
		</div>
	</div>

    <div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="account_id" name="account_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             customer_name_edit		: "required",
			 status_edit	: "required"
		},
		messages: {
			customer_name_edit		: "This field is required",
			status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var account_status_edit 		= $(this).attr("data-com-status");
        var account_name_edit 			= $(this).attr("data-com-name");
		var id_bank_edit 				= $(this).attr("data-com-bank");
		var account_bankaddress_edit 	= $(this).attr("data-com-address");
		var account_balance_edit 		= $(this).attr("data-com-balance");
		var account_no_edit 			= $(this).attr("data-com-accno");
		var account_id 					= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#account_name_edit")			.val(account_name_edit);
		$("#account_no_edit")			.val(account_no_edit);
		$("#account_balance_edit")		.val(account_balance_edit);
		$("#account_bankaddress_edit")	.val(account_bankaddress_edit);
		$("#account_id")				.val(account_id);

       //pre-select data in pull down lists
       $("#account_status_edit")		.select2().select2("val", account_status_edit);
	   $("#id_bank_edit")				.select2().select2("val", id_bank_edit); 
  });
    
});
</script>';
}