<?php 
if(!isset($_GET['id']) && !LMS_VIEW) {
	
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 

	$itemconditions = array ( 
								  'select' 		=> ''.ITEMS.'.item_id'
								, 'join' 		=> "LEFT JOIN ".ITEMS_CAT." ON ".ITEMS_CAT.".cat_id = ".ITEMS.".id_cat"
								, 'where' 		=> array( 
															''.ITEMS.'.id_company' 	=> 0 
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> ''.ITEMS.'.item_status ASC, '.ITEMS.'.item_name ASC'
								, 'return_type' => 'count' 
							); 
    $Items 	= $dblms->getRows(ITEMS, $itemconditions);

	
	$count 		= ($Items);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
	
	if (($count) > 0) {
		
		$itemconditions = array ( 
									'select' 		=> ''.ITEMS.'.item_id, '.ITEMS.'.id_cat, '.ITEMS.'.item_status, '.ITEMS.'.item_name, 
														'.ITEMS.'.item_code, '.ITEMS.'.item_type, '.ITEMS.'.item_reorder, '.ITEMS.'.item_details, 
														'.ITEMS.'.item_photo, '.ITEMS.'.item_balance, '.ITEMS.'.item_maxquantity, '.ITEMS.'.item_pricepurchase,
														'.ITEMS.'.item_pricesale, '.ITEMS.'.cgs, '.ITEMS.'.income_department, '.ITEMS_CAT.'.cat_name'
									, 'join' 		=> "LEFT JOIN ".ITEMS_CAT." ON ".ITEMS_CAT.".cat_id = ".ITEMS.".id_cat"
									, 'where' 		=> array( 
																''.ITEMS.'.id_company' 	=> 0 
															)
									, 'search_by' 	=> $sql2
									, 'order_by' 	=> ''.ITEMS.'.item_status ASC, '.ITEMS.'.item_name ASC'
									, 'start' 		=> ($page-1)*$Limit
									, 'limit' 		=> $Limit
									, 'return_type' => 'all' 
								); 
		$Items 	= $dblms->getRows(ITEMS, $itemconditions);
		
		if($_SERVER['QUERY_STRING']) {
			$refs1 = str_replace('&','_',$_SERVER['QUERY_STRING']);
			$refs = '&refs='.str_replace('=','|',$refs1);
		} else {
			$refs = '';
		}
		
		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
			<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
				Total Records: ('.number_format($count).') 
				<input type="hidden" name="type" value="items">
				<input type="hidden" name="querystring" value="'.$sql2.'">
				<button type="submit" class="btn btn-info">Export</button>
			</form>
		</div>
		<div style="clear:both;"></div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th style="font-weight:600;text-align:center;">Pic</th>
					<!--th style="text-align:center;"> Sr #</th-->
					<th style="text-align:center;"> Code</th>
					<th> Item Name </th>
					<th> Category Name</th>
					<th style="text-align:center;"> Purchase Price </th>
					<th style="text-align:center;"> Sale Price</th>
					<th style="text-align:center;"> Stock Available</th>
					<th style="text-align:center;"> Reorder</th>
					<th style="text-align:center;"> Max.QTY</th>
					<th style="text-align:center;"> Status</th>
					<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}

				foreach($Items as $rowstd) {
					
					$srno++;
					$ctystatus = get_admstatus($rowstd['item_status']);
					
					if($rowstd['item_photo']) { 
						$itemphoto = '<img class="avatar-smallest image-boardered" src="uploads/items/'.$rowstd['item_photo'].'" alt="'.$rowstd['item_name'].'"/>';
					} else {
						$itemphoto = '<img class="avatar-smallest image-boardered" src="uploads/items/default.png" alt="'.$rowstd['item_name'].'"/>';
					}

					// Get Stock detail
					$resulttotalInOut = $mainclass->get_itemstock($rowstd['item_id']);

					if($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']) {
						$stockbalance = '<span style="font-weight:600; font-size:14px; color:#00f;">'.number_format($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']).'</span>';
						$stockavaiable = ($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']);
					} else {
						$stockbalance = '---';
						$stockavaiable = 0;
					}	
					
					if($stockavaiable == $rowstd['item_reorder']) {
						$bgrtcolor = ' style="background-color: lightsalmon; font-weight:600;  cursor: pointer;" title="Available Stock equal to Reorder"';
					} elseif($stockavaiable<$rowstd['item_reorder']) {
						$bgrtcolor = ' style="background-color: darkorange; font-weight:600;  cursor: pointer;" title="Available Stock less than to Reorder"';
					} else {
						$bgrtcolor = '';
					}
					
					echo '
					<tr '.$bgrtcolor.'>
						<td  style="vertical-align: middle; width:50px;">'.$itemphoto.'</td>
						<!--td style="text-align:center; width:50px;">'.$srno.'</td-->
						<td style="text-align:center; width:70px;">'.$rowstd['item_code'].'</td>
						<td>'.$rowstd['item_name'].' </td>
						<td>'.$rowstd['cat_name'].'</td>
						<td style="text-align:center; width:110px;">'.$rowstd['item_pricepurchase'].'</td>
						<td style="text-align:center; width:80px;">'.$rowstd['item_pricesale'].'</td>
						<td style="text-align:center; width:110px; ">'.$stockbalance.'</td>
						<td style="text-align:center; width:70px; ">'.$rowstd['item_reorder'].'</td>
						<td style="text-align:center; width:70px; ">'.number_format($rowstd['item_maxquantity']).'</td>
						<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
						<td style="text-align:center;">';
						
							if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'edit' => '1'))) { 
							echo '	
									<a class="btn btn-xs btn-info" data-toggle="modal" href="items.php?id='.$rowstd['item_id'].$refs.'"><i class="icon-pencil"></i></a> ';
							}
							echo '
							<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a> 
							<a class="btn btn-xs btn-information" href="stockledgerprint.php?id='.$rowstd['item_id'].'" title="Print Ledger" target="_blank"><i class="icon-print"></i></a>
						</td>
					</tr>';

				} 
				echo '
			</tbody>
		</table>';

		echo $Pagination->get_Paginator('items.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
		
	} else { 
		
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';

	}
}