<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '20', 'add' => '1'))) { 
//------------------------------------------------
	$sqllmslstorder  = $dblms->querylms("SELECT srno FROM ".EXPENSES."   
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'  
										AND id_office = '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'  
										ORDER BY srno DESC LIMIT 1");
	$valuelstorder 	= mysqli_fetch_assoc($sqllmslstorder);
if($valuelstorder['srno']<9) { 
	$srno = 'E0'.($valuelstorder['srno']+1);
} else { 
	$srno = 'E'.($valuelstorder['srno']+1);
}
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<input type="hidden" name="srno" id="srno" value="'.($valuelstorder['srno']+1).'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Expense Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Voucher #</label>
			<input type="text" class="form-control" id="voucher" name="voucher" value="'.($srno).'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Bill #</label>
			<input type="text" class="form-control" id="bill_no" name="bill_no" autocomplete="off">
		</div> 
	</div>
		
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount" name="amount" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Category</label>
			<select id="id_cat" name="id_cat" style="width:100%" autocomplete="off" required>
				<option value="">Select Category</option>';
			foreach($catarray as $itemcatsadd) {
					echo '<option value="'.$itemcatsadd['cat_id'].'">'.$itemcatsadd['cat_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date("Y-m-d").'" name="dated" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-top:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
		
		<select id="status" name="status" style="width:100%" autocomplete="off">';
			foreach($payments as $itempayments) {
				echo "<option value='$itempayments[id]'>$itempayments[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

	
	
	<div class="form-group" style="margin-top:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Note</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="note" name="note" autocomplete="off">
		</div>
	</div>

    <div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input class="btn btn-primary" type="submit" value=" Add Expense " id="submit_country" name="submit_country">
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
             customer_name		: "required",
			 status		: "required"
		},
		messages: {
			customer_name		: "This field is required",
			status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}