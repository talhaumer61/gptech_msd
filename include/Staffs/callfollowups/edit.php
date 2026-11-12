<?php 
if(isset($_GET['id']) && !$view) {

	// if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '181', 'edit' => '1'))) { 

		$queryTask = $dblms->querylms("SELECT * FROM ".CALL_FOLLOWUPS." WHERE call_id = ".cleanvars($_GET['id'])."");
   		$valueTask = mysqli_fetch_array($queryTask);

		echo '
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="" method="post" id="" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'callfollowups.php\'"><span>Close</span></button>
							<h4 class="modal-title" style="font-weight:700;"> Update Call Log</h4>
						</div>

						<div class="modal-body">

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Customer Name</label>
									<select id="top-list1" data-placeholder="Select Customer" name="id_customer" style="width:100%;" required>
										<option></option>';
										foreach($Customers as $valuectop) {  
											echo '<option value="'.$valuectop['customer_id'].'" '.(($valuectop['customer_id'] == $valueTask['id_customer']) ? 'selected' : '').'>'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].' ('.$valuectop['customer_cellno']	.')</option>';
										}
										echo '
									</select>
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Contact Person</label>
									<input type="text" name="contact_person" class="form-control" required value="'.$valueTask['contact_person'].'">
								</div>
							</div>

							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Phone Number</label>
									<input type="text" name="phone" class="form-control" required value="'.$valueTask['phone'].'">
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Call Status</label>
									<select name="call_status" id="call_status" style="width: 100%;" required>
										<option value="">Select Call Status</option>';
										foreach($call_statuses as $key => $status) {
											echo '
											<option value="'.$key.'" '.(($key == $valueTask['call_status']) ? 'selected' : '').'>'.$status.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Purpose</label>
									<input type="text" class="form-control" name="purpose" list="cf-purposes" maxlength="150" required="" value="'.$valueTask['purpose'].'" placeholder="Pick a suggestion or type your own">
									<datalist id="cf-purposes">';
										foreach($call_purposes as $key => $purpose) {
											echo '
											<option value="'.$purpose.'">'.$purpose.'</option>';
										}
										echo '
									</datalist>
								</div>
							
								<div class="col-sm-6">
									<label for="">Next Follow-up Date</label>
									<input type="text" class="form-control pickadate" id="datefrom" value="'.($valueTask['next_followup'] == '0000-00-00' ? '' : $valueTask['next_followup']).'" name="next_followup" autocomplete="off">
									<span class="help-block" style="margin-bottom:0;">Leave empty if no follow-up is needed.</span>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-12">
									<label for="">Remarks</label>
									<textarea class="form-control" name="remarks" rows="4" maxlength="2000">'.$valueTask['remarks'].'</textarea>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>
						</div>

						<div class="modal-footer">
							<input type="hidden" value="'.cleanvars($_GET['id']).'" name="id_edit">
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
							<button type="button" class="btn btn-default" onclick="location.href=\'call_status.php\'">Close</button>
						</div>

					</div>
					
				</form>
				
			</div>
		</div>
		<script>
			$("#top-list1").select2({
				allowClear: true
			});
			$("#call_status").select2({
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