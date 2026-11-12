<?php 
if(!LMS_VIEW && !isset($_GET['id'])) {
	if (!($Limit))   { $Limit = 50; }  
	if ($page == "") { $page  = 1;  } 
	$conditions = array ( 
							  'select' 		=> ''.ESTIMATES.'.estimate_id'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer"
							, 'where' 		=> array( 
													 	''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													)
							, 'search_by' 	=> 'AND '.ESTIMATES.'.date_added >= DATE_SUB(NOW(), INTERVAL 1 MONTH) '.$sql2.''
							, 'order_by' 	=> ''.ESTIMATES.'.estimate_id DESC '
							, 'return_type' => 'count' 
						); 
    $Purchases 	= $dblms->getRows(ESTIMATES, $conditions);

	$count 		   = ($Purchases);
	$NumberOfPages = ceil($count/$Limit);
	
	if (($count) > 0) {
		$conditions = array ( 
								'select' 		=> ''.ESTIMATES.'.estimate_id, '.ESTIMATES.'.estimate_no, '.ESTIMATES.'.estimate_total , '.ESTIMATES.'.voucher_no, 
													'.ESTIMATES.'.id_customer, '.ESTIMATES.'.estimate_date, '.ESTIMATES.'.request_amount, '.ESTIMATES.'.approved_amount, '.ESTIMATES.'.estimate_status,
													'.ESTIMATES.'.id_joborder, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code,
													'.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_name, '.ESTIMATES.'.joborder_no'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer"
								, 'where' 		=> array( 
															 ''.CUSTOMERS.'.customer_loginid' 	=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
															,''.ESTIMATES.'.is_deleted'			=> 0
														) 
								, 'search_by' 	=> 'AND '.ESTIMATES.'.date_added >= DATE_SUB(NOW(), INTERVAL 1 MONTH) '.$sql2.''
								, 'order_by' 	=> 'estimate_id DESC '
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
							); 
		$Purchases 	= $dblms->getRows(ESTIMATES, $conditions);
		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
			Total Records: ('.number_format($count).')
		</div>
		<div style="clear:both;"></div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align:center;"> Sr #</th>
					<th style="text-align:center;">EST #</th>
					<th style="text-align:center;">Dated </th>
					<th> Customer</th>
					<th style="text-align:center;">Order Total</th>
					<th style="text-align:center;">Want To Pay</th>
					<th style="text-align:center;">Approved</th>
					<th style="text-align:center;">Job Order #</th>
					<th style="text-align:center;"> Status</th>
					<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;
				foreach($Purchases as $rowstd) {
					$srno++;
					$ctystatus = get_estimatestatus($rowstd['estimate_status']);
					if($rowstd['id_joborder']) {
						$joborder = '<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Job Order Detail</b>" data-src="orderview.php?id='.$rowstd['id_joborder'].'" href="#">'.$rowstd['joborder_no'].'</a>';
						$editbtn = ' ';
					} else {
						if($rowstd['estimate_status'] == '5' ){
							$joborder = '<a class="btn btn-xs btn-success" href="customerestimates.php?view=payments&id='.$rowstd['estimate_id'].'">Pay Now</a>';
							$editbtn = ' ';
						}elseif($rowstd['estimate_status'] == '4'){
							$joborder = '<a class="btn btn-xs btn-primary" >Wait For Approval</a>';
							$editbtn = ' ';
						}elseif($rowstd['estimate_status'] == '6'){
							$joborder = '<a href="challan.php?id='.$rowstd['voucher_no'].'" target="_blank" class="btn btn-xs btn-purple" ><i class="icon-print"></i> Print Challan</a>
							<form class="mt-1" action="raast_qr.php" method="POST" target="_blank">
								<input type="hidden" name="challanNo" id="challanNo" value="'.$rowstd['voucher_no'].'">
								<button class="btn btn-xs btn-primary" type="submit" name="submit_paynow" id="submit_paynow"><i class="icon-credit-card"></i> RAAST QR</button>
							</form>';
							$editbtn = ' ';
						}else{
							$joborder = '';
							$editbtn = '<a class="btn btn-xs btn-info" href="customerestimates.php?view=add&idest='.$rowstd['estimate_id'].'"><i class="icon-pencil"></i></a>';
						}
					}
					echo '
					<tr>
						<td style="text-align:center; width:50px;">'.$srno.'</td>
						<td style="text-align:center; width:90px;">'.$rowstd['estimate_no'].'</td>
						<td style="width:90px;">'.$rowstd['estimate_date'].' </td>
						<td style="vertical-align:middle;">'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].' ('.($rowstd['customer_cellno']).')</td>
						<td style="text-align:right;width:100px;">'.number_format($rowstd['estimate_total']).'</td>
						<td style="text-align:right;width:100px;">'.($rowstd['request_amount'] > 0 ? number_format($rowstd['request_amount']) : '').'</td>
						<td style="text-align:right;width:70px;">'.($rowstd['approved_amount'] > 0 ? number_format($rowstd['approved_amount']) : '').'</td>
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
		if($count>$Limit) {
			echo '
			<div class="widget-foot">
				<ul class="pagination pull-right">';
					$Nav= ""; 
					if($page > 1) { 
						$Nav .= '<li><a href="customerestimates.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
					} 
					for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
					if($i == $page) { 
						$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
					} else { 
						$Nav .= '<li><a href="customerestimates.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
					} } 
					if($page < $NumberOfPages) { 
						$Nav .= '<li><a href="customerestimates.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
					} 
					echo $Nav;
					echo '
				</ul>
				<div class="clearfix"></div>
			</div>';
		}
	} else { 
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';
	}
}
