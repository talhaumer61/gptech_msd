<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	include "functions/db_functions.php";
	include "functions/pagination.php";
	$mainclass	= new main();
	$Pagination	= new Pagination();
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '9')) { 
	include_once("include/ledgers/stocks/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (".ITEMS.".item_name LIKE '%".$srch."%' 
						 OR ".ITEMS.".item_code LIKE '".$srch."')";
	$sqlstring	.= "&srch=".$srch."";
}
	
// get all Items
	$Items		= $mainclass->get_items();
//----------------------------------------

echo '<title>Manage Stock Ledger  - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_CLIENTS_SEARCH-->
<div class="navbar navbar-default" role="navigation">
<!-- .container-fluid -->
<div class="container-fluid">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
</div>
<!-- .navbar-collapse -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<form class="navbar-form navbar-left form-small" action="" method="get">
	<div class="form-group">
		<input type="text" class="form-control" name="srch" placeholder="Name, Code" style="width:250px;" >
	</div>	
	<button type="submit" class="btn btn-primary">Search</button> 
	<a href="stockledger.php" class="btn btn-purple"><i class="icon-list"></i> All</a> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '9', 'add' => '1'))) {	
echo '<button data-toggle="modal" class="btn btn-success" href="#addStockModal"><i class="icon-plus"></i> Add Stock</button> ';
	
}
echo '
	
	<button data-toggle="modal" class="btn bg--gray  box--shadow3" href="#CustomBalanceModal" style="color:#fff !important;"><i class="icon-print"></i> Stock Report</button> 
	<a href="stockledger.php?view=opening" class="btn btn-info"><i class="icon-list"></i> Opening Stocks</a> 
</form>

	
	

</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">';
if(!LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

//------------------------------------------------
	$stockconditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_name, ".ITEMS.".item_code, 
												SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as totalStockIn, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as totalStockOUT ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'not_equal' => array( 
													''.STOCK.'.id' 	=> 0 
												), 
								'search_by' 	=> $sql2,
								'group_by' 		=> ''.STOCK.'.id_item',
								'order_by' 		=> ''.ITEMS.'.item_name DESC ',
								'return_type' 	=> 'count' 
							); 
    $Stock 	= $dblms->getRows(STOCK, $stockconditions);

//--------------------------------------------------
	$count	 	= ($Stock);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= ($page - 1);							//previous page is page - 1
	$next 		= ($page + 1);							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
		$stockconditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_name, ".ITEMS.".item_code, 
												SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as totalStockIn, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as totalStockOUT ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'not_equal' => array( 
													''.STOCK.'.id' 	=> 0 
												), 
								'search_by' 	=> $sql2,
								'group_by' 		=> ''.STOCK.'.id_item',
								'order_by' 		=> ''.ITEMS.'.item_name DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
		$Stock 	= $dblms->getRows(STOCK, $stockconditions);	
//------------------------------------------------	
	
	$totalstockconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as AllStockIn, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as AllStockOUT ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'not_equal' => array( 
													''.STOCK.'.id' 	=> 0 
												), 
								'search_by' 	=> $sql2,
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut 	= $dblms->getRows(STOCK, $totalstockconditions);
	
echo '

<div class="row row-sm">

          <div class="col-lg-6 col-sm-6 col-xs-12"> </div>
		  
          <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="bg-teal rounded overflow-hidden">
              <div class="pd-25 d-flex align-items-center">
                <i class="icon-gift tx-40 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-15 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Items</p>
                  <p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$count.'</p>
                </div>
              </div>
            </div>
          </div>
		  <!-- col-3 -->
		  

          <div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
            <div class="bg-orange rounded overflow-hidden">
              <div class="pd-25 d-flex align-items-center">
                <i class="icon-gift tx-40 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-15 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Stock Avaiable</p>
                  <p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.number_format($resulttotalInOut['AllStockIn'] - $resulttotalInOut['AllStockOUT']).'</p>
                </div>
              </div>
            </div>
          </div>
		  <!-- col-3 -->
		  
		  
		  
        </div>
		<!-- row -->
<div class="widget">
<div class="widget-content">
';
	
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
	

//--------------------------------------------------
if (($count) > 0) {
//------------------------------------------------
echo '

<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th style="text-align:center;"> Item Code</th>
	<th> Item Name</th>
	<th style="text-align:center;"> Stock In</th>
	<th style="text-align:center;"> Stock Out</th>
	<th style="text-align:center;"> Balance</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
	
$totalStockIn 	= 0;
$totalStockOut 	= 0;
$totalbalance 	= 0;
//------------------------------------------------
foreach($Stock as $rowstd) {

//------------------------------------------------
$balance = ($rowstd['totalStockIn']  - $rowstd['totalStockOUT']);

$srno++;
echo '
<tr>
	<td style="width:60px; text-align:center;">'.$srno.'</td>
	<td style="width:80px; text-align:center;">'.$rowstd['item_code'].'</td>
	<td>'.$rowstd['item_name'].'</td>
	<td style="text-align:right; width:120px;">'.number_format($rowstd['totalStockIn']).'</td>
	<td style="text-align:right; width:120px;">'.number_format($rowstd['totalStockOUT']).'</td>
	<td style="text-align:right; width:120px;">'.number_format($balance).'</td>
	<td style="text-align:center;">
	<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Stock Ledger Detail</b>" data-src="stockledgerview.php?id='.$rowstd['item_id'].'" href="#"><i class="icon-zoom-in"></i></a>  <a class="btn btn-xs btn-information" href="stockledgerprint.php?id='.$rowstd['item_id'].'" target="_blank"><i class="icon-print"></i></a>
	</td>
</tr>';
	$totalbalance = ($totalbalance + $balance);
	$totalStockIn = ($totalStockIn + $rowstd['totalStockIn']);
	$totalStockOut = ($totalStockOut + $rowstd['totalStockOUT']);

//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="3" style="text-align:right;"> Total Receiveable</th>
	<th style="text-align:right;font-size:16px !important;">'.number_format($totalStockIn).'</th>
	<th style="text-align:right;font-size:16px !important;">'.number_format($totalStockOut).'</th>
	<th style="text-align:right;font-size:16px !important;">'.number_format($totalbalance).'</th>
	<th style="text-align:right;"></th>
</tr>
</thead>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('stockledger.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else {
	//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
} else if(LMS_VIEW == 'opening') {
	
	//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

//------------------------------------------------
	$stockconditions = array ( 
								'select' 	=> "".ITEMS.".item_id ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'where' => array ( 
													''.STOCK.'.remarks' => 'Opening Stock', 
													''.STOCK.'.stock_type' => 1
												 ), 
								'order_by' 		=> ''.ITEMS.'.item_name DESC ',
								'return_type' 	=> 'count' 
							); 
    $Stock 	= $dblms->getRows(STOCK, $stockconditions);

//--------------------------------------------------
	$count	 	= ($Stock);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
		$stockconditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_name, ".ITEMS.".item_code, 
												".STOCK.".id, ".STOCK.".qty, ".STOCK.".unitprice, ".STOCK.".dated",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'where' => array ( 
													''.STOCK.'.remarks' => 'Opening Stock', 
													''.STOCK.'.stock_type' => 1
												 ), 
								'order_by' 		=> ''.ITEMS.'.item_name DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
		$Stock 	= $dblms->getRows(STOCK, $stockconditions);	
//------------------------------------------------	
	
echo '

<div class="widget">
<div class="widget-content">
';
	
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
	

//--------------------------------------------------
if (($count) > 0) {
//------------------------------------------------
echo '

<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th style="text-align:center;"> Item Code</th>
	<th> Item Name</th>
	<th style="text-align:center;"> Opening Stock</th>
	<th style="text-align:center;"> Unit Price</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
	
$totalStockIn 	= 0;
$totalStockOut 	= 0;
$totalbalance 	= 0;
//------------------------------------------------
foreach($Stock as $rowstd) {

$srno++;
echo '
<tr>
	<td style="width:60px; text-align:center;">'.$srno.'</td>
	<td style="width:80px; text-align:center;">'.$rowstd['item_code'].'</td>
	<td>'.$rowstd['item_name'].'</td>
	<td style="text-align:right; width:120px;">'.number_format($rowstd['qty']).'</td>
	<td style="text-align:right; width:100px;">'.number_format($rowstd['unitprice']).'</td>
	<td style="text-align:center;">
	<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Item" data-height="350" data-width="100%" 
		data-stock-id 		= "'.$rowstd['id'].'"
		data-item-name 		= "'.$rowstd['item_code'].' - '.$rowstd['item_name'].'"
		data-stock-qty 		= "'.$rowstd['qty'].'"
		data-stock-unitprice = "'.$rowstd['unitprice'].'" 
		data-stock-dated 	= "'.$rowstd['dated'].'" 
		data-target="#editCountryModal">
			<i class="icon-pencil"></i>
		</a> 
	</td>
</tr>';


//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('stockledger.php?view=opening', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//-----------------------------------------
} else {
	//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
<!--WI_NOTIFICATION-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
	
	include_once("include/ledgers/stocks/add.php");
	include_once("include/ledgers/stocks/edit.php");
	include_once("include/ledgers/stocks/custombalanceModal.php");
	
echo '
<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>
    $("#id_item").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addStockform").validate({
		rules: {
             id_item			: "required",
			 stock_opening		: "required"
		},
		messages: {
			id_item		: "This field is required",
			stock_opening		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
//------------------------------------
} else { 
//------------------------------------
	header('location: index.php');
}
//------------------------------------
?>