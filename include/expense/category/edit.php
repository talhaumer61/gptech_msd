<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '21', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Expense Category</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="cat_name_edit" name="cat_name_edit" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Detail</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="cat_detail_edit" name="cat_detail_edit" required autocomplete="off">
		</div>
	</div>
	    
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="cat_status_edit" name="cat_status_edit" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadms_tatus) {
				echo "<option value='$itemadms_tatus[status_id]'>$itemadms_tatus[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="cat_id_edit" name="cat_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>

	$("#cat_status_edit").select2({
        allowClear: true
    });
	
</script>

<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             cat_name_edit		: "required",
			 cat_detail_edit	: "required",
			 cat_status_edit	: "required"
		},
		messages: {
			cat_name_edit		: "This field is required",
			cat_detail_edit		: "This field is required",
			cat_status_edit		: "This field is required"
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
		var cat_status_edit 			= $(this).attr("data-com-status");
        var cat_name_edit 				= $(this).attr("data-com-name");
	    var cat_detail_edit 			= $(this).attr("data-com-detail");
		var cat_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#cat_name_edit")			.val(cat_name_edit);
		$("#cat_detail_edit")		.val(cat_detail_edit);
		$("#cat_id_edit")			.val(cat_id_edit);

       //pre-select data in pull down lists
       $("#cat_status_edit")			.select2().select2("val", cat_status_edit); 
  });
    
});
</script>';
}