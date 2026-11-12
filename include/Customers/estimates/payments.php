<?php                                                   
if(LMS_VIEW == 'payments' && isset($_GET['id'])) { 
	$conditions = array ( 
							'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
											'.CUSTOMERS.'.customer_personcell, '.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_email, 
											'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, 
											'.ADES.'.ade_name, '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
							'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
											INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
											INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
							'where' 	=> array ( 
														''.ESTIMATES.'.estimate_id' 	=> cleanvars($_GET['id'])
													, ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
												), 
							'limit' 		=> 1,
							'return_type' 	=> 'single' 
						); 
    $rowstd 	= $dblms->getRows(ESTIMATES, $conditions);

	if($rowstd['estimate_status'] == 1){
		$canEdit = 1;
	} else {
		$canEdit = 0;
	}
	
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
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%">
			<form class="form-horizontal" action="'.SITE_URL.'/PayFast/" method="post" id="inv_form" enctype="multipart/form-data">
				<input type="hidden" name="estimate_id" name="estimate_id" value="'.$rowstd['estimate_id'].'">
				<input type="hidden" name="customer_email" name="customer_email" value="'.$emailaddress.'">
				<input type="hidden" name="customer_cellno" name="customer_cellno" value="'.$cellno.'">
				<input type="hidden" name="customer_id" name="customer_id" value="'.$rowstd['customer_id'].'">
				<input type="hidden" name="customer_name" name="customer_name" value="'.$rowstd['customer_name'].'">
				<input type="hidden" name="control" name="control" value="estimatepayment">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
						<h4 class="modal-title" style="font-weight:700;"> Order Payment Detail</h4>
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
								<label>Company Name</label>
								<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
							</div> 
						</div>
						<div class="col-sm-32">
							<div class="form_sep">
								<label>Opening Balance</label>
								<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
							</div> 
						</div>

						<div style="clear:both;padding:5px;"></div>

						<div class="row" style="clear:both;padding:10px;" id="payment">
							<div class="col-md-12">
								<table class="footable table table-bordered">
									<thead>
										<tr>
											<th colspan="5" style="text-align:center;">Payment Details</th>
										</tr>
										<tr>
											<th style="text-align:center;">Previous Balance</th>
											<th style="text-align:center;">This Order Amount</th>
											<th style="text-align:center;">Total Payable Amount</th>	
											<th style="text-align:center;">'.($rowstd['estimate_status'] == '5' ? 'Pay Approved Amount' : 'Pay Total Amount' ).'</th>';
											if($rowstd['estimate_status'] != '5'){
												echo '<th style="text-align:center;">Pay Other Amount</th>';
											}
											echo '
										</tr>
									</thead>
									<tbody>
										<tr>
											<th style="text-align:center;vertical-align: middle;">
												<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
											</th>
											<th style="text-align:center;vertical-align: middle;">
												<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['estimate_total']).'" readonly>
											</th>
											<th style="text-align:center;vertical-align: middle;">
												<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['estimate_total'] + $openingbalance).'" readonly>
											</th>
											<th style="text-align:center;vertical-align: middle;">';	
												if($rowstd['estimate_status'] != '5'){
													echo '
														<input id="fullpayment" name="payamount" type="radio" style="height:20px; width: 20px;" value="'.($rowstd['estimate_total'] +$openingbalance).',1" class="checkbox-inline" required> 
														<input id="totalPayable" name="totalPayable" type="hidden" value="'.($rowstd['estimate_total'] +$openingbalance).'" required> ';
												}else{
													echo '
													<input id="fullpayment" name="payamount" type="radio" style="height:20px; width: 20px;" value="'.$rowstd['approved_amount'] .',1" class="checkbox-inline" checked required> 
													<input id="totalPayable" name="totalPayable" type="hidden" value="'.$rowstd['approved_amount'].'" required> 
													<b><span style="color:#00f;">'.$rowstd['approved_amount'].'</span></b>';
												}
												echo'		
											</th>';
											if($rowstd['estimate_status'] != '5'){
												echo '
												<th style="width:150px;color:orangered; font-weight:600; text-align:center;">
													<input id="otheramnt" name="payamount" type="radio" style="height:20px; width: 20px;" class="checkbox-inline" required> 
												</th>';
											}
											echo '
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row" style="clear:both;padding:10px; display:none;" id="request">
							<div class="col-md-12">
								<table class="footable table table-bordered">
									<thead>
										<tr>
											<th colspan="4" style="text-align:center;">Generate Payment Request</th>
										</tr>
										<tr>
											<th style="text-align:center;">Want To Pay</th>
											<th style="text-align:center;">Payment Percentage</th>
											<th style="text-align:center;">Remaining Payment Date</th>
											<th style="text-align:center;">Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th style="text-align:center;vertical-align: middle;">
												<input type="text" class="form-control" name="request_amount" id="request_amount" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="0" min="1" required>
											</th>
											<th style="color:orangered; font-weight:600; text-align:right;">
												<input type="text" class="form-control" name="percentage" id="percentage" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="0%" readonly>
											</th>
											<th style="width:230px; color:orangered; font-weight:600; text-align:right;">
												<input type="text" class="form-control pickadate" id="date_remaining_payment" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" name="date_remaining_payment" autocomplete="off" required>
											</th>
											<th style="width:130px;color:orangered; font-weight:600; text-align:right;">
												<button class="btn btn-primary btn-block" id="submit_request" name="submit_request">Request</button>
											</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div style="clear:both; padding:5px;"></div>

						<div style="clear:both;"></div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php\'">Closed</button>
						<button type="submit" class="btn btn-info" value="savepayment" id="submit_paynow" name="submit_paynow" onClick=\'return confirmSubmit()\'> Generate Challan </button> 
					</div>
				</div>
			</form>

			<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">Order Detail</div>

			<table class="footable table table-bordered invE_table footable-loaded">
				<thead>
					<tr>
						<th style="text-align:center;">Sr #</th>
						<th style="text-align:left;">Item Code </th>
						<th style="text-align:left;">Item Name </th>		
						<th style="text-align:center;">Qty</th>
						<th style="text-align:center;">Unit Price</th>
						<th style="text-align:center;">Total</th>
					</tr>
				</thead>
				<tbody>';
					$POconditions = array ( 
											'select' 		=> ''.ESTIMATES_DETAIL.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name'
											, 'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".ESTIMATES_DETAIL.".id_item"
											, 'where' 		=> array( 
																			''.ESTIMATES_DETAIL.'.id_estimate' => cleanvars($_GET['id'])
																	)
											, 'order_by' 	=> ''.ESTIMATES_DETAIL.'.id ASC' 
											, 'return_type' => 'all' 
										); 
					$podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);
					$i				= 0;
					$total 			= 0 ;
					$estimatetotal 	= 0 ;
					
					foreach($podetails as $rowsdet) {

						$i++;
						echo'
						<tr class="inv_row">
							<td class="inv_clone_row" style="width:50px;text-align:center;vertical-align: middle;"><span class="footable-toggle"></span>'.$i.'</td>
							<td style="width:80px; text-align:center;vertical-align: middle;">'.$rowsdet['item_code'].'</td>
							<td style="vertical-align: middle;">'.$rowsdet['item_name'].'</td>
							<td style="width:100px;color:#00f; font-weight:600; text-align:center;">'.$rowsdet['qty'].'</td>	
							<td style="width:100px;text-align:center; color:#00f; font-weight:600; font-size:14px !important;">'.$rowsdet['unit_price'].'</td>
							<td style="width:130px;color:orangered; font-weight:600; text-align:right;">'.number_format($rowsdet['total_price']).'</td>
						</tr>';	
					}

					echo'
					<tr class="last_row">
						<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
							<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.number_format($rowstd['estimate_total']).'</span></span></b></p>
						</td>
					</tr>
				</tbody>	
			</table>
		</div>
	</div>
	<script>
		document.addEventListener(\'DOMContentLoaded\', function () {
			// Get radio buttons, request div, and the Pay Now button
			const fullPayment = document.getElementById(\'fullpayment\');
			const otherAmount = document.getElementById(\'otheramnt\');
			const requestDiv = document.getElementById(\'request\');
			const payNowButton = document.getElementById(\'submit_paynow\');

			// Function to toggle request div and Pay Now button
			function toggleElements() {
				if (otherAmount.checked) {
					requestDiv.style.display = \'block\'; // Show the request div
				} else {
					requestDiv.style.display = \'none\'; // Hide the request div
				}

				// Enable Pay Now button if either radio is checked
				if (fullPayment.checked) {
					payNowButton.disabled = false;
				} else {
					payNowButton.disabled = true;
				}
			}

			// Add event listeners to radio buttons
			fullPayment.addEventListener(\'change\', toggleElements);
			otherAmount.addEventListener(\'change\', toggleElements);

			// Set the initial state
			toggleElements();
		});

		// Elements
		const requestAmountInput = $(\'#request_amount\');
		const percentageInput = $(\'#percentage\');
		const totalPayable = parseFloat($(\'#totalPayable\').val()) || 0;

		// Event listener for changes in the request_amount input
		requestAmountInput.on(\'input\', function () {
			const enteredAmount = parseFloat($(this).val()) || 0; // Safely parse the entered value
			let percentage = 0;

			if (enteredAmount > 0) {
				percentage = ((enteredAmount / totalPayable) * 100).toFixed(2); // Calculate percentage
			}

			percentageInput.val(percentage + \'%\'); // Display the result
		});

		$(\'#submit_request\').click(function(event) {
			event.preventDefault(); // Prevent the default action

			// Display confirmation dialog
			var agree = confirm("Are you sure you wish to continue?");
			if (!agree) {
				return; // Stop further execution if user clicks "No"
			}

			// Get the form element
			var $form = $(\'#inv_form\');

			// Optionally update the form action
			$form.attr(\'action\', \'customerestimates.php\'); // Set the action URL if needed

			// Create and append hidden inputs for the request data
			$form.append(\'<input type="hidden" name="submit_request">\');

			// Submit the form
			$form.submit();
		});

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
		});
		function confirmSubmit() {
			var agree=confirm("Are you sure you wish to continue?");
			if (agree)
				return true ;
			else
				return false ;
		}
	</script>';
}