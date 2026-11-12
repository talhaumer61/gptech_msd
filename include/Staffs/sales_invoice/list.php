<?php 

if(!LMS_VIEW && !isset($_GET['id'])) {
	
	$adjacents = 3;
	if(!($Limit)) 	{ $Limit = 100; } 
	if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

	$conditions = array ( 
								'select' 	=> ''.SALES_INVOICE.'.salesinvoice_id',
								'join' 		=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'not_equal' => array( 
													''.SALES_INVOICE.'.salesinvoice_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.SALES_INVOICE.'.salesinvoice_id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Invoices 	= $dblms->getRows(SALES_INVOICE, $conditions);
	
	$count 		= ($Invoices);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
	
	if (($count) > 0) {
		
		$conditions = array ( 
									'select' 	=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, '.SALES_INVOICE.'.grand_total, 
													'.SALES_INVOICE.'.paid, '.SALES_INVOICE.'.balance, '.SALES_INVOICE.'.dated, '.SALES_INVOICE.'.total, 
													'.SALES_INVOICE.'.prev_balance, '.SALES_INVOICE.'.salesinvoice_status, '.JOB_ORDER.'.job_order_id,
													'.JOB_ORDER.'.job_order_status, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.id_company, '.CUSTOMERS.'.customer_cellno, '.SALES_INVOICE.'.dispatch_status',
									'join' 		=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
									'not_equal' => array( 
														''.SALES_INVOICE.'.salesinvoice_id' => 0 
													), 
									'search_by' 	=> $sql2,
									'order_by' 		=> ''.SALES_INVOICE.'.salesinvoice_id DESC ',
									'start' 		=> ($page-1)*$Limit,
									'limit' 		=> $Limit,
									'return_type' 	=> 'all' 
								); 
		$Invoices 	= $dblms->getRows(SALES_INVOICE, $conditions);
		
		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
			Total Records: ('.number_format($count).')
		</div>
		<div style="clear:both;"></div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align:center;"> Sr #</th>
					<th style="text-align:center;"> Invoice #</th>
					<th style="text-align:center;"> Dated </th>
					<th> Customer Name </th>
					<th style="text-align:center;"> INV. Total</th>
					<th style="text-align:center;"> Prv Balance</th>
					<th style="text-align:center;"> Advance</th>
					<th style="text-align:center;"> Balance</th>
					<th style="text-align:center;"> Status</th>
					<th style="text-align:center;"> Dispatch</th>
					<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;

				foreach($Invoices as $rowstd) {
					
					$srno++;
					echo '
					<tr>
						<td style="text-align:center; width:50px;">'.$rowstd['salesinvoice_id'].'</td>
						<td style="text-align:center; width:90px;">'.$rowstd['salesinvoice_no'].'</td>
						<td style="width:90px;">'.$rowstd['dated'].' </td>
						<td>'.$rowstd['customer_name'].'</td>
						<td style="width:100px;text-align:right;">'.number_format($rowstd['total']).'</td>
						<td style="width:100px;text-align:right;">'.number_format($rowstd['prev_balance']).'</td>
						<td style="width:100px;text-align:right;">'.number_format($rowstd['paid']).'</td>
						<td style="width:100px;text-align:right;">'.number_format(($rowstd['total'] + $rowstd['prev_balance']) - $rowstd['paid']).'</td>
						<td style="text-align:center; width:60px;">'.get_saletypes($rowstd['salesinvoice_status']).'</td>
						<td style="text-align:center; width:80px;">';
						
							if($rowstd['dispatch_status'] != 1 && $rowstd['salesinvoice_status'] == 3) { 
								
								$dispatchconditions = array ( 
														'select' 	=> 'dispatchto, dispatchcellno, dispatchaddress',
														'where' => array( 
																			'id_customer' => cleanvars($rowstd['customer_id']) 
																		), 
														'search_by' 	=> " AND dispatchto != ''",
														'order_by' 		=> "salesinvoice_id DESC",
														'limit' 		=> 1,
														'return_type' 	=> 'single' 
													); 
								$valuedispatch 	= $dblms->getRows(SALES_INVOICE, $dispatchconditions);

								
								if(!empty($valuedispatch)) {

									$dispatchto 	= $valuedispatch['dispatchto'];
									$dispatchcellno = $valuedispatch['dispatchcellno'];
									$dispatchaddress = $valuedispatch['dispatchaddress'];
								} else {
									$dispatchto 	= '';
									$dispatchcellno = '';
									$dispatchaddress = '';
								}
								
								echo '
								<a class="btn btn-xs btn-info edit-dispatch-modal" data-toggle="modal" data-modal-window-title="Edit Item" data-height="350" data-width="100%" 
									data-cat-idinvoice 		= "'.$rowstd['salesinvoice_id'].'"
									data-cat-job_orderid 	= "'.$rowstd['job_order_id'].'"
									data-cat-customerid 	= "'.$rowstd['customer_id'].'" 
									data-cat-dispatchto 	= "'.$dispatchto.'" 
									data-cat-dispatchcellno = "'.$dispatchcellno.'" 
									data-cat-dispatchaddress = "'.$dispatchaddress.'" 
									data-cat-customername 	= "'.$rowstd['customer_name'].' ('.$rowstd['customer_cellno'].')"
									data-cat-salesinvoiceno	= "'.$rowstd['salesinvoice_no'].'" 
									data-target="#editdispatchModal"> Dispatch 
								</a>';
							} else if($rowstd['dispatch_status'] == 1) {
								echo '<span  class="btn btn-xs btn-purple">Dispatched</span>';
							} else {
								echo '';
							}
						
							echo '
						</td>
						<td style="text-align:center;">';
							if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '2', 'edit' => '1'))) { 
								if(($rowstd['salesinvoice_status'] != 3 && $rowstd['salesinvoice_status'] != 5)) {	
									echo '<a class="btn btn-xs btn-info" href="sales-invoice.php?id='.$rowstd['salesinvoice_id'].'">
											<i class="icon-pencil"></i>
										</a>';
								}
							}
							echo ' <a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Invoice Detail</b>" data-src="saleinvoicview.php?id='.$rowstd['salesinvoice_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
							<a class="btn btn-xs btn-information" href="saleinvoiceprint.php?id='.$rowstd['salesinvoice_id'].'" target="_blank"><i class="icon-print"></i></a>
							<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
						</td>
					</tr>';

				}

				echo '
			</tbody>
		</table>';
		echo $Pagination->get_Paginator('sales-invoice.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
		
	} else { 
		
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';

	}
}
