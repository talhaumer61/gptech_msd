<?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
	
	if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '1', 'edit' => '1'))) { 
			
		$conditions = array ( 
									'select' 	=> ''.JOB_ORDER.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
													'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name, '.PAYMENTS.'.receipt_no',
									'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer 
													INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
													INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade 
													LEFT JOIN ".PAYMENTS." ON ".PAYMENTS.".transaction_id =  ".JOB_ORDER.".deposit_slip",
									'where' => array( 
														''.JOB_ORDER.'.job_order_id' 	=> cleanvars($_GET['id'])
													), 
									'limit' 		=> 1,
									'return_type' 	=> 'single' 
								); 
		$rowstd 	= $dblms->getRows(JOB_ORDER, $conditions);
		// check invoice	
		$Invconditions = array ( 
									'select' 		=> 'salesinvoice_id, salesinvoice_no',
									'where' 		=> array ( 
																'id_joborder' => cleanvars($rowstd['job_order_id']) 
															), 
									'group_by' 		=> 'id_joborder',
									'limit' 		=> 1,
									'return_type' 	=> 'count' 
								); 
		$rowbills 	= $dblms->getRows(SALES_INVOICE, $Invconditions);
		
		if(($rowstd['job_order_status'] == 1 || $rowstd['job_order_status'] == 2) && $rowbills == 0){
			$canEdit = 1;
		} else {
			$canEdit = 0;
		}
	
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="customerorders.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
					<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['id_customer'].'">
					<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
					<input type="hidden" id="id_company" name="id_company" value="'.$rowstd['company_id'].'">
					<input type="hidden" id="customer_openingbalance" name="customer_openingbalance" value="'.$rowstd['opening_balance'].'">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'customerorders.php\'"><span>close</span></button> 
							<h4 class="modal-title" style="font-weight:700;"> Edit Job Order Detail</h4>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-4">
									<div class="form_sep">
										<label class="req">Job Order #</label>
										<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="'.($rowstd['job_order_no']).'" readonly>
									</div> 
								</div>
								<div class="col-md-4">
									<div class="form_sep">
										<label class="req">Dated</label>
										<input type="text" class="form-control" id="dated" name="dated" required value="'.($rowstd['dated']).'" readonly>
									</div> 
								</div>
								<div class="col-md-4">
									<div class="form_sep">
										<label class="req">Customer Name</label>
										<input type="text" class="form-control" id="customer_name" name="customer_name" value="'.($rowstd['customer_name']).'" readonly>
									</div> 
								</div>
							</div>

							<div class="row" style="clear:both;padding:5px;">

								<div class="col-md-3">
									<div class="form_sep">
										<label>ADE Name</label>
										<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
									</div> 
								</div>

								<div class="col-md-3">
									<div class="form_sep">
										<label>ADE Phone #</label>
										<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
									</div> 
								</div>

								<div class="col-md-3">
									<div class="form_sep">
										<label>Opening Balance</label>
										<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['opening_balance']).'" readonly>
									
									</div> 
								</div>

								<div class="col-md-3">
									<div class="form_sep">
										<label>Company Name</label>
										<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
									</div> 
								</div>
							</div>
							
							<div class="row" style="clear:both;padding:5px;">

								<div class="col-md-2">
									<div class="form_sep">
										<label>Freight Charges</label>
										<input type="text" class="numbers form-control" id="freight_charges" name="freight_charges" value="'.number_format($rowstd['freight_charges']).'" required autocomplete="off" >
									</div> 
								</div>

								<div class="col-md-2">
									<div class="form_sep">
										<label class="req">Advance</label>
										<input type="text" class="form-control" id="advance" name="advance" value="'.$rowstd['advance'].'" min="0" readonly required autocomplete="off">
									</div> 
								</div>

								<div class="col-md-2">
									<div class="form_sep">
										<label class="req">Paid Date</label>
										<input type="text" class="form-control" id="paid_date" name="paid_date" readonly value="'. date('d-m-Y', strtotime(cleanvars($rowstd['paid_date']))).'" required autocomplete="off">
									</div> 
								</div>
								
								<div class="col-md-3">
									<div class="form_sep">
										<label class="req">Payment Method</label>
										<select id="payment_method" class="select2" name="payment_method" onchange="get_paymethoddetail(this.value)" style="width:100%" required autocomplete="off" disabled>
											<option value="">Choose Method</option>';
												foreach($pay_types as $paymode) { 
													echo '<option value="'.$paymode['id'].'"';if($paymode['id'] == $rowstd['paid_method']){echo' selected';} echo'>'.$paymode['name'].'</option>';
												}
											echo'
										</select>
									</div> 
								</div>

								<div id="getpaymethoddetail">';
								
									if($rowstd['paid_method'] == 1){

										echo ' 
										<div class="col-md-3">
											<div class="form_sep">
												<label class="req">Account #</label>
												<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off" disabled>
													<option value="">Select Account</option>';
														foreach($bankAccounts as $account) { 
															echo '<option value="'.$account['id'].'"';if($account['id'] == $rowstd['id_account']){echo' selected';} echo'>'.$account['bank'].' - '.$account['acc_number'].'</option>';
														}
												echo'
												</select>
											</div> 
										</div>
										<script>
											$("#id_account").select2({
												allowClear: true
											});			
										</script>';
										

									} else{

										echo '
										<div class="col-md-3">
											<div class="form_sep">
												<label class="req">Deposit/Receipt #</label>
												<input type="text" class="form-control" id="receipt_no" name="receipt_no" value="'.$rowstd['receipt_no'].'" readonly required autocomplete="off">
											</div> 
										</div>';

									}
									echo '
								</div>
							</div>
	
							<div style="clear:both; padding:5px;"></div>

							<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;font-weight:600;"> 
								Item Details
							</div>	
							<div style="clear:both;padding:5px;"></div>	
							<table class="footable table table-bordered table-hover invE_table footable-loaded">
								<thead>
									<tr>
										<th style="text-align:center;">Sr #</th>
										<th style="text-align:left;">Items </th>
										<th style="text-align:center;">Avaiable Stock</th>
										<th style="text-align:center;">Unit Price</th>
										<th style="text-align:center;">Discount %</th>
										<th style="text-align:center;">Qty</th>
										<th style="text-align:center;">Total</th>
									</tr>
								</thead>
								<tbody>';
									$POconditions = array ( 
																'select' 	=> '*',
																'where' => array( 
																					'id_job_order' => cleanvars($_GET['id'])
																				), 
																'return_type' 	=> 'all' 
															); 
									$podetails 	= $dblms->getRows(JOB_ORDER_DETAILS, $POconditions);
									
									$i     = 0;
									$total = 0 ;
									foreach($podetails as $rowsdet) {
										$total = $total +$rowsdet['total_price']; 
										
										$Stockconditions = array ( 
																	'select' 	=> "SUM(CASE WHEN stock_type = '1' then qty end) as TotalInQTY, 
																					SUM(CASE WHEN stock_type = '2' then qty end) as TotalOutQTY",
																	'where' => array( 
																						'id_item' => cleanvars($rowsdet['id_item'])
																					), 
																	'return_type' 	=> 'single' 
																); 
										$resulttotalInOut 	= $dblms->getRows(STOCK, $Stockconditions);
										

										$avaiablestock = ($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']);
										
										$i++;
										echo'
										<tr class="inv_row">
											<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
											<td>
												<input type="hidden" class="form-control col-lg-12" name="id_item['.$i.']" id="id_item_'.$i.'" value="'.$rowsdet['id_item'].'" >
												<select id="item_name_'.$i.'" name="item_name['.$i.']" class="select2" style="width:100%" autocomplete="off" onchange="getPrdValue(this.value, '.$i.')" disabled>
													<option value=""></option>';
													foreach($Items as $arrayitem) {
														if($arrayitem['item_id'] == $rowsdet['id_item']){
															$selected = 'selected';
														} else {
															$selected = '';
														}
											
														echo '
														<option value="'.$arrayitem['item_id'].'" '.$selected.'>'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
													}
												echo'
												</select>
											</td>
											<td style="width:100px;">
												<input type="text" class="form-control col-lg-12" name="stock_qty['.$i.']" id="stock_qty'.$i.'" value="'.$avaiablestock.'" style="text-align:center; color:#00f; font-size:16px !important;  font-weight:600;" readonly>
											</td>
											<td style="width:85px;">
												<div id="getPrdValue_'.$i.'">
													<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">
												</div>		
												
											</td>
											<td  style="width:80px;">
												<input type="text" class="form-control col-lg-12 jQinv_item_discount" name="discount_percentage['.$i.']" id="discount_percentage'.$i.'" value="'.$rowsdet['discount'].'" autocomplete="off"  style="text-align:center; font-weight:600;">
											</td>
											<td style="width:70px;">
												<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'" min="1" max="'.$avaiablestock.'" style="text-align:center; font-weight:600;">';
												if($rowsdet['total_qty'] > $avaiablestock){
													echo '<label for="total_qty_'.$i.'" class="jquery-validation-error">Please enter a value less than or equal	to '.$avaiablestock.'.</label>';
												}
												echo '
											</td>
											
											
											<td style="width:100px;">
												<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
											</td>
										</tr>
										<script>
											$("#item_name_'.$i.'").select2({
												allowClear: true
											});
										</script>';	
									}

									echo'
									<tr class="last_row">
										<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
											<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$total.'</span></span></b></p>
											<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span>'.$rowstd['grand_total'].'</span></span></b></p>
											<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$total.'">
											<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="'.$rowstd['grand_total'].'">
										</td>
									</tr>
								</tbody>	
							</table>
							<div style="clear:both;"></div>
						</div>

						<div class="modal-footer">';
							if($canEdit == 1 ){
								echo ' 
								<button type="submit" class="btn btn-primary" value="saveforward" id="bill_changes" name="bill_changes" onClick=\'return confirmSubmit()\'>Save &amp; Send to Sales Department</button>';
							}
							echo '
							<button type="button" class="btn btn-default" onclick="location.href=\'customerorders.php\'" >Cancel</button>
						</div>

					</div>
				</form>
				<!--JS_SELECT_LISTS-->
				<script src="js/sales.js"></script>

				<script type="text/javascript">
					<!--
					function confirmSubmit() {
						var agree=confirm("Are you sure you wish to continue?");
						if (agree)
						return true ;
						else
						return false ;
						}
					// -->
					$("#payment_method").select2({
						allowClear: true
					});
					$().ready(function() {
						$("#inv_form").validate({
							submitHandler: function(form) {
							form.submit();
							}
						});
					});
					function getPrdValue(id_item, srno) {  
						$.ajax({  
							type: "POST",  
							url: "include/ajax/getPrdValue.php",  
							data: "id_item="+id_item+"&srno="+srno,  
							success: function(msg){  
								$("#getPrdValue_"+srno).html(msg); 
							}
						});  
					}
				</script>
			</div>
		</div>
	</div>';
	} else {
		echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
		
	}
}