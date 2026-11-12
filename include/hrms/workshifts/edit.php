<?php 
//------------------------------------------------
if(isset($_GET['id'])  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'edit' => '1'))) { 
//------------------------------------------------
	$sqllms  	= $dblms->querylms("SELECT * FROM ".SHIFTS."   
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND shift_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="workshifts.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Working Shift Detail</h4>
</div>

<div class="modal-body">
	
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="shiftstatus" name="shift_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				if($itemadm_status['status_id'] == $rowstd['shift_status']) { 
					echo '<option value="'.$itemadm_status['status_id'].'" selected>'.$itemadm_status['status_name'].'</option>';
				} else { 
					echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Work Shift Name</label>
			<input type="text" class="form-control" id="shift_name" name="shift_name" value="'.$rowstd['shift_name'].'" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>		
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Detail</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="shift_detail" name="shift_detail" value="'.$rowstd['shift_detail'].'" autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>	
<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;"> Work Schedule</div>	
<div style="clear:both;"></div>	
<table class="footable table table-bordered table-hover invE_table">
<thead>
<tr>
	<th rowspan="2" style="vertical-align:middle;">Working Days</th>
	<th rowspan="2" style="text-align:center;">Total Work Hours</th>
	<th colspan="2" style="text-align:center;">Regular Work Hours</th>
    <th colspan="2" style="text-align:center;">Lunch Break Hours</th>
</tr>
<tr>
	<th>From</th>
	<th>To</th>
	<th>From</th>
	<th>To</th>
</tr>
</thead>
<tbody>';
$srno = 0;
//--------------------------------------------
foreach($days as $itemdays) {
//------------------------------------------------
	$sqllmsdetail  	= $dblms->querylms("SELECT * FROM ".SHIFT_DETAIL."   
										WHERE id_shift = '".cleanvars($_GET['id'])."' 
										AND day = '".cleanvars($itemdays)."' LIMIT 1");
	$rowdetail 		= mysqli_fetch_array($sqllmsdetail);
//------------------------------------------------
$srno++;
if(mysqli_num_rows($sqllmsdetail)>0) { 
echo '
<tr class="inv_row">
	<td style="text-align:left;"><input id="wrkid['.$srno.']" name="wrkid['.$srno.']" checked="checked" type="checkbox" value="'.$srno.'" class="checkbox-inline"> '.$itemdays.'</td>
	<td style="width:100px;"><input type="text" class="col-lg-12" style="text-align:center;" value="'.$rowdetail['workinghours'].'" name="workinghours['.$srno.']" id="workinghours['.$srno.']" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" value="'.$rowdetail['time_from'].'" name="time_from['.$srno.']" id="time_from['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" value="'.$rowdetail['time_to'].'" name="time_to['.$srno.']" id="time_to['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" value="'.$rowdetail['break_from'].'" name="break_from['.$srno.']" id="break_from['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" value="'.$rowdetail['break_to'].'" name="break_to['.$srno.']" id="break_to['.$srno.']" list="timelist" /></td>
</tr>
<input type="hidden" name="days['.$srno.']" id="days['.$srno.']" value="'.$itemdays.'">';
//--------------------------------------------
} else { 
//--------------------------------------------

echo '
<tr class="inv_row">
	<td style="text-align:left;"><input id="wrkid['.$srno.']" name="wrkid['.$srno.']" type="checkbox" value="'.$srno.'" class="checkbox-inline"> '.$itemdays.'</td>
	<td style="width:100px;"><input type="text" class="col-lg-12" style="text-align:center;" name="workinghours['.$srno.']" id="workinghours['.$srno.']" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" name="time_from['.$srno.']" id="time_from['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" name="time_to['.$srno.']" id="time_to['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" name="break_from['.$srno.']" id="break_from['.$srno.']" list="timelist" /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12" name="break_to['.$srno.']" id="break_to['.$srno.']" list="timelist" /></td>
</tr>
<input type="hidden" name="days['.$srno.']" id="days['.$srno.']" value="'.$itemdays.'">';
//--------------------------------------------
}
//--------------------------------------------
}
//--------------------------------------------
echo '<datalist id="timelist">';
$timeslist = get_hours_range();
foreach($timeslist as $itemtime) { 
	echo '<option value="'.$itemtime.'" />';
}
echo '</datalist>';
//--------------------------------------------
echo '
</tbody>	
</table>

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="bill_changes" name="bill_changes">
	<button type="button" class="btn btn-default" onclick="location.href=\'workshifts.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
	$("#shiftstatus").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
}
}