<?php 
if(isset($_GET['id']) && !$view) {

	if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '181', 'edit' => '1'))) { 

		$queryTask = $dblms->querylms("SELECT * FROM ".TASKS." WHERE task_id = ".cleanvars($_GET['id'])."");
   		$valueTask = mysqli_fetch_array($queryTask);

		if($valueTask['due_date'] != '0000-00-00'){
			$dueDate = $valueTask['due_date'];
		} else{
			$dueDate = date('Y-m-d');
		}

		echo '
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="" method="post" id="" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'tasks.php\'"><span>Close</span></button>
							<h4 class="modal-title" style="font-weight:700;"> Update Task Details</h4>
						</div>

						<div class="modal-body">
							
							<div class="col-12">
									<label for="" class="req">Title of the Task</label>
									<input type="text" name="title" class="form-control" value="'.$valueTask['task_title'].'" required>
								</div>

								<div style="clear:both; padding-bottom:5px;"></div>

								<div class="col-12">
									<label for="">Write Description</label>
									<textarea name="description" id="" style="height: 200px;" cols="30" rows="20">'.$valueTask['task_description'].'</textarea>
								</div>

								<div style="clear:both; padding-bottom:5px;"></div>

								<div class="col-sm-41">
									<label for="" class="req">Priority Level</label>
									<select name="priority_level" id="priority" style="width: 100%;" required>
										<option value="">Select Priority Level</option>';
										foreach($priorityLevels as $key => $level) {
											echo '
											<option value="'.$key.'"'; if($key == $valueTask['task_status']){echo ' selected';} echo '>'.$level.'</option>';
										}
										echo '
									</select>
								</div>
								
								<div class="col-sm-41">
									<label for="" class="req">Due Date</label>
									<input type="text" name="duedate" class="form-control pickadate" value="'.$dueDate.'" required>
								</div>
								
								<div class="col-sm-41">
									<label for="">Attachment</label>
									<input type="file" name="attachment" class="form-control">
									<span style="padding-top:0;color:#f00; font-size:12px;">File should be less then 200KB & formats are (jpg, jpeg, png, pdf)</span>
								</div>';

							if($_SESSION['userlogininfo']['LOGINIDA'] == 7893) {
								
								echo '
								<div class="form-group" style="margin-bottom:2px;">
									<label class="control-label req col-lg-12" style="width:150px;"><b>Campus</b></label>
									<div class="col-lg-12">
										<select id="campus" name="campus" style="width:100%" autocomplete="off" required disabled>
										<option value=""></option>';
											$queryCampuses = $dblms->querylms("SELECT campus_id , campus_name FROM ".CAMPUSES." WHERE campus_id = '1' LIMIT 1");
											while($valueCampus = mysqli_fetch_array($queryCampuses)) {
												echo '<option value="'.$valueCampus['campus_id'].'" selected>'.$valueCampus['campus_name'].'</option>';
											}
											echo '
										</select>
									</div>
								</div>
								
								<div style="clear:both; padding-bottom:5px;"></div>';

							}

							echo '
							<div class="form-group">
								<label class="control-label col-lg-12 req" style="width:450px;"> <b>Assign To</b></label>
								<div class="col-lg-12">
									<select id="assignto" name="assignto[]" multiple required style="width:100%;">';
										foreach($arrayAdmins as $valueAdmin) {
											echo '<option value="'.$valueAdmin['adm_id'].'"';if(in_array($valueAdmin['adm_id'], explode(',', $valueTask['assigned_to']))){ echo ' selected';} echo '>'.$valueAdmin['adm_fullname'].' ('.$valueAdmin['adm_username'].')</option>';
										}
										echo '
									</select>
								</div>
							</div>';

							echo '
								<div style="clear:both; padding-bottom:5px;"></div>
						</div>

						<div class="modal-footer">
							<input type="hidden" value="'.cleanvars($_GET['id']).'" name="id_edit">
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
							<button type="button" class="btn btn-default" onclick="location.href=\'tasks.php\'">Close</button>
						</div>

					</div>
					
				</form>
				
			</div>
		</div>
		<script>
			$("#campus").select2({
				allowClear: true
			});
			$("#asignto").select2({
				allowClear: true
			});
			$("#priority").select2({
				allowClear: true
			});
			$("#assignto").select2({
				allowClear: true
			});
		</script>';

	} 
}
?>