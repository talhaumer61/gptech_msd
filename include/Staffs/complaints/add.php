<?php
if(!isset($_GET['id']) && $view == 'add') {

		
		echo '
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="#" method="post" id="addNewRecord" enctype="multipart/form-data">
					<input type="hidden" id="id_customer" name="id_customer" value="'.$id_customer.'">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'complaints.php\'"><span>Close</span></button>
							<h4 class="modal-title" style="font-weight:700;"> Add Complaint Details</h4>
						</div>

						<div class="modal-body">

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Title of the Complaint</label>
									<input type="text" name="title" class="form-control" autofocus required>
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Department</label>
									<select name="id_dept" id="id_dept" style="width: 100%;" required>
										<option value="">Select Department</option>';
										foreach($departments as $key => $dept) {
											echo '
											<option value="'.$key.'">'.$dept.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							

							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-12">
									<label for="">Write Description</label>
									<textarea name="description" id="" style="height: 200px;" cols="30" rows="20" ></textarea>
								</div>
							</div>
							
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Priority Level</label>
									<select name="priority_level" id="priority" style="width: 100%;" required>
										<option value="">Select Priority Level</option>';
										foreach($priorityLevels as $key => $level) {
											echo '
											<option value="'.$key.'">'.$level.'</option>';
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
							<input class="btn btn-primary" type="submit" value="Add Complaint" id="add_complaint" name="add_complaint">
							<button type="button" class="btn btn-default" onclick="location.href=\'complaints.php\'" >Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--WI_ADD_NEW_TASK_MODAL-->
		<script type="text/javascript">
			$().ready(function() {
				//USED BY: WI_ADD_NEW_TASK_MODAL
				//ACTIONS: validates the form and submits it
				//REQUIRES: jquery.validate.js
				$("#addNewRecord").validate({
					rules: {
						setup_session: "required",
						status: "required"
					},
					messages: {
						setup_session: "This field is required",
						status: "This field is required"
					},
					submitHandler: function(form) {
					//alert("form submitted");
					form.submit();
					}
				});
			});
		</script>
		<script>
			$("#priority").select2({
				allowClear: true
			});
			$("#id_dept").select2({
				allowClear: true
			});
		</script>';

}
?>