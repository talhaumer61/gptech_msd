<?php
if(!isset($_GET['id']) && $view == 'add') {

		
		echo '
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="#" method="post" id="addNewRecord" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'callfollowups.php\'"><span>Close</span></button>
							<h4 class="modal-title" style="font-weight:700;"> Add Call Log</h4>
						</div>

						<div class="modal-body">

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Customer Name</label>
									<select id="top-list1" data-placeholder="Select Customer" name="id_customer" style="width:100%;" required>
										<option></option>';
										foreach($Customers as $valuectop) {  
											echo '<option value="'.$valuectop['customer_id'].'">'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].' ('.$valuectop['customer_cellno']	.')</option>';
										}
										echo '
									</select>
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Contact Person</label>
									<input type="text" name="contact_person" class="form-control"  required>
								</div>
							</div>

							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Phone Number</label>
									<input type="text" name="phone" class="form-control" required>
								</div>
								<div class="col-sm-6">
									<label for="" class="req">Call Status</label>
									<select name="call_status" id="call_status" style="width: 100%;" required>
										<option value="">Select Call Status</option>';
										foreach($call_statuses as $key => $status) {
											echo '
											<option value="'.$key.'">'.$status.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-6">
									<label for="" class="req">Purpose</label>
									<input type="text" class="form-control" name="purpose" list="cf-purposes" maxlength="150" required="" value="" placeholder="Pick a suggestion or type your own">
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
									<input type="text" class="form-control pickadate" id="datefrom" value="" name="next_followup" autocomplete="off">
									<span class="help-block" style="margin-bottom:0;">Leave empty if no follow-up is needed.</span>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>

							<div class="row">
								<div class="col-sm-12">
									<label for="">Remarks</label>
									<textarea class="form-control" name="remarks" rows="4" maxlength="2000"></textarea>
								</div>
							</div>
							<div style="clear:both; padding-bottom:5px;"></div>

						</div>

						<div class="modal-footer">
							<input class="btn btn-primary" type="submit" value="Add Call Log" id="add_calllog" name="add_calllog">
							<button type="button" class="btn btn-default" onclick="location.href=\'callfollowups.php\'" >Close</button>
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
			$("#top-list1").select2({
				allowClear: true
			});
			$("#call_status").select2({
				allowClear: true
			});
		</script>';

}
?>