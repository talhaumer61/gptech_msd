<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'edit' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="editCreditNoteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="EditCreditnote" name="EditCreditnote" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Credit Note</h4>
</div>

<div class="modal-body">


	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customername_crnote" name="customername_crnote" value="" autocomplete="off" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Contact #</label>
			<input type="text" class="form-control" id="cellno_crnote" name="cellno_crnote" value="" autocomplete="off" readonly>
		</div> 
	</div>

	
	<div style="clear:both;"></div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated_crnote" name="dated_crnote" value="" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no_crnote" name="receipt_no_crnote" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_crnote" name="amount_crnote" required autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no_crnote" name="reference_no_crnote" autocomplete="off">
		</div> 
	</div>
	
<div style="clear:both;"></div>	
	
	<div class="col-sm-100">
		<div class="form_sep" style="margin-top:10px;">
			<label>Remarks</label>
			<input type="text" class="form-control" id="remarks_crnote" name="remarks_crnote" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Method</label>
			<select id="method_modal_crnote" name="method_modal_crnote" style="width:100%" autocomplete="off" required  >
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Category</label>
			<select id="id_cat_noteedit" name="id_cat_noteedit" style="width:100%" autocomplete="off" required >
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
	<input type="hidden" id="id_edit" name="id_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="change_creditnotecountry" name="change_creditnotecountry">

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
	$("#EditCreditnote").validate({
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
</script>

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-creditnote-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var dated_crnote 			= $(this).attr("data-com-date");
        var customername_crnote 	= $(this).attr("data-com-name");
		var cellno_crnote 			= $(this).attr("data-com-cellno");
		var amount_crnote 			= $(this).attr("data-com-amount");
		var reference_no_crnote		= $(this).attr("data-com-reference");
		var receipt_no_crnote 		= $(this).attr("data-com-receipt");
		var method_modal_crnote 	= $(this).attr("data-com-pmode");
		var remarks_crnote 			= $(this).attr("data-com-remarks");
		var id_cat_noteedit 		= $(this).attr("data-com-idcat");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_crnote")			.val(dated_crnote);
		$("#customername_crnote")	.val(customername_crnote);
		$("#cellno_crnote")			.val(cellno_crnote);
		$("#amount_crnote")			.val(amount_crnote);
		$("#receipt_no_crnote")		.val(receipt_no_crnote);
		$("#reference_no_crnote")	.val(reference_no_crnote);
		$("#remarks_crnote")		.val(remarks_crnote);
		$("#id_edit")				.val(id_edit);

       //pre-select data in pull down lists
       $("#method_modal_crnote")	.select2().select2("val", method_modal_crnote); 
       $("#id_cat_noteedit")		.select2().select2("val", id_cat_noteedit); 
 
  });
    
});
</script>';
}