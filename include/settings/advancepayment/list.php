<?php 

//------------------------------------------------
if (!($Limit))   { $Limit = 100; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
//--------------------------------------------------
	$vendorconditions = array ( 
								  'select' 		=> 'id'
								, 'not_equal' 	=> array( 
															'id' => 0 
														) 
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'id ASC'
								, 'return_type' => 'count' 
							); 
    $Vendors 	= $dblms->getRows(ADVANCE_PAYSETTING, $vendorconditions);

//--------------------------------------------------
	$count 		   = $Vendors;
	$NumberOfPages = ceil($count/$Limit);

//--------------------------------------------------
if (($count) > 0) {
	
//--------------------------------------------------
	$vendorconditions = array ( 
								  'select' 		=> '*'
								, 'not_equal' 	=> array( 
														'id' => 0 
													) 
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'id ASC'
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
							); 
    $Vendors 	= $dblms->getRows(ADVANCE_PAYSETTING, $vendorconditions);
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
	<th> Balance Range</th>
	<th style="text-align:right;"> Balance %</th>
	<th style="text-align:right;"> New Order %</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
$srno = 0;
$totalbalance = 0;
//------------------------------------------------
foreach($Vendors as $rowstd) {

$srno++;
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['status']);
	
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'edit' => '1'))) { 
	
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Vendor" data-height="350" data-width="100%" data-com-status="'.$rowstd['status'].'" data-com-balancefrom="'.$rowstd['balance_from'].'" data-com-balanceto="'.$rowstd['balance_to'].'" data-com-balancepercentage="'.$rowstd['balance_percentage'].'" data-com-neworderpercentage="'.$rowstd['neworder_percentage'].'" data-com-id="'.$rowstd['id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td style="min-width:200px;">'.$rowstd['balance_from'].' - '.$rowstd['balance_to'].' </td>
	<td style="width:130px; text-align:center;">'.($rowstd['balance_percentage']).'</td>
	<td style="width:130px; text-align:center;">'.($rowstd['neworder_percentage']).'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'delete' => '1'))) { 	
	echo '<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
}
echo ' 
	</td>
</tr>';
	
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>

</table>';

//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}