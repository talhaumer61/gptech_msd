<?php 

if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 

$conditions = array ( 
							'select' 	=> 'cm.company_id',
							'join' 		=> "LEFT JOIN ".ADES." ad ON ad.ade_id = cm.id_ade
											LEFT JOIN ".CUSTOMERS." cs ON cs.id_company =  cm.company_id",
							'not_equal' => array( 
												'cm.company_id' => 0 
											), 
							'search_by' 	=> $sql2,
							'group_by' 		=> 'cs.id_company',
							'order_by' 		=> 'cm.company_name ASC ',
							'return_type' 	=> 'count' 
						); 
$Company 	= $dblms->getRows(COMPANY.' cm', $conditions);

$count 		   = ($Company);
	
if (($count) > 0) {
	
	$conditions = array ( 
								'select' 	=> 'cm.company_id, cm.company_status, cm.company_name, cm.id_ade, cm.company_address, cm.company_code,
												ad.ade_name, ad.ade_whatsapp, ad.ade_email,
												COUNT(cs.customer_id) as schools',
								'join' 		=> "LEFT JOIN ".ADES." ad ON ad.ade_id = cm.id_ade
												LEFT JOIN ".CUSTOMERS." cs ON cs.id_company =  cm.company_id",
								'not_equal' => array( 
													'cm.company_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'group_by' 		=> 'cs.id_company',
								'order_by' 		=> 'cm.company_name ASC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Company 	= $dblms->getRows(COMPANY.' cm', $conditions);

	echo '
	<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
		Total Records: ('.number_format($count).')
		<a class="btn btn-xs btn-information" href="zonereceivablereport.php?cstatus='.$cstatus.'" target="_blank" title="Print Ledger"><i class="icon-print"></i> Print</a>
	</div>
	<div style="clear:both;"></div>
		<table class="table table-bordered table-hover" id="receivableTable">
		<thead>
		<tr>
			<th style="text-align:center;"> Sr #</th>
			<th style="text-align:center;"> Code</th>
			<th> Name</th>
			<th>ADE</th>
			<th>Whatsapp</th>
			<th>Email</th>
			<th>Number Of Schools</th>
			<th>Total Receivable</th>
			<th style="text-align:center;"> Status</th>
			<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
		</tr>
		</thead>
		<tbody>';
		
			$srno = 0;
			$totalschools = 0;
			$totalbalance = 0;

			foreach($Company as $rowstd) {
				// $customerIds = explode(',', $rowstd['customers']); 
				$zonebalance = 0;
				
				$sumconditions = array(
											'select'     => "COALESCE(SUM(CASE 
																	WHEN p.ledgerfor = '1' AND p.debit_credit = '2' THEN p.amount 
																END), 0) as totalreceivables, 
																COALESCE(SUM(CASE 
																	WHEN p.ledgerfor = '1' AND p.debit_credit = '1' THEN p.amount 
																END), 0) as totalpaid",
											'join'       => "LEFT JOIN " . PAYMENTS . " p ON cs.customer_id = p.id_user AND p.status = '1'",
											'where'      => array(
																		'cs.id_company'      => $rowstd['company_id']
																	),
											'search_by' 	=> $sql2,
											'group_by'   => 'cs.customer_id',
											'return_type'=> 'all'
										);

				$rowsreceivables 	= $dblms->getRows(CUSTOMERS. ' cs', $sumconditions);
				
				foreach($rowsreceivables as $receivable){
					$zbalance = ($receivable['totalreceivables']  - $receivable['totalpaid']);
					if ($zbalance >= 0) {
						$zonebalance += $zbalance;
					}

				}



				$srno++;
				$ctystatus = get_admstatus($rowstd['company_status']);
				$totalschools += $rowstd['schools'];
				$totalbalance += $zonebalance;

				echo '
				<tr>
					<td style="text-align:center; width:50px;">'.$srno.'</td>
					<td style="text-align:center; width:70px;">'.$rowstd['company_code'].'</td>
					<td style="min-width:250px;">'.$rowstd['company_name'].' </td>
					<td>'.$rowstd['ade_name'].'</td>
					<td>'.$rowstd['ade_whatsapp'].'</td>
					<td>'.$rowstd['ade_email'].'</td>
					<td style="text-align:center;vertical-align: middle;">'.$rowstd['schools'].'</td>
					<td style="text-align:right;vertical-align: middle;">'.number_format($zonebalance).'</td>
					<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
					<td style="text-align:center;"> ';
						if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'edit' => '1'))) { 
							echo '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Company" data-height="350" data-width="100%" data-com-status="'.$rowstd['company_status'].'" data-com-code="'.$rowstd['company_code'].'" data-com-name="'.$rowstd['company_name'].'" data-com-phone="'.$rowstd['company_phone'].'" data-com-email="'.$rowstd['company_email'].'" data-com-fax="'.$rowstd['company_fax'].'" data-com-address="'.$rowstd['company_address'].'" data-com-person="'.$rowstd['company_contactperson'].'" data-com-personcell="'.$rowstd['company_personcell'].'" data-com-personwhatsapp="'.$rowstd['company_personwhatsapp'].'" data-com-id="'.$rowstd['company_id'].'" data-com-ade="'.$rowstd['id_ade'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a>
							<a class="btn btn-xs btn-information" href="zonebalancereport.php?id='.$rowstd['company_id'].'&cstatus='.$cstatus.'" target="_blank" title="Print Ledger"><i class="icon-print"></i></a> ';
						}
						if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'delete' => '1'))) { 
							echo '<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
						}
						echo '
						<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>What\'s Log Detail: '.$rowstd['company_name'].'</b>" data-src="companywalog.php?id='.$rowstd['company_id'].'" href="#"><i class="icon-envelope-alt"></i></a>
					</td>
				</tr>';

			} 

			echo '
			<tr>
				<th colspan="6" style="text-align:center;">Grand Total</th>
				<th style="text-align:center;">'.$totalschools.'</th>
				<th style="text-align:right;">'.number_format($totalbalance).'</th>
				<th colspan="2" ></th>
			</tr>
		</tbody>
	</table>
	<script>
		$(document).ready(function () {
			let table = $(\'#receivableTable tbody\');

			let rows = table.find(\'tr\').get();

			rows.sort(function (a, b) {
				// Get total receivable value from 8th column (index 7)
				let keyA = parseFloat($(a).children(\'td\').eq(7).text().replace(/,/g, \'\')) || 0;
				let keyB = parseFloat($(b).children(\'td\').eq(7).text().replace(/,/g, \'\')) || 0;

				return keyB - keyA; // DESCENDING ORDER
			});

			// Re-append and update Sr #
			$.each(rows, function (index, row) {
				$(row).find(\'td\').eq(0).text(index + 1); // Update Sr #
				table.append(row);
			});
		});
	</script>
';

} else { 
	
	echo '
	<div class="col-lg-12">
		<div class="widget-tabs-notification">No Result Found</div>
	</div>';

}
