<?php 

$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 

	$conditions = array ( 
								'select' 	=> ''.CUSTOMERS.'.customer_id',
								'join' 		=> "LEFT JOIN ".ADES." ON ".ADES.".ade_id =  ".CUSTOMERS.".id_ade 
												LEFT JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company",
								'not_equal' => array( 
													''.CUSTOMERS.'.customer_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.CUSTOMERS.'.customer_id ASC ',
								'return_type' 	=> 'count' 
							); 
    $Customers 	= $dblms->getRows(CUSTOMERS, $conditions);

	
	$count 		= ($Customers);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
	
	if (($Customers) > 0) {
		
		
		$conditions = array(
							'select' => "
								".CUSTOMERS.".customer_id, 
								".CUSTOMERS.".customer_status, 
								".CUSTOMERS.".customer_name,
								".CUSTOMERS.".customer_code, 
								".CUSTOMERS.".customer_cellno, 
								".CUSTOMERS.".customer_email,
								".CUSTOMERS.".customer_address, 
								".CUSTOMERS.".customer_contactperson,
								".CUSTOMERS.".customer_loginid, 
								".CUSTOMERS.".customer_personcell, 
								".CUSTOMERS.".customer_personwhatsapp, 
								".CUSTOMERS.".id_city, 
								".CUSTOMERS.".customer_codelhsmes, 
								".CUSTOMERS.".customer_openingbalance, 
								".CUSTOMERS.".id_ade, 
								".CUSTOMERS.".id_company, 
								".ADES.".ade_name, 
								".ADES.".ade_cellno, 
								".COMPANY.".company_id, 
								".COMPANY.".company_name, 
								".CUSTOMERS.".id_brand, 
								".CUSTOMERS.".id_zone, 
								".CUSTOMERS.".id_type, 
								".CUSTOMERS.".customer_invoicelogo,

								COALESCE(SUM(CASE 
									WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' 
									THEN ".PAYMENTS.".amount END), 0) AS totalreceivables,

								COALESCE(SUM(CASE 
									WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' 
									THEN ".PAYMENTS.".amount END), 0) AS totalpaid,

								(COALESCE(SUM(CASE 
									WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' 
									THEN ".PAYMENTS.".amount END), 0)
								-
								COALESCE(SUM(CASE 
									WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' 
									THEN ".PAYMENTS.".amount END), 0)
								) AS balance
							",
							'join' => "LEFT JOIN ".ADES." ON ".ADES.".ade_id = ".CUSTOMERS.".id_ade
									LEFT JOIN ".COMPANY." ON ".COMPANY.".company_id = ".CUSTOMERS.".id_company
									LEFT JOIN ".PAYMENTS." ON ".PAYMENTS.".id_user = ".CUSTOMERS.".customer_id",
							'not_equal' => array(
								''.CUSTOMERS.'.customer_id' => 0
							),
							'search_by' => $sql2,
							'group_by' => CUSTOMERS.".customer_id",
							'order_by' => "balance DESC",
							'start' => ($page-1)*$Limit,
							'limit' => $Limit,
							'return_type' => 'all'
						);

		$Customers = $dblms->getRows(CUSTOMERS, $conditions);


		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
			<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
				Total Records: ('.number_format($count).') 
				<input type="hidden" name="type" value="customers">
				<input type="hidden" name="querystring" value="'.$sql2.'">
				<button type="submit" class="btn btn-info">Export</button>
			</form>
		</div>
		<div style="clear:both;"></div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align:center;"> Sr #</th>
					<th style="text-align:center;"> Code</th>
					<th style="text-align:center;">LHS/MES Code</th>
					<th> Name</th>

					<th>Contact Person</th>
					<th>Cell #</th>
					<th style="text-align:left;">Brand</th>
					<th style="text-align:left;">Zone</th>
					<th style="text-align:center;">Balance</th>
					<th style="text-align:center;"> Status</th>
					<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				
				if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }

				foreach($Customers as $rowstd) {
					
					$srno++;
					$ctystatus = get_admstatus($rowstd['customer_status']);

					
					if($rowstd['id_brand']) { $bandname = get_brandnames($rowstd['id_brand']); } else { $bandname = ''; }
					
					echo '
					<tr>
						<td style="text-align:center; width:50px;vertical-align: middle;">'.$srno.'</td>
						<td style="text-align:left; width:100px;vertical-align: middle;">'.$rowstd['customer_code'].'</td>
						<td style="text-align:left; width:100px;vertical-align: middle;">'.$rowstd['customer_codelhsmes'].'</td>
						<td style="min-width:200px;vertical-align: middle;">'.$rowstd['customer_name'].' </td>
						
						<td style="vertical-align: middle;">'.$rowstd['customer_contactperson'].'</td>
						<td style="vertical-align: middle;">'.$rowstd['customer_personcell'].'</td>
						<td style="text-align:left;vertical-align: middle;">'.$bandname.'</td>
						<td style="text-align:left;vertical-align: middle;">'.$rowstd['company_name'].'</td>
						<td style="text-align:right;vertical-align: middle;">'.number_format($rowstd['balance']).'</td>
						<td style="text-align:center; width:60px; vertical-align: middle;">'.$ctystatus.'</td>
						<td style="text-align:center; vertical-align: middle;">';
						
							if($_SESSION['userlogininfo']['LOGINIDA'] == 825  || $_SESSION['userlogininfo']['LOGINIDA'] == 2) { 
							echo '	
								<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Company" data-height="350" data-width="100%" data-com-status="'.$rowstd['customer_status'].'" data-com-code="'.$rowstd['customer_code'].'" data-com-name="'.$rowstd['customer_name'].'" data-com-phone="'.$rowstd['customer_cellno'].'" data-com-email="'.$rowstd['customer_email'].'" data-com-address="'.$rowstd['customer_address'].'" data-com-person="'.$rowstd['customer_contactperson'].'" data-com-personcell="'.$rowstd['customer_personcell'].'" data-com-personwhatsapp="'.$rowstd['customer_personwhatsapp'].'" data-com-openingbalance="'.$rowstd['customer_openingbalance'].'" data-com-ade="'.$rowstd['id_ade'].'" data-com-brand="'.$rowstd['id_brand'].'" data-com-zone="'.$rowstd['id_zone'].'" data-com-city="'.$rowstd['id_city'].'" data-com-company="'.$rowstd['id_company'].'" data-com-codelhsmes="'.$rowstd['customer_codelhsmes'].'" data-com-idtype="'.$rowstd['id_type'].'"  data-com-invoicelogo="'.$rowstd['customer_invoicelogo'].'" data-com-id="'.$rowstd['customer_id'].'" data-com-loginid="'.$rowstd['customer_loginid'].'" data-target="#editCountryModal" ><i class="icon-pencil"></i></a> ';
							}
							echo ' <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Customer Ledger Detail: '.$rowstd['customer_name'].'</b>" data-src="customerledgerview.php?id='.$rowstd['customer_id'].'" href="#" title="View Ledger"><i class="icon-zoom-in"></i></a> <a class="btn btn-xs btn-information" href="customerledgerprint.php?id='.$rowstd['customer_id'].'" target="_blank" title="Print Ledger"><i class="icon-print"></i></a>';
							
							if($_SESSION['userlogininfo']['LOGINIDA'] == 825) { 	
								echo ' <a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
							}
							echo '
						</td>
					</tr>';
					
				} 

				echo '
			</tbody>
		</table>';

		echo $Pagination->get_Paginator('customers.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
		
	} else { 
		
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';

	}
