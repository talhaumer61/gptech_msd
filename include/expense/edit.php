<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '20', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Expense Detail</h4>
</div>
<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Voucher #</label>
			<input type="text" class="form-control" id="voucher_edit" name="voucher_edit" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Bill #</label>
			<input type="text" class="form-control" id="bill_no_edit" name="bill_no_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_edit" name="amount_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Category</label>
			<select id="id_cat_edit" name="id_cat_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Category</option>';
			foreach($catarray as $itemcatsedit) { 
					echo '<option value="'.$itemcatsedit['cat_id'].'">'.$itemcatsedit['cat_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated_edit" name="dated_edit" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-top:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
		
		<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off">';
			foreach($payments as $itempayments) {
				echo "<option value='$itempayments[id]'>$itempayments[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Note</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="note_edit" name="note_edit" autocomplete="off">
		</div>
	</div>

    <div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="id_edit" name="edit_id" value="">
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
		var status_edit 				= $(this).attr("data-com-status");
        var dated_edit 					= $(this).attr("data-com-dated");
		var id_cat_edit 				= $(this).attr("data-com-cat");
		var voucher_edit 				= $(this).attr("data-com-voucher");
		var bill_no_edit 				= $(this).attr("data-com-billno");
		var amount_edit 				= $(this).attr("data-com-amount");
		var note_edit 					= $(this).attr("data-com-note");
		var id_edit 					= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")				.val(dated_edit);
		$("#voucher_edit")				.val(voucher_edit);
		$("#bill_no_edit")				.val(bill_no_edit);
		$("#amount_edit")				.val(amount_edit);
		$("#note_edit")					.val(note_edit);
		$("#id_edit")					.val(id_edit);

       //pre-select data in pull down lists
       $("#status_edit")				.select2().select2("val", status_edit);
	   $("#id_cat_edit")				.select2().select2("val", id_cat_edit); 
  });
    
});
</script>';
}