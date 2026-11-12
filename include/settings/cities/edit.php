<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '32', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit City Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>City Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="city_name_edit" name="city_name_edit" required autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">District</label>
			<select id="id_district_edit" name="id_district_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($Districts as $listdist) {
				echo '<option value="'.$listdist['district_id'].'">'.$listdist['district_name'].'</option>';
			}
			echo '
			</select>
		</div> 
	</div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="city_status_edit" name="city_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
			}
			echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="city_id_edit" name="city_id" value="">	
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
	$("#city_status_edit").select2({
        allowClear: true
    });
	$("#id_district_edit").select2({
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
		var city_status_edit 	= $(this).attr("data-com-status");
        var city_name_edit 		= $(this).attr("data-com-name");
		var id_district_edit 	= $(this).attr("data-com-district");
		var city_id_edit 		= $(this).attr("data-com-id");
		

        //set modal input values dynamically
		$("#city_name_edit")	.val(city_name_edit);
		$("#city_id_edit")		.val(city_id_edit);

       //pre-select data in pull down lists
       $("#city_status_edit")	.select2().select2("val", city_status_edit); 
       $("#id_district_edit")	.select2().select2("val", id_district_edit); 
  });
    
});
</script>';
}