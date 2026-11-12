<?php 
if(isset($_GET['id'])) { 
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'add' => '1'))) { 
//------------------------------------------------
	$sqllms  	= $dblms->querylms("SELECT *  
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										WHERE el.id = '".cleanvars($_GET['id'])."' 
										AND el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
//------------------------------------------------
$datefromedit = $rowstd['date_from'];
$newdatefrom = date('d-m-Y' , strtotime($datefromedit));

$datetoedit = $rowstd['date_to'];
$newdateto = date('d-m-Y', strtotime($datetoedit));

//------------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="employeeleaves.php?id='.cleanvars($_GET['id']).'" method="post" id="editCountry" enctype="multipart/form-data">
<input type="hidden" name="id_emply" id="id_emply" value="'.$rowstd['id_emply'].'">
<div class="modal-content">

<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Employee Leave Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Employee ID</label>
			<input type="text" class="form-control" id="emply_no" name="emply_no" value="'.$rowstd['emply_no'].'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" value="'.$rowstd['emply_name'].'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label>Alternate Employee</label>
			<select id="alternateemply" name="alternate_emply" style="width:100%" autocomplete="off">
				<option value="">Select Employee</option>';
				
				$sqllmsemply  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
													FROM ".EMPLOYEES." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND id_dept = '".cleanvars($rowstd['id_dept'])."' 
													AND emply_status = '1'
													ORDER BY emply_name ASC");
			while($rowemply		= mysqli_fetch_array($sqllmsemply)) {
				if($rowemply['emply_id'] == $rowstd['alternate_emply']) { 
					echo '<option value="'.$rowemply['emply_id'].'" selected>'.$rowemply['emply_no'].'-'.$rowemply['emply_name'].'</option>';
				} else { 
					echo '<option value="'.$rowemply['emply_id'].'">'.$rowemply['emply_no'].'-'.$rowemply['emply_name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Leave</label>
			<select id="idleave" name="id_leave" style="width:100%" autocomplete="off" required>
				<option value="">Select Leave</option>';
				$sqllmsleave  = $dblms->querylms("SELECT leave_id, leave_name 
													FROM ".LEAVES." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													ORDER BY leave_name ASC");
			while($rowleave		= mysqli_fetch_array($sqllmsleave)) {
				if($rowleave['leave_id'] == $rowstd['id_leave']) { 
					echo '<option value="'.$rowleave['leave_id'].'" selected>'.$rowleave['leave_name'].'</option>';
				} else { 
					echo '<option value="'.$rowleave['leave_id'].'">'.$rowleave['leave_name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Leave Type</label>
			<select id="leavetype" name="leave_type" style="width:100%" autocomplete="off" required>
				<option value="">Select Type</option>';
				foreach($leavetype as $itemtype) {
					if($itemtype['id'] == $rowstd['leave_type']) { 
						echo '<option value="'.$itemtype['id'].'" selected>'.$itemtype['name'].'</option>';
					} else { 
						echo '<option value="'.$itemtype['id'].'">'.$itemtype['name'].'</option>';
					}
				}
	echo'
			</select>
		</div> 
	</div>	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Duration</label>
			<select id="durationedit" name="duration" style="width:100%" autocomplete="off" required>
				<option value="">Select Duration</option>';
				foreach($leaveduration as $itemduration) {
					if($itemduration['id'] == $rowstd['duration']) { 
						echo '<option value="'.$itemduration['id'].'" selected>'.$itemduration['name'].'</option>';
					} else { 
						echo '<option value="'.$itemduration['id'].'">'.$itemduration['name'].'</option>';
					}
				}
	echo'
			</select>
		</div> 
	</div>	
	<div style="clear:both;"></div>
	
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">From Date</label>
			<input type="text" class="form-control pickadate" id="date_from" name="date_from" value="'.$newdatefrom.'" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">To Date</label>
			<input type="text" class="form-control pickadate" id="date_to" name="date_to" value="'.$newdateto.'" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Application</label>
			<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div> 
	</div>
	

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Reason</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="reason" name="reason" value="'.$rowstd['reason'].'" autocomplete="off">
		</div>
	</div>


</div>


<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="bill_changes" name="bill_changes">
	<button type="button" class="btn btn-default" onclick="location.href=\'employeeleaves.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
	
	$("#idleave").select2({
        allowClear: true
    });
	$("#leavetype").select2({
        allowClear: true
    });
	$("#durationedit").select2({
        allowClear: true
    });
	$("#alternateemply").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
}