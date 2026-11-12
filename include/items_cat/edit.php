<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) ) { 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Item Category</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
	<div class="form_sep">
		<label class="req">Cat Name</label>
		<input type="text" class="form-control" id="cat_name_edit" name="cat_name_edit" required autocomplete="off">
	</div> 
	</div>

	<div class="col-sm-61">
	<div class="form_sep" style="margin-top:5px;">
		<label class="req">Status</label>
		<select id="cat_status_edit" name="cat_status_edit" style="width:100%" autocomplete="off" required>
			<option value="">Select Status</option>';
		foreach($admstatus as $itemadm_status) {
			echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
		}
	echo '
		</select>
	</div> 
	</div>



	<div style="clear:both;"></div>
	<div class="col-sm-91">
	<div class="form_sep">
		<label class="req">Cat Detail</label>
		<input type="text" class="form-control" id="cat_detail_edit" name="cat_detail_edit" required autocomplete="off">
	</div> 
	</div>
	<div style="clear:both;"></div>
	

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
<!--JS_SELECT_LISTS-->
<script>
	$("#customer_status_edit").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_ade_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             company_name_edit		: "required",
			 company_status_edit	: "required"
		},
		messages: {
			company_name_edit		: "This field is required",
			company_status_edit		: "This field is required"
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
		var cat_id_edit 		= $(this).attr("data-cat-id");
		var cat_name_edit 		= $(this).attr("data-cat-name");
		var cat_status_edit 	= $(this).attr("data-cat-status");
		var cat_detail_edit 	= $(this).attr("data-cat-detail");

        //set modal input values dynamically
		$("#cat_name_edit") 			.val(cat_name_edit) 
		$("#cat_detail_edit") 			.val(cat_detail_edit) 
		$("#cat_id_edit") 				.val(cat_id_edit) 

       //pre-select data in pull down lists
       $("#cat_status_edit")				.select2().select2("val", cat_status_edit);
  });
    
});
</script>';
}