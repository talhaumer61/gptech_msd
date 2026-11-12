<?php 

if(!isset($_GET['id']) && LMS_VIEW == 'payment_request') {
	
	$adjacents = 3;
	if(!($Limit)) 	{ $Limit = 100; } 
	if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

	$sqlstring	= "&view=payment_request";
	if(isset($_GET['filter']) && $_GET['filter'] == 'all'){
		$search 	= 'AND e.estimate_status IN (4,6,7) '.$sql2.'';
		$sqlstring	.= "&filter=all";
	}else{
		$search = 'AND e.estimate_status IN (4) '.$sql2.'';
	}


		
	$conditions = array ( 
							  'select' 		=> 'e.estimate_id, COUNT(rem.id_director) remarkscount'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." c ON c.customer_id = e.id_customer
												LEFT JOIN ".REQUEST_PAYMENT_REMARKS." rem ON rem.id_estimate = e.estimate_id"
							, 'where' 		=> array( 
														'e.is_deleted' => 0 
													)
							// , 'not_equal' 		=> array( 
							// 							'e.request_amount' => 0 
							// 					   )
							, 'search_by' 	=> $search
							, 'group_by' 	=> 'e.estimate_id'
							, 'order_by' 	=> 'e.estimate_id DESC '
							, 'return_type' => 'count' 
						); 

	// if($_SESSION['userlogininfo']['LOGINIDA'] == '2' && $_GET['filter'] != 'all'){
	// 	$conditions['having'] = 'remarkscount = 2';
	// }
    $Estimates 	= $dblms->getRows(ESTIMATES. ' e', $conditions);

	
	$count 		= ($Estimates);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;						
	
	if (($count) > 0) { 
		
		$conditions = array ( 
								'select' 		=> 'e.estimate_id, e.estimate_no, e.estimate_total, e.voucher_no,
													e.id_customer, e.estimate_date, e.estimate_status,
													e.id_joborder, e.request_amount, e.approved_amount, c.customer_id, c.customer_code, 
													c.customer_cellno, c.customer_name, e.joborder_no, COUNT(rem.id_director) remarkscount'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." c ON c.customer_id = e.id_customer
													LEFT JOIN ".REQUEST_PAYMENT_REMARKS." rem ON rem.id_estimate = e.estimate_id"
								, 'where' 		=> array( 
															'e.is_deleted' => 0 
														) 
								// , 'not_equal' 	=> array( 
								// 							'e.request_amount' => 0 
								// 						) 
								, 'search_by' 	=> $search
								, 'group_by' 	=> 'e.estimate_id'
								, 'order_by' 	=> 'e.estimate_id DESC '
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
							); 
		// if($_SESSION['userlogininfo']['LOGINIDA'] == '2' && $_GET['filter'] != 'all'){
		// 	$conditions['having'] = 'remarkscount = 2';
		// }
		$Estimates 	= $dblms->getRows(ESTIMATES. ' e', $conditions);
		
		echo '
		<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
			Total Records: ('.number_format($count).')
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align:center;"> Sr #</th>
					<th style="text-align:center;">EST #</th>
					<th style="text-align:center;">Dated </th>
					<th> Customer</th>
					<th style="text-align:center;">Total Payable</th>
					<th style="text-align:center;">Want to Pay</th>
					<th style="text-align:center;">Percentage</th>
					<th style="text-align:center;">Approved</th>
					<th style="text-align:center;">Ikram Ghori</th>
					<th style="text-align:center;">Ali Mohiudeen</th>
					<th style="text-align:center;"> Status</th>
					<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;

				foreach($Estimates as $rowstd) {
					$fieldOperation  = '';
					$services  = '';

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

					// Filter the data
					foreach ($valuerequestremarks as $remark) {
						if ($remark['id_director'] == 30) {
							$fieldOperation = $remark;
						} elseif ($remark['id_director'] == 34) {
							$services = $remark;
						}
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

					// PERCENTAGE
					$percentage = ($rowstd['request_amount'] / ($rowstd['estimate_total'] + $openingbalance) * 100);
					
					$srno++;
					if($rowstd['estimate_status'] == '6'){
						$ctystatus = '<a href="challan.php?id='.$rowstd['voucher_no'].'" target="_blank">'.get_estimatestatus($rowstd['estimate_status']).'</a><br>✅';
					}else{
						$ctystatus = get_estimatestatus($rowstd['estimate_status']);
					}
					
					if($rowstd['estimate_status'] == '4' && in_array($_SESSION['userlogininfo']['LOGINIDA'], PAYMENT_REQUEST_PERMISSIONS)) {
						$editbtn = '<a class="btn btn-xs btn-info" href="customerestimates.php?view=payment_request_edit&id='.$rowstd['estimate_id'].'"><i class="icon-pencil"></i></a>';
					} else {
						$editbtn = '';
					}
					echo '
					<tr>
						<td style="text-align:center; width:50px;">'.$srno.'</td>
						<td style="text-align:center; width:90px;">'.$rowstd['estimate_no'].'</td>
						<td style="width:90px;">'.$rowstd['estimate_date'].' </td>
						<td style="vertical-align:middle;">'.$rowstd['customer_name'].'</td>
						<td style="text-align:right;width:100px;">'.number_format($rowstd['estimate_total'] + $openingbalance).'</td>
						<td style="text-align:right;width:90px;">'.number_format($rowstd['request_amount']).'</td>
						<td style="text-align:center;width:70px;">'.number_format($percentage,2).'%</td>
						<td style="text-align:right;width:70px;">'.($rowstd['approved_amount'] > 0 ? number_format($rowstd['approved_amount']) : '').'</td>
						<td style="text-align:center;width:75px;">'.(!empty($fieldOperation) ? $fieldOperation['amount'].'<br><small>'.date('d-m-Y', strtotime($fieldOperation['date_added'])).'</small>' : '').'</td>
						<td style="text-align:center;width:75px;">'.(!empty($services) ? $services['amount'].'<br><small>'.date('d-m-Y', strtotime($services['date_added'])).'</small>' : '').'</td>
						<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
						<td style="text-align:center;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Estimate Detail</b>" data-src="customerestimatesview.php?id='.$rowstd['estimate_id'].'" href="#"><i class="icon-zoom-out"></i></a> '.$editbtn;
							echo '
							<a class="btn btn-xs btn-information" href="paymentrequestprint.php?id='.$rowstd['estimate_id'].'" target="_blank"><i class="icon-print"></i></a>
							<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
						</td>
					</tr>';

				}

				echo '
			</tbody>
		</table>';

		echo $Pagination->get_Paginator('customerestimates.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
		
	} else { 
		
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';

	}
}
