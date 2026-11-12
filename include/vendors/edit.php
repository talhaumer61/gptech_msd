<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Vendor Detail</h4>
</div>

<div class="modal-body">
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Vendor Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="vendor_name_edit" name="vendor_name_edit" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="vendor_cellno_edit" name="vendor_cellno_edit" autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="vendor_email_edit" name="vendor_email_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Contact Person</label>
			<input type="text" class="form-control" id="vendor_contactperson_edit" name="vendor_contactperson_edit" autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="vendor_personcell_edit" name="vendor_personcell_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Whatsapp #</label>
			<input type="text" class="form-control" id="vendor_personwhatsapp_edit" name="vendor_personwhatsapp_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label>Address</label>
			<input type="text" class="form-control" id="vendor_address_edit" name="vendor_address_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="vendor_status_edit" name="vendor_status_edit" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadms_tatus) {
				echo "<option value='$itemadms_tatus[status_id]'>$itemadms_tatus[status_name]</option>";
			}
	echo'
			</select>
		</div> 
	</div>
	

	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="vendor_id_edit" name="vendor_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->


<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var vendor_status_edit 			= $(this).attr("data-com-status");
        var vendor_name_edit 			= $(this).attr("data-com-name");
		var vendor_cellno_edit 			= $(this).attr("data-com-phone");
		var vendor_contactperson_edit 	= $(this).attr("data-com-contactperson");
		var vendor_personcell_edit 		= $(this).attr("data-com-personcell");
		var vendor_personwhatsapp_edit 	= $(this).attr("data-com-personwhatsapp");
		var vendor_email_edit 			= $(this).attr("data-com-email");
		var vendor_address_edit 		= $(this).attr("data-com-address");
		var vendor_openingbalance_edit 	= $(this).attr("data-com-balance");
		var vendor_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#vendor_name_edit")			.val(vendor_name_edit);
		$("#vendor_cellno_edit")		.val(vendor_cellno_edit);
		$("#vendor_contactperson_edit")	.val(vendor_contactperson_edit);
		$("#vendor_personcell_edit")	.val(vendor_personcell_edit);
		$("#vendor_personwhatsapp_edit").val(vendor_personwhatsapp_edit);
		$("#vendor_email_edit")			.val(vendor_email_edit);
		$("#vendor_address_edit")		.val(vendor_address_edit);
		$("#vendor_openingbalance_edit").val(vendor_openingbalance_edit);
		$("#vendor_id_edit")			.val(vendor_id_edit);

       //pre-select data in pull down lists
       $("#vendor_status_edit")			.select2().select2("val", vendor_status_edit); 
  });
    
});
</script>';
}