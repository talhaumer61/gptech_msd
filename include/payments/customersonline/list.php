<?php 

if(!isset($_GET['id']) && !LMS_VIEW) {
	
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}


	$conditions = array ( 
								'select' 	=> ''.PAYMENTS.'.id',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user 
												LEFT JOIN ".PAYFAST_TRANSACTIONS." ON ".PAYFAST_TRANSACTIONS.".basket_id =  ".PAYMENTS.".transaction_invoiceno",
								'where' => array( 
													  ''.PAYMENTS.'.ledgerfor' 	=> 1
													, ''.PAYMENTS.'.debit_credit' => 1 
													
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PAYMENTS.'.receipt_no  DESC ',
								'return_type' 	=> 'count' 
							); 
    $Payments 	= $dblms->getRows(PAYMENTS, $conditions);

	
	$count 		= ($Payments);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

	
	if (($count) > 0) {
		$conditions = array ( 
									'select' 	=> ''.PAYMENTS.'.id, '.PAYMENTS.'.dated, '.PAYMENTS.'.reference_no, '.PAYMENTS.'.receipt_no, '.PAYMENTS.'.transaction_id, 
													'.PAYMENTS.'.id_cat, '.PAYMENTS.'.transaction_paiddate, '.PAYMENTS.'.amount, '.PAYMENTS.'.pay_mode, '.PAYMENTS.'.remarks, 
													'.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_cellno, '.PAYFAST_TRANSACTIONS.'.payment_link',
									'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user 
													LEFT JOIN ".PAYFAST_TRANSACTIONS." ON ".PAYFAST_TRANSACTIONS.".basket_id =  ".PAYMENTS.".transaction_invoiceno",
									'where' => array( 
														''.PAYMENTS.'.ledgerfor' 	=> 1 
														, ''.PAYMENTS.'.debit_credit' => 1 
													), 
									'search_by' 	=> $sql2,
									// 'group_by' 		=> ''.PAYFAST_TRANSACTIONS.'.basket_id',
									'order_by' 		=> ''.PAYMENTS.'.receipt_no  DESC ',
									'start' 		=> ($page-1)*$Limit,
									'limit' 		=> $Limit,
									'return_type' 	=> 'all' 
								); 
		$Payments 	= $dblms->getRows(PAYMENTS, $conditions);
		echo '
		<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
			Total Records: ('.number_format($count).')
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style=" text-align:center;"> Sr.#</th>
					<th style=" text-align:center;"> Dated</th>
					<th style=" text-align:center; width:100px;"> Receipt #</th>
					<th> Customer Name</th>
					<th style="text-align:center;"> Amount</th>
					<th style=" text-align:center;">Method</th>
					<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
				foreach($Payments as $rowstd) {
					$srno++;
					$orderdate = new DateTime($rowstd['dated']); 
					/*	if($rowstd['id_added']) {
							$sqllmsadded = $dblms->querylms("SELECT adm_fullname FROM ".ADMINS." WHERE adm_id = '".cleanvars($rowstd['id_added'])."' LIMIT 1 ");
							$valueadded	= mysqli_fetch_array($sqllmsadded);
							$addedby = $valueadded['adm_fullname'];
						} else { 
							$addedby = $valueadded['adm_fullname'];
						}*/
					echo '
					<tr>
						<td style="width:50px; text-align:center;">'.$srno.'</td>
						<td style="width:80px; text-align:center;">'.$orderdate->format('d/m/Y').'</td>
						<td style="width:80px; text-align:center;">'.$rowstd['receipt_no'].'</td>
						<td>'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].' '.$rowstd['customer_cellno'].'</td>	
						<td style="text-align:right;width:80px;">'.number_format($rowstd['amount']).'</td>
						<td style="width:90px;text-align:center;">'.get_paytypes($rowstd['pay_mode']).'</td>
						<td style="text-align:center;">';
						if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '35', 'edit' => '1'))) { 
							
							echo '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-name="'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].' ('.$rowstd['customer_cellno'].')" data-com-amount="'.$rowstd['amount'].'" data-com-pmode="'.get_paytypes($rowstd['pay_mode']).'" data-com-transid="'.$rowstd['transaction_id'].'" data-com-receipt="'.$rowstd['receipt_no'].'" data-com-date="'.$rowstd['transaction_paiddate'].'" data-com-reference="'.$rowstd['reference_no'].'" data-com-idcat="'.$rowstd['id_cat'].'"  data-com-remarks="'.$rowstd['remarks'].'" data-com-id="'.$rowstd['id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
							
						}
						if($rowstd['pay_mode'] == 4) {
							echo ' <a class="btn btn-xs btn-information" href="'.$rowstd['payment_link'].'" target="_blank"><i class="icon-print"></i></a>';
						}
						echo '
						</td>
					</tr>';
				}
				echo '
			</tbody>
		</table>';
		echo $Pagination->get_Paginator('customeronlinepayments.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
	} else { 
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';
	}
}