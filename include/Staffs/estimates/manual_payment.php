<?php 
if(isset($_GET['id']) && LMS_VIEW == 'challan_generated') {

	if(in_array($_SESSION['userlogininfo']['LOGINIDA'], [2, 825])) { 

		$conditions = array ( 
									'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
													'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
									'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
													INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
													INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
									'where' 	=> array ( 
															''.ESTIMATES.'.estimate_id' 		=> cleanvars($_GET['id']),
															''.ESTIMATES.'.estimate_status' 	=> '6'
														), 
									'limit' 		=> 1,
									'return_type' 	=> 'single' 
								); 
		$rowstd 	= $dblms->getRows(ESTIMATES, $conditions);

		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%">
				<form class="form-horizontal" action="customerestimates.php?view=challan_generated" method="post" id="inv_form" enctype="multipart/form-data">
					<input type="hidden" name="estimate_id" name="estimate_id" value="'.$rowstd['estimate_id'].'">
					<input type="hidden" id="payment_method" name="payment_method" value="1">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'customerestimates.php?view=challan_generated\'"><span>close</span></button> 
							<h4 class="modal-title" style="font-weight:700;"> Manual Payment Verification</h4>
						</div>

						<div class="modal-body">

							<div class="col-sm-32">
								<div class="form_sep">
									<label class="req">Estimate #</label>
									<input type="text" class="form-control" id="estimate_no" name="estimate_no" value="'.$rowstd['estimate_no'].'" readonly>
								</div> 
							</div>
							
							<div class="col-sm-32">
								<div class="form_sep">
									<label class="req">Dated</label>
									<input type="text" class="form-control" id="dated" name="dated" required value="'.$rowstd['estimate_date'].'" readonly>
								</div> 
							</div>
							
							<div class="col-sm-61">
								<div class="form_sep">
									<label class="req">Customer Name </label>
									<input type="text" class="form-control" id="customername" name="customername" required value="'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].'" readonly>
								</div> 
							</div>
							
							<div style="clear:both;padding:5px;"></div>

							<div class="col-sm-32">
								<div class="form_sep">
									<label>ADE Name</label>
									<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>ADE Phone #</label>
									<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>Current Bill </label>
									<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['total_amount']).'" readonly>
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>Company Name</label>
									<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
								</div> 
							</div>
	
							<div style="clear:both;padding:5px;"></div>

							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Advance</label>
									<input type="text" class="numbers form-control" id="advance" name="advance" required autocomplete="off" onblur="numberWithCommas(this)"  autofocus tabindex="1">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Paid Date</label>
									<input type="text" class="form-control pickdmy" id="paid_date" name="paid_date" value="" tabindex="2" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Account #</label>
									<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off" tabindex="4">
										<option value="">Select Account</option>';
											foreach($bankAccounts as $account) { 
												if (in_array($account['id'], [7, 8])) :
													echo '<option value="'.$account['id'].'">'.$account['bank'].' - '.$account['acc_number'].'</option>';
												endif;
											}
									echo'
									</select>
								</div> 
							</div>
							<div class="col-sm-25">
								<div class="form_sep">
									<label class="req">Deposit/Receipt #</label>
									<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" value="" tabindex="5" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
								<label class="req">Attach Receipt</label>
								<input id="assign_file" name="assign_file" class="btn btn-mid btn-primary clearfix" type="file" onChange="filevalidate(this.value)"> 
								<div style="font-weight:700;">File extension: (<span style="color:blue; font-weight:700;">jpg,jpeg, gif, png, pdf</span>)</div>
								</div>
							</div>

							<div style="clear:both;"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php?view=challan_generated\'">Closed</button>
							<button type="submit" class="btn btn-info" id="submit_manualpayment" name="submit_manualpayment" onClick=\'return confirmSubmit()\'> Manual Payment </button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script type="text/javascript">
			function numberWithCommas(field) {
				let element = document.getElementById(field.id);
				let amount = element.value.replace(/,/g, \'\');
				if(amount.charAt(0)==\'-\'){
					amount = \'-\'+amount.substring(1).replace(/-/g, \'\');
				}else{
					amount = amount.replace(/-/g, \'\');
				}
				element.value = amount.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
			}
			function confirmSubmit() {
				var agree=confirm("Are you sure you wish to continue?");
				if (agree)
				return true ;
				else
				return false ;
			}

			function filevalidate(file) {
				var ext = file.split(".");
				ext = ext[ext.length-1].toLowerCase();      
				var arrayExtensions = ["jpg" , "jpeg", "pdf", "gif", "png"];

				if (arrayExtensions.lastIndexOf(ext) == -1) {
					alert("Wrong extension type, please attach valid file.");
					$("#assign_file").val("");
				}
			}
			
			$().ready(function() {
				
				$("#inv_form").validate({
					rules: {
						advance			: "required",
						paid_date		: "required",
						id_account		: "required",
						deposit_slip	: "required",
						assign_file		: "required",
					},
					messages: {
						advance			: "This field is required",
						paid_date		: "This field is required",
						id_account		: "This field is required",
						deposit_slip	: "This field is required",
						assign_file		: "This field is required"
					},
					submitHandler: function(form) {
					form.submit();
					}
				});
			});// Elements
		</script>';
	} else {
		echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
		
	}
}