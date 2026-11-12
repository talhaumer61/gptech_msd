<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) ) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Item Category</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
	<div class="form_sep">
		<label class="req">Cat Name</label>
		<input type="text" class="form-control" id="cat_name" name="cat_name" required autocomplete="off">
	</div> 
	</div>

	<div class="col-sm-61">
	<div class="form_sep" style="margin-top:5px;">
		<label class="req">Status</label>
		<select id="cat_status" name="cat_status" style="width:100%" autocomplete="off" required>
			<option value="">Select Status</option>';
		foreach($admstatus as $itemadm_status) {
			echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
		}
	echo '
		</select>
	</div> 
	</div>
	
	<div style="clear:both;"></div>
	<div style="clear:both;"></div>
	<div class="col-sm-91">
	<div class="form_sep">
		<label class="req">Cat Detail</label>
		<input type="text" class="form-control" id="cat_detail" name="cat_detail" required autocomplete="off">
	</div> 
	</div>
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->
<script>
    $("#item_status").select2({
        allowClear: true
    });
	
	$("#id_company").select2({
        allowClear: true
    });
	
	$("#item_type").select2({
        allowClear: true
    });
	$("#id_cat").select2({
        allowClear: true
    });
	$("#id_cls").select2({
        allowClear: true
    });
	$("#cat_status").select2({
        allowClear: true
    });
	
	
	
	$("#id_ade").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             company_name		: "required",
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}