<?php 
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	if(($srch)) { 
		$sql2 		.= " AND (c.customer_name LIKE '%".$srch."%' 
							OR c.customer_cellno LIKE '".$srch."')";
		$sqlstring	.= "&srch=".$srch."";
	}

	echo '<title>Manage Customers Ledger  - '.TITLE_HEADER.'</title>
	<div class="matter">
		<div class="widget headerbar-widget">
			<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="images/default.png" alt=""/></div>
			<div class="headerbar-project-title pull-left">
				<h3>'.$_SESSION['userlogininfo']['LOGINNAME'].' - Welcome Back</h3>
			</div>
			<div class="dashboard-user-group pull-right">
				<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINNAME'].'</label>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="container">
			<div class="row fullscreen-mode">
				<div class="col-md-12">';
					if(isset($_SESSION['msg'])) { 
						echo $_SESSION['msg']['status'];
						unset($_SESSION['msg']);
					}	
					// get Credit Debit Payments of Customer
					$receivablesconditions = array ( 
												'select' 	=> "".CUSTOMERS.".customer_id, 
																SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
																SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
												'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
												'where' 	=> array( 
																	''.PAYMENTS.'.status' => 1 
																	, ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
																), 
												'return_type' 	=> 'single' 
											); 
					$valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $receivablesconditions);
					echo '
					<div class="row mb-none-30 mt-10">
						<div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
						</div>

					<div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
							<div class="dashboard-w1 bg--success b-radius--10 box-shadow">
								<div class="icon">
									<i class="fa fa-credit-card"></i>
								</div>
								<div class="details">
									<div class="numbers">
										<span class="amount" style="font-size:30px;">'.number_format(($valuedebitcrdit['TotalDebit'])).'</span>
									</div>
									<div class="desciption">
										<span class="text--small" style="font-size:20px;">Total Payable</span>
									</div>
								</div>
							</div>
						</div>
						<!-- dashboard-w1 end -->
					<div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
							<div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
								<div class="icon">
									<i class="fa fa-money"></i>
								</div>
								<div class="details">
									<div class="numbers">
										<span class="amount" style="font-size:30px;">'.number_format($valuedebitcrdit['TotalCredit']).'</span>
									</div>
									<div class="desciption">
										<span class="text--small" style="font-size:20px;">Total Paid</span>
									</div>
									
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
							<div class="dashboard-w1 bg--orange b-radius--10 box-shadow ">
								<div class="icon">
									<i class="fa fa-money"></i>
								</div>
								<div class="details">
									<div class="numbers">
										<span class="amount" style="font-size:30px;">'.number_format(($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit'])).'</span>
									</div>
									<div class="desciption">
										<span class="text--small" style="font-size:20px;">Blanace</span>
									</div>

									
								</div>
							</div>
						</div>
						<!-- dashboard-w1 end -->


					</div>

					<div class="widget">
						<div class="widget-content">';

							$totalqty 		= 0;

							$srno 			= 0;
							$totalcredit 	= 0;
							$totaldebit 	= 0;
							$balance 		= 0;
							$invoiceno		= '';

							$payconditions = array ( 
														'select' 	=> "".PAYMENTS.".dated, ".PAYMENTS.".amount, ".PAYMENTS.".amount, ".PAYMENTS.".reference_no, 
																		".PAYMENTS.".receipt_no, ".PAYMENTS.".docs_types, ".PAYMENTS.".debit_credit, ".PAYMENTS.".remarks",
														'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
														'where' 	=> array( 
																			''.PAYMENTS.'.ledgerfor' 	=> 1
																			, ''.PAYMENTS.'.status' 	=> 1 
																			, ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
																		), 
														'order_by' 		=> ''.PAYMENTS.'.id ASC, '.PAYMENTS.'.dated ASC ',
														'return_type' 	=> 'all' 
													); 
							$Payments 	= $dblms->getRows(PAYMENTS, $payconditions);


							if(!empty($Payments)) {
								
								echo '
								<div style=" float:right; text-align:right; margin:10px;"> 
									<a class="btn btn-sm btn-danger" href="customerpaynow.php"><i class="icon-money"></i> Online Pay </a> 
									<a class="btn btn-sm btn-info" href="customerledgerprint.php" target="_blank"><i class="icon-print"></i> Print Ledger </a>
								</div>
								<div style="clear:both;"></div>
									<table class="table table-bordered table-hover">
										<thead>
											<tr>

												<th style="text-align:center; font-weight:bold;">Sr #</th>
												<th style="text-align:left; font-weight:bold;">Date</th>
												<th style="text-align:left; font-weight:bold;">Invoice #</th>
												<th style="text-align:left; font-weight:bold;">Detail</th>
												<th style="text-align:center; font-weight:bold;">Debit</th>
												<th style="text-align:center; font-weight:bold;">Credit</th>
												<th style="text-align:center; font-weight:bold;">Balance</th>
											</tr>
										</thead>
										<tbody>';
											foreach($Payments as $rowbills) {
												$srno++;
												if($rowbills['debit_credit'] == 2) {
													$debit 		= $rowbills['amount'];
													$debitdisp 	= number_format($rowbills['amount']);
												} else {
													$debit 		= 0;
													$debitdisp 	= '---';
												}
													
												if($rowbills['debit_credit'] == 1) {
													$credit 	= $rowbills['amount'];
													$creditdisp = number_format($rowbills['amount']);
												} else {
													$credit 	= 0;
													$creditdisp = '----';
												}
												$balance = ($balance + ($debit - $credit));

												// Sale Invoice
												if($rowbills['docs_types'] == 2) {
													
													if($rowbills['reference_no']<9) {
														$Invoiceno = 'INV-00000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99) {
														$Invoiceno = 'INV-0000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<999) {
														$Invoiceno = 'INV-000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<9999) {
														$Invoiceno = 'INV-00'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99999) {
														$Invoiceno = 'INV-0'.($rowbills['reference_no']);
													} else {
														$Invoiceno = 'INV-'.($rowbills['reference_no']);
													}
													
													$invoiceno = '<a class="links-blue" style="font-weight:600;" href="saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$Invoiceno.'</a>';
													
												}elseif($rowbills['docs_types'] == 3) {
													// Sale Returns
													
													$returnconditions 	= array ( 
																				'select' 		=> 'job_order_no',
																				'where' 		=> 	array ( 
																											'job_order_id' => cleanvars($rowbills['reference_no'])
																										), 
																				'limit' 		=> 1,
																				'return_type' 	=> 'single' 
																			); 
													$rowreturn 	= $dblms->getRows(SALES_RETURNS, $returnconditions);
													
													if($rowbills['reference_no']<9) {
														$orderno = 'SR-00000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99) {
														$orderno = 'SR-0000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<999) {
														$orderno = 'SR-000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<9999) {
														$orderno = 'SR-00'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99999) {
														$orderno = 'SR-0'.($rowbills['reference_no']);
													}else {
														$orderno = 'SR-'.($rowbills['reference_no']);
													}

													
													$invoiceno = '<a class="links-blue" style="font-weight:600;color: orangered;"  href="salesreturnprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$orderno.'</a>';
													
												}else {
													$invoiceno = $rowbills['receipt_no'];
												}

												echo '
												<tr>
													<td style="text-align:center; width:50px;">'.$srno.'</td>
													<td style="text-align:left; width:80px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
													<td style="text-align:left;width:100px;">'.$invoiceno.'</td>
													<td style="text-align:left;">'.$rowbills['remarks'].'</td>
													<td style="text-align:right; width:90px;">'.$debitdisp.'</td>
													<td style="text-align:right; width:90px;">'.$creditdisp.'</td>
													<td style="text-align:right; width:90px;">'.number_format($balance).'</td>
												</tr>';

												$totalcredit 	= ($totalcredit+ $credit);
												$totaldebit 	= ($totaldebit+ $debit);
											}
											echo '
										</tbody>
										<thead>
											<tr>
												<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
												<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totaldebit).'</th>
												<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totalcredit).'</th>
												<th style="text-align:right; font-weight:bold; font-size:16px !important;background-color: mistyrose; color:#f00;">'.number_format($balance).'</th>
											</tr>';
											echo '
										</thead>
									</table>';


							} else {
	
								echo '
								<div class="col-lg-12">
									<div class="widget-tabs-notification">No Result Found</div>
								</div>';

							}
							echo '
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
</div>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';

echo '
<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script type="text/javascript" src="js/data.js"></script>
<!--JS_SELECT_LISTS-->
<script>
    $("#id_customer").select2({
        allowClear: true
    });	

	$("#custom_customer").select2({
        allowClear: true
    });
	$("#id_account_edit").select2({
        allowClear: true
    });
	$("#method").select2({
        allowClear: true
    });
	
	$("#id_bank").select2({
        allowClear: true
    });
	
	$("#id_paid_edit").select2({
        allowClear: true
    });
	$("#method_edit").select2({
        allowClear: true
    });
	
	$("#idbrand").select2({
        allowClear: true
    });

	$("#method-list").select2({
        allowClear: true
    });
	
	$("#customer-list").select2({
        allowClear: true
    });
</script>

<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
