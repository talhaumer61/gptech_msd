<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id']) && !isset($_GET['idestimate'])) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	//--------------------------------------------------
	$conditions = array ( 
								  'select' 		=> 'pr_id'
								, 'not_equal' 	=> array( 
																'pr_id' => 0 
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'pr_id DESC '
								, 'return_type' => 'count' 
						); 
    $Dontions 	= $dblms->getRows(DONATIONGIFTS, $conditions);

//--------------------------------------------------
	$count 		= ($Dontions);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'pr_id, pr_no, total, customer_name, dated, pr_status, customer_cell,
												dispatch_status, customer_email, customer_address'
							, 'not_equal' 	=> array( 
														'pr_id' => 0 
													)
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> 'pr_id DESC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						); 
    $Dontions 	= $dblms->getRows(DONATIONGIFTS, $conditions);
//------------------------------------------------
echo '
	<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
		Total Records: ('.number_format($count).')
	</div>
	<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th style="text-align:center;">DG #</th>
	<th style="text-align:center;">Dated </th>
	<th>Customer Name </th>
	<th>Customer Cell </th>
	<th>Customer Address </th>
	<th style="text-align:center;">Total</th>
	<th style="text-align:center;"> Status</th>
	<th style="text-align:center;"> Dispatch</th>
	<th style="width:80px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Dontions as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_saletypes($rowstd['pr_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$rowstd['pr_id'].'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.$rowstd['pr_no'].'</td>
	<td style="width:90px;vertical-align: middle;">'.$rowstd['dated'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_name'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_cell'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_address'].' </td>
	<td style="text-align:right;width:100px;vertical-align: middle;">'.number_format($rowstd['total']).'</td>
	<td style="text-align:center; width:60px;vertical-align: middle;">'.$ctystatus.'</td>
	<td style="text-align:center; width:60px;vertical-align: middle;">';
	
	if($rowstd['dispatch_status'] != 1 && $rowstd['pr_status'] == 3) { 
//------------------------------------------------

		$dispatchto 	= '';
		$dispatchcellno = '';
		$dispatchaddress = '';

	
//------------------------------------------------
			
			echo '
			<a class="btn btn-xs btn-info edit-dispatch-modal" data-toggle="modal" data-modal-window-title="Edit Item" data-height="350" data-width="100%" 
				data-cat-idorder 		= "'.$rowstd['pr_id'].'"
				data-cat-dispatchto 	= "'.$dispatchto.'" 
				data-cat-dispatchcellno = "'.$dispatchcellno.'" 
				data-cat-dispatchaddress = "'.$dispatchaddress.'" 
				data-cat-customername 	= "'.$rowstd['customer_name'].' ('.$rowstd['customer_cell'].')"
				data-cat-orderno	= "'.$rowstd['pr_no'].'" 
				data-target="#editdispatchModal"> Dispatch 
			</a>';
		} else if($rowstd['dispatch_status'] == 1) {
			echo '<span  class="btn btn-xs btn-purple">Dispatched</span>';
		} else {
			echo '';
		}
	echo '
	</td>
	<td style="text-align:center;vertical-align: middle;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Dontion / Gift Order Detail</b>" data-src="donationgiftsview.php?id='.$rowstd['pr_id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 
	
	
	if($rowstd['pr_status'] != 5 || ($_SESSION['userlogininfo']['LOGINIDA']  == 2)) {
		echo '<a class="btn btn-xs btn-info" href="donationgifts.php?id='.$rowstd['pr_id'].'">
				<i class="icon-pencil"></i>
			</a>';
	}
}
echo '
		<a class="btn btn-xs btn-purple" href="donationgifts.php?view=addcopied&id='.$rowstd['pr_id'].'" title="Copied Order"><i class="icon-copy"></i></a> 
		<a class="btn btn-xs btn-information" href="donationgiftsprint.php?id='.$rowstd['pr_id'].'" target="_blank"><i class="icon-print"></i></a>
		<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('donationgifts.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
}
