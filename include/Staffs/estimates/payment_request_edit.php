<?php 
if(isset($_GET['id']) && LMS_VIEW == 'payment_request_edit') {

	if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '39', 'edit' => '1'))) { 

		$conditions = array ( 
									'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
													'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
									'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
													INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
													INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
									'where' 	=> array ( 
															''.ESTIMATES.'.estimate_id' 		=> cleanvars($_GET['id']),
															''.ESTIMATES.'.estimate_status' 	=> '4'
														), 
									'limit' 		=> 1,
									'return_type' 	=> 'single' 
								); 
		$rowstd 	= $dblms->getRows(ESTIMATES, $conditions);

		if($rowstd['customer_email']){
			$emailaddress = $rowstd['customer_email'];
		} else {
			$emailaddress = $rowstd['customer_code'].'@mes.edu.pk';
		}
		
		if($rowstd['customer_personcell']) {
			$cellno = $rowstd['customer_personcell'];
		} else {
			$cellno = SALES_CELLNO;
		}

		// REQUEST PAYMENT REMARKS
		$requestremarksconditions = array ( 
											'select' 		=> ''.REQUEST_PAYMENT_REMARKS.'.*, '.ADMINS.'.adm_fullname',
											'join' 			=> "INNER JOIN ".ADMINS." ON ".ADMINS.".adm_id =  ".REQUEST_PAYMENT_REMARKS.".id_director",
											'where' 		=> array ( 
																		  ''.REQUEST_PAYMENT_REMARKS.'.id_estimate' => cleanvars($rowstd['estimate_id'])
																		, ''.REQUEST_PAYMENT_REMARKS.'.is_deleted'  => '0'
																	), 
											'return_type' 	=> 'all' 
										); 
		$valuerequestremarks 	= $dblms->getRows(REQUEST_PAYMENT_REMARKS, $requestremarksconditions);
		// CURRENT DIRECTOR REMARKS EXIST
		$check = array_filter($valuerequestremarks, function($item) {
			return isset($item['id_director']) && $item['id_director'] === $_SESSION['userlogininfo']['LOGINIDA'];
		});

		// EDIT RIGHTS
		if($rowstd['estimate_status'] == 4 && !$check && $_SESSION['userlogininfo']['LOGINIDA'] !='2'){
			$canEdit = '<button type="submit" class="btn btn-warning" value="savehold" id="submit_director_remarks" name="submit_director_remarks" onClick=\'return confirmSubmit()\'> Director Remarks </button> ';
			$action  = 'customerestimates.php';
		} else if($_SESSION['userlogininfo']['LOGINIDA'] =='2' ){
			$canEdit = '<button type="submit" class="btn btn-info" value="savepayment" id="submit_paynow" name="submit_paynow" onClick=\'return confirmSubmit()\'> Generate Challan </button>';
			$action  = SITE_URL.'/PayFast/';
		}else{
			$canEdit = '';
			$action  = '';
		}
		// OPENING BALANCE
		$debitcreditconditions = array ( 
									'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
														SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
									'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
									'where' 		=> array ( 
																''.PAYMENTS.'.status' => 1
																, ''.PAYMENTS.'.id_user' => cleanvars($rowstd['customer_id'])
															), 
									'return_type' 	=> 'single' 
								); 
		$valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);

		$openingbalance = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);

		// PERCENTAGE
		$percentage = ($rowstd['request_amount'] / ($rowstd['estimate_total'] + $openingbalance) * 100);
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%">
				<form class="form-horizontal" action="'.$action.'" method="post" id="inv_form" enctype="multipart/form-data">
					<input type="hidden" name="estimate_id" name="estimate_id" value="'.$rowstd['estimate_id'].'">
					<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['id_customer'].'">
					<input type="hidden" name="customer_email" name="customer_email" value="'.$emailaddress.'">
					<input type="hidden" name="customer_cellno" name="customer_cellno" value="'.$cellno.'">
					<input type="hidden" name="customer_id" name="customer_id" value="'.$rowstd['customer_id'].'">
					<input type="hidden" name="customer_name" name="customer_name" value="'.$rowstd['customer_name'].'">
					<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
					<input type="hidden" name="control" name="control" value="estimatepayment">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'customerestimates.php?view=payment_request\'"><span>close</span></button> 
							<h4 class="modal-title" style="font-weight:700;"> Edit Payment Request</h4>
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
									<label>Opening Balance</label>
									<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>Company Name</label>
									<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
								</div> 
							</div>

							<div style="clear:both;"></div>';
							echo '
							<div class="row" style="clear:both;margin-top:10px;margin-right:0px;">
								<div class="col-md-12">
									<table class="footable table table-bordered">
										<thead>
											<tr>
												<th style="text-align:center;">Previous Balance</th>
												<th style="text-align:center;">This Order Amount</th>
												<th style="text-align:center;">Total Payable Amount</th>	
												<th style="text-align:center;">Want To Pay</th>
												<th style="text-align:center;">Payment Percentage</th>
												<th style="text-align:center;">Remaining Amount</th>
												<th style="text-align:center;">Remaining Payment Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.number_format($openingbalance).'
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.number_format($rowstd['estimate_total']).'
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.number_format($rowstd['estimate_total'] + $openingbalance).'
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px; background-color:yellow">
													'.number_format($rowstd['request_amount']).'
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.number_format($percentage,2).'%
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.number_format(($rowstd['estimate_total'] + $openingbalance) - $rowstd['request_amount']).'
												</th>
												<th style="text-align:center;vertical-align: middle; font-weight:600; font-size:13px">
													'.$rowstd['date_remaining_payment'].'
												</th>
											</tr>
										</tbody>
									</table>
									<hr>
									<table class="footable table table-bordered">
										<thead>
											<tr><th colspan="6" style="text-align:center;font-weight:600; font-size:18px"> Director Remarks</th></tr>
											<tr>
												<th style="text-align:center;">Sr#</th>
												<th style="text-align:center;">Director</th>
												<th style="text-align:center;">Total Payable</th>	
												<th style="text-align:center;">Recomended Amount</th>	
												<th style="text-align:center;">%</th>
												<th style="text-align:center;">Remark / DD-MM-YYYY</th>
											</tr>
										</thead>
										<tbody>';
											foreach(PAYMENT_REQUEST_PERMISSIONS as $id){+
												$sr++;
												// ADMIN INFORMATION
												$adminsconditions = array ( 
																				'select' 		=> ''.ADMINS.'.adm_id, '.ADMINS.'.adm_fullname',
																				'where' 		=> array ( 
																											''.ADMINS.'.adm_id' => cleanvars($id)
																										), 
																				'return_type' 	=> 'single' 
																			); 
												$admin 	= $dblms->getRows(ADMINS, $adminsconditions);
												// GET REMARK							
												$remark = current(array_filter($valuerequestremarks, function($item) use ($admin) {
													return isset($item['id_director']) && $item['id_director'] === $admin['adm_id'];
												}));

												$remarkField 		= '';
												$amountField 		= '';
												$percentageField	= '';
												if($remark){
													$percentageField= number_format(($remark['amount'] / ($rowstd['estimate_total'] + $openingbalance) * 100), 2).'%';
													$remarkField	= $remark['director_remarks'].' / ' .date('d-m-Y H:i:s', strtotime($remark['date_added']));
													$amountField	= 'Rs '.$remark['amount'];
												}
												
												if((!$check && $admin['adm_id'] !='2' && $admin['adm_id'] == $_SESSION['userlogininfo']['LOGINIDA'] && !$remark) || ($admin['adm_id'] =='2'  && $admin['adm_id'] == $_SESSION['userlogininfo']['LOGINIDA'] && !$remark)){
													$maxValue = ($rowstd['estimate_total'] + $openingbalance);
													$remarkField	= '
																		<input type="text" class="form-control" id="director_remarks" name="director_remarks" value="" required>
																		<input type="hidden" id="id_director" name="id_director" value="'.$admin['adm_id'].'">';
													$amountField	= '
																		<input type="number" class="form-control" name="approved_amount" id="approved_amount" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" min="1" ' . ($maxValue >= 0 ? 'max="'.$maxValue.'"' : '') . ' autofocus required>';
													$percentageField = '
																		<input id="totalPayable" name="totalPayable" type="hidden" value="'.($rowstd['estimate_total'] +$openingbalance).'" required> 
																		<input type="text" class="form-control" name="percentage" id="percentage" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="0%" readonly>';
												}else{
													$remarkField 	= $remarkField;
													$amountField 	= $amountField;
													$percentageField= $percentageField;
												}
												echo '
												<tr>
													<td style="text-align:center;vertical-align: middle; width:50px;">'.$sr.'</td>
													<td style="vertical-align: middle; width:150px;">'.$admin['adm_fullname'].'</td>
													<td style="text-align:right;vertical-align: middle; width:155px;">Rs '.number_format($rowstd['estimate_total'] + $openingbalance).'</td>
													<td style="text-align:right;vertical-align: middle; width:155px;">'.$amountField.'</td>
													<td style="text-align:center;vertical-align: middle; width:150px;">'.$percentageField.'</td>
													<td>'.$remarkField.'</td>
												</tr>';
											}
											echo '
										</tbody>
									</table>
								</div>
							</div>
	
							<div style="clear:both;padding:5px;"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php?view=payment_request\'">Closed</button>'.$canEdit.'
							
						</div>
					</div>
				</form>
			</div>
		</div>

		<script type="text/javascript">
			function confirmSubmit() {
				var agree=confirm("Are you sure you wish to continue?");
				if (agree)
				return true ;
				else
				return false ;
			}
			$(".select2").select2({
				allowClear: true
			});
			$("#id_company_edit").select2({
				allowClear: true
			});
			$("#id_type").select2({
				allowClear: true
			});
			$().ready(function() {
				
				$("#inv_form").validate({
					rules: {
						company_name_edit		: "required",
						company_status_edit	: "required"
					},
					messages: {
						company_name_edit		: "This field is required",
						company_status_edit		: "This field is required"
					},
					submitHandler: function(form) {
					form.submit();
					}
				});
			});// Elements
			const approvedAmountInput = $(\'#approved_amount\');
			const percentageInput = $(\'#percentage\');
			const totalPayable = parseFloat($(\'#totalPayable\').val()) || 0;

			// Event listener for changes in the approved_amount input
			approvedAmountInput.on(\'input\', function () {
				const enteredAmount = parseFloat($(this).val()) || 0; // Safely parse the entered value
				let percentage = 0;

				if (enteredAmount > 0) {
					percentage = ((enteredAmount / totalPayable) * 100).toFixed(2); // Calculate percentage
				}

				percentageInput.val(percentage + \'%\'); // Display the result
			});
		</script>';
	} else {
		echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
		
	}
}