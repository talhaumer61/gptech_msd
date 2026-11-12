<?php 

if(!isset($_GET['id']) && !LMS_VIEW) {
	
	$adjacents = 3;
	if(!($Limit)) 	{ $Limit = 100; } 
	if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

		
	$conditions = array ( 
							'select' 		=> ''.ESTIMATES.'.estimate_id, '.ESTIMATES.'.estimate_no, '.ESTIMATES.'.estimate_total, 
													'.ESTIMATES.'.id_customer, '.ESTIMATES.'.estimate_date, '.ESTIMATES.'.estimate_status,
													'.ESTIMATES.'.id_joborder, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, 
													'.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_name, '.ESTIMATES.'.joborder_no'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer"
								, 'where' 		=> array( 
															'is_deleted' => 0 
														) 
								, 'search_by' 	=> 'AND '.ESTIMATES.'.estimate_status IN (2,3) '.$sql2.''
								, 'order_by' 	=> 'estimate_id DESC '
							, 'return_type' => 'count' 
						); 
    $Estimates 	= $dblms->getRows(ESTIMATES, $conditions);

	
	$count 		= ($Estimates);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;						
	
	if (($count) > 0) { 
		
		$conditions = array ( 
								'select' 		=> ''.ESTIMATES.'.estimate_id, '.ESTIMATES.'.estimate_no, '.ESTIMATES.'.estimate_total, 
													'.ESTIMATES.'.id_customer, '.ESTIMATES.'.estimate_date, '.ESTIMATES.'.estimate_status,
													'.ESTIMATES.'.id_joborder, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, 
													'.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_name, '.ESTIMATES.'.joborder_no'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer"
								, 'where' 		=> array( 
															'is_deleted' => 0 
														) 
								, 'search_by' 	=> 'AND '.ESTIMATES.'.estimate_status IN (2,3) '.$sql2.''
								, 'order_by' 	=> 'estimate_id DESC '
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
							); 
		$Estimates 	= $dblms->getRows(ESTIMATES, $conditions);
		
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
					<th style="text-align:center;">Total</th>
					<th style="text-align:center;">Job Order #</th>
					<th style="text-align:center;"> Status</th>
					<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;

				foreach($Estimates as $rowstd) {
					
					$srno++;
					$ctystatus = get_estimatestatus($rowstd['estimate_status']);
					if($rowstd['id_joborder']) {
						$joborder = '<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Job Order Detail</b>" data-src="orderview.php?id='.$rowstd['id_joborder'].'" href="#">'.$rowstd['joborder_no'].'</a>';
						$editbtn = ' ';
					} else {
						$joborder = '<a class="btn btn-xs btn-purple confirmationBtn" data-question="Do you want to convert into job order?" data-action="customerestimates.php?view=convertjoborder&id='.$rowstd['estimate_id'].'">Convert To Job Order</a>';
						$editbtn = '<a class="btn btn-xs btn-info" href="customerestimates.php?id='.$rowstd['estimate_id'].'"><i class="icon-pencil"></i></a>';
					}
					echo '
					<tr>
						<td style="text-align:center; width:50px;">'.$srno.'</td>
						<td style="text-align:center; width:90px;">'.$rowstd['estimate_no'].'</td>
						<td style="width:90px;">'.$rowstd['estimate_date'].' </td>
						<td style="vertical-align:middle;">'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].' ('.($rowstd['customer_cellno']).')</td>
						<td style="text-align:right;width:100px;">'.number_format($rowstd['estimate_total']).'</td>
						<td style="text-align:center;width:100px;">'.$joborder.'</td>
						<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
						<td style="text-align:center;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Estimate Detail</b>" data-src="customerestimatesview.php?id='.$rowstd['estimate_id'].'" href="#"><i class="icon-zoom-out"></i></a> '.$editbtn;
							echo '
							<a class="btn btn-xs btn-information" href="customerestimatesprint.php?id='.$rowstd['estimate_id'].'" target="_blank"><i class="icon-print"></i></a>
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
