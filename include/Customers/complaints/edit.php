<?php 
if(isset($_GET['id']) && !$view) {

	// if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '181', 'edit' => '1'))) { 

		$queryTask = $dblms->querylms("SELECT * FROM ".COMPLAINTS." WHERE complaint_id = ".cleanvars($_GET['id'])."");
   		$valueTask = mysqli_fetch_array($queryTask);

		echo '
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="" method="post" id="" enctype="multipart/form-data">
					<input type="hidden" id="id_customer" name="id_customer" value="'.$id_customer.'">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'complaints.php\'"><span>Close</span></button>
							<h4 class="modal-title" style="font-weight:700;"> Update Complaint Details</h4>
						</div>

						<div class="modal-body">

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Title of the Complaint</label>
									<input type="text" name="title" class="form-control"  value="'.$valueTask['complaint_title'].'" required>
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Department</label>
									<select name="id_dept" id="id_dept" style="width: 100%;" required>
										<option value="">Select Department</option>';
										foreach($departments as $key => $dept) {
											echo '
											<option value="'.$key.'" '.(($key == $valueTask['id_dept']) ? 'selected' : '').'>'.$dept.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-12">
									<label for="">Write Description</label>
									<textarea name="description" id="" style="height: 200px;" cols="30" rows="20" >'.$valueTask['complaint_description'].'</textarea>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Priority Level</label>
									<select name="priority_level" id="priority" style="width: 100%;" required>
										<option value="">Select Priority Level</option>';
										foreach($priorityLevels as $key => $level) {
											echo '
											<option value="'.$key.'" '.(($key == $valueTask['complaint_priority']) ? 'selected' : '').'	>'.$level.'</option>';
										}
										echo '
									</select>
								</div>
							
								<div class="col-sm-6">
									<label for="">Attachment</label>
									<input type="file" name="attachment" class="form-control">
									<span style="padding-top:0;color:#f00; font-size:12px;">File should be less then 200KB & formats are (jpg, jpeg, png, pdf)</span>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>
						</div>

						<div class="modal-footer">
							<input type="hidden" value="'.cleanvars($_GET['id']).'" name="id_edit">
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
							<button type="button" class="btn btn-default" onclick="location.href=\'complaints.php\'">Close</button>
						</div>

					</div>
					
				</form>
				
			</div>
		</div>
		<script>
			$("#campus").select2({
				allowClear: true
			});
			$("#id_dept").select2({
				allowClear: true
			});
			$("#priority").select2({
				allowClear: true
			});
			$("#assignto").select2({
				allowClear: true
			});
		</script>';

	// } 
}
?>