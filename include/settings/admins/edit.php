<?php 
if(isset($_GET['id'])) { 
//--------------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA'] == 1 || $_SESSION['userlogininfo']['LOGINIDA'] == 2) {
	
	//--------------------------------------------	
	$listconditions = array ( 
								'select' 		=> '*',
								'where' 		=> array ( 
															'adm_id' 	=> cleanvars($_GET['id']) 
														), 
								'not_equal' 	=> array ( 
															'adm_id' => 1 
														), 

								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(ADMINS,  $listconditions);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="editAdmUsr" enctype="multipart/form-data" autocomplete="off">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'administrators.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Edit User Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req"> Full Name</label>
			<input type="text" class="form-control" id="adm_fullname" name="adm_fullname" required autofocus autocomplete="off" autocorrect="off" autocapitalize="off" value="'.$rowstd['adm_fullname'].'">
		</div>
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req"> Login ID/ Email</label>
			<input type="text" class="form-control" id="adm_username" name="adm_username" required autocomplete="off" autocorrect="off" autocapitalize="off" value="'.$rowstd['adm_username'].'">
		</div>
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label> Login Password</label>
			<input type="password" class="form-control" id="adm_userpass" name="adm_userpass" autocomplete="new-password" autocorrect="off" autocapitalize="off">
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label> Email Address</label>
			<input type="text" class="form-control" id="adm_email" name="adm_email" autocomplete="off" autocorrect="off" autocapitalize="off" value="'.$rowstd['adm_email'].'">
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label> Phone No.</label>
			<input type="text" class="form-control" id="adm_phone" name="adm_phone" autocomplete="off" autocorrect="off" autocapitalize="off" value="'.$rowstd['adm_phone'].'">
		</div>
	</div>
	
	<div style="clear:both;"></div>	

	
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Office</label>
			<select id="id_office" name="id_office" style="width:100%" autocomplete="off">
				<option value="">Select Office</option> 
			</select>
		</div>
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req"> User Type</label>
			<select id="adm_type" name="adm_type" style="width:100%" autocomplete="off">
				<option value="">Select Type</option>';
			foreach($admtypes as $itemadmtypes) {
				if($itemadmtypes['id'] == $rowstd['adm_type']) { 
					echo '<option value="'.$itemadmtypes['id'].'" selected>'.$itemadmtypes['name'].'</option>';
				} else { 
					echo '<option value="'.$itemadmtypes['id'].'">'.$itemadmtypes['name'].'</option>';
				}
			}
echo '
			</select>
		</div>
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req"> Status</label>
			<select id="adm_status" name="adm_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($ad_status as $itemadmstatus) {
				if($itemadmstatus['status_id'] == $rowstd['adm_status']) { 
					echo '<option value="'.$itemadmstatus['status_id'].'" selected>'.$itemadmstatus['status_name'].'</option>';
				} else { 
					echo '<option value="'.$itemadmstatus['status_id'].'">'.$itemadmstatus['status_name'].'</option>';
				}
				
			}
	echo'
			</select>
		</div>
	</div>

	
	<div style="clear:both;"></div>

<div class="col-lg-12 heading-modal" style="margin-top:5px; font-size:14px; font-weight:600; margin-bottom:5px; font-weight:600; font-size:14px;"><input id="checkall" name="checkall" type="checkbox" class="checkbox-inline"> All Rights</div>
	<div style="clear:both;"></div>
<div id="checkboxes">';
$sri = 0;
$ji = 0;
$kij = 0;
$rolesarray = array();
$brolesarray = array();
foreach($roletypes as $itemroletypes) { 
//------------------------------------------------

	// get Roles list

	$rolesconditions = array ( 
								'select' 		=> 'role_id, role_status, role_name, role_type',
								'where' 		=> array ( 
															'role_status' => 1,
															'role_type' 	=> $itemroletypes['id'] 
														), 
								'order_by' 		=> 'role_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Rolslist 	= $dblms->getRows(ROLES,  $rolesconditions);
//--------------------------------------------------
if (!empty($Rolslist)) {
//------------------------------------------------
$kij++;
	echo '
	<div style="clear:both;"></div>
	<div class="col-lg-12 heading-modal" style="font-size:13px; font-weight:600;margin-top:5px; margin-bottom:5px; font-weight:600; font-size:13px;"><input id="role_'.$kij.'" type="checkbox" class="checkbox-inline"> '.$itemroletypes['name'].'</div>
	<div style="clear:both;"></div>';
//------------------------------------------------
$rolesarray[] = ' $("#role_'.$kij.'").change(function () {
                $(".role_'.$kij.'").prop("checked", $(this).prop("checked"));
            });';
//------------------------------------------------
foreach($Rolslist as $rowroles) {
$sri++;
$ji++;
$brolesarray[] = ' $("#roleb_'.$sri.'").change(function () {
                $(".roleb_'.$sri.'").prop("checked", $(this).prop("checked"));
            });';
//------------------------------------------------

	$Adminrolesconditions = array ( 
								'select' 		=> 'right_name, added, updated, deleted, reporting, view, right_type, id_adm',
								'where' 		=> array ( 
															'right_type' => $itemroletypes['id'],
															'right_name' => $rowroles['role_id'],
															'id_adm' 	 => $_GET['id']
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowsadmvalue 		= $dblms->getRows(ADMIN_ROLES,  $Adminrolesconditions);
if(!empty($rowsadmvalue)) {
//------------------------------------------------
	if($rowsadmvalue['added'] == 1) 	{ $addchecked 	= ' checked="checked"'; } else { $addchecked 	= ''; }
	if($rowsadmvalue['updated'] == 1) 	{ $editchecked 	= ' checked="checked"'; } else { $editchecked 	= ''; }
	if($rowsadmvalue['deleted'] == 1) 	{ $deletchecked = ' checked="checked"'; } else { $deletchecked	= ''; }
	if($rowsadmvalue['view'] == 1) 		{ $viewchecked 	= ' checked="checked"'; } else { $viewchecked 	= ''; }
//------------------------------------------------
echo '
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label><input id="roleb_'.$sri.'" type="checkbox" class="checkbox-inline role_'.$kij.'"> '.$rowroles['role_name'].'</label><br>
			<input id="add_'.$sri.'" name="add['.$sri.']" type="checkbox" value="1" '.$addchecked.' class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> Add 
			<input id="edit_'.$sri.'" name="edit['.$sri.']" type="checkbox" value="1" '.$editchecked.' class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> Edit
			<input id="delete_'.$sri.'" name="delete['.$sri.']" type="checkbox" value="1" '.$deletchecked.' class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> Delete
			<input id="view_'.$sri.'"  name="view['.$sri.']" type="checkbox" value="1" '.$viewchecked.' class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> View
		</div> 
	</div>';
//----------------------------
} else  { 
//----------------------------
echo '
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label><input id="roleb_'.$sri.'" type="checkbox" class="checkbox-inline role_'.$kij.'"> '.$rowroles['role_name'].'</label><br>
			<input id="add_'.$sri.'" name="add['.$sri.']" type="checkbox" value="1" class="checkbox-inline role_'.$kij.' roleb_'.$sri.' "> Add 
			<input id="edit_'.$sri.'" name="edit['.$sri.']" type="checkbox" value="1" class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> Edit
			<input id="delete_'.$sri.'" name="delete['.$sri.']" type="checkbox" value="1" class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> Delete
			<input id="view_'.$sri.'"  name="view['.$sri.']" type="checkbox" value="1" class="checkbox-inline role_'.$kij.' roleb_'.$sri.'"> View
		</div> 
	</div>';
}
//----------------------------
echo '
	<input type="hidden" name="right_name['.$sri.']" id="right_name['.$sri.']" value="'.$rowroles['role_id'].'">
	<input type="hidden" name="right_type['.$sri.']" id="right_type['.$sri.']" value="'.$itemroletypes['id'].'">';
//----------------------------
}  // end while loop
//echo '<input type="hidden" name="right_type['.$sri.']" id="right_type['.$sri.']" value="'.$itemroletypes['id'].'"> ';
//----------------------------
} // end if count
} // end foreach
//----------------------------
echo '
</div>
<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'administrators.php\'" >Closed</button>
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_permission" name="submit_permission">
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
          $(document).ready(function(){ ';
foreach($rolesarray as $totalrole) { 
	echo $totalrole;
}
foreach($brolesarray as $totalbrole) { 
	echo $totalbrole;
}
          
echo '
          });
</script>';
//--------------------------------------
}
}
