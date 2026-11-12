<?php 
if($_SESSION['userlogininfo']['LOGINIDA'] == 1 || $_SESSION['userlogininfo']['LOGINIDA'] == 2) { 

echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editAdmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editUsr">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit User Detail</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Full Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_fullname_edit" name="adm_fullname_edit" required autofocus autocomplete="off">
		</div>
	</div>
    
    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Login ID/ Email</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_username_edit" name="adm_username_edit" required autocomplete="off">
		</div>
	</div>
	
    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Login Password</b></label>
		<div class="col-lg-12">
			<input type="password" class="form-control" id="adm_userpass_edit" name="adm_userpass_edit" autocomplete="off">
		</div>
	</div>	

    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Email Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_email_edit" name="adm_email_edit" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Phone No.</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_phone_edit" name="adm_phone_edit" autocomplete="off">
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Type</b></label>
		<div class="col-lg-12">
			<select id="adm_type_edit" name="adm_type_edit" style="width:100%" autocomplete="off">
				<option value="">Select Type</option>';
			foreach($admtypes as $itemadmtypes) {
				echo '<option value="'.$itemadmtypes['id'].'">'.$itemadmtypes['name'].'</option>';
			}
echo '
			</select>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="adm_status_edit" name="adm_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($ad_status as $itemadmstatus) {
				echo '<option value="'.$itemadmstatus['status_id'].'">'.$itemadmstatus['status_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>';
//-------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1)) { 
echo '
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Company</b></label>
		<div class="col-lg-12">
			<select id="id_company_edit" name="id_company_edit" style="width:100%" autocomplete="off">
				<option value="">Select Company</option>';
				$sqllmscomp  = $dblms->querylms("SELECT company_id, company_name 
										FROM ".COMPANY." 
										ORDER BY company_name ASC");
//------------------------------------------------
			while($rowstdcom = mysqli_fetch_array($sqllmscomp)) {
				echo '<option value="'.$rowstdcom['company_id'].'">'.$rowstdcom['company_name'].'</option>';
			}
echo '
			</select>
		</div>
	</div>';
} 
//-------------------------------------------------
echo '
<div style="clear:both;"></div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="adm_id_edit" name="adm_id" value="">
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

    $(".edit-adm-modal").click(function(){
    
//get variables from "edit link" data attributes
		var adm_status_edit 		= $(this).attr("data-adstats");
		var adm_type_edit 			= $(this).attr("data-adtype");
        var adm_fullname_edit 		= $(this).attr("data-adm-fullname");
		var adm_username_edit 		= $(this).attr("data-adm-user");
		var adm_email_edit 			= $(this).attr("data-adm-email");
		var adm_phone_edit 			= $(this).attr("data-adm-phone");
		var id_company_edit 		= $(this).attr("data-adm-company");
		var id_office_edit 			= $(this).attr("data-adm-office");
		var adm_id_edit 			= $(this).attr("data-adm-id");
//set modal input values dynamically
		$("#adm_fullname_edit")		.val(adm_fullname_edit);
		$("#adm_username_edit")		.val(adm_username_edit);
		$("#adm_email_edit")		.val(adm_email_edit);
		$("#adm_phone_edit")		.val(adm_phone_edit);
		$("#adm_id_edit")			.val(adm_id_edit);

       //pre-select data in pull down lists
       $("#adm_status_edit")		.select2().select2("val", adm_status_edit); 
	   $("#adm_type_edit")			.select2().select2("val", adm_type_edit); 
	   $("#id_company_edit")		.select2().select2("val", id_company_edit); 
	   $("#id_office_edit")			.select2().select2("val", id_office_edit); 
  });
    
});
</script>';
}
