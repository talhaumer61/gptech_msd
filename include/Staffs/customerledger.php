<?php 

if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '7')) { 

	include_once("ledgers/customers/query.php");

	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	
	if(($srch)) { 
		$sql2 		.= " AND (c.customer_name LIKE '%".$srch."%' 
							OR c.customer_cellno LIKE '".$srch."')";
		$sqlstring	.= "&srch=".$srch."";
	}
	
	// get all Customers
	$customersconditions = array ( 
								'select' 		=> 'customer_id, customer_name, customer_cellno ',
								'order_by' 		=> 'customer_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Customers = $dblms->getRows(CUSTOMERS, $customersconditions);
	

	echo '<title>Manage Customers Ledger  - '.TITLE_HEADER.'</title>
	<div class="matter">
		<div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<form class="navbar-form navbar-left form-small" action="" method="get">
						<div class="form-group">
							<input type="text" class="form-control" name="srch" placeholder="Name, Cell #" style="width:300px;" >
						</div>	
						<button type="submit" class="btn bg--info">Search</button>
						<a href="customerledger.php" class="btn btn-purple box--shadow3"><i class="icon-list"></i> All</a> ';
						
						if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '7', 'add' => '1'))) {	

							echo '<button data-toggle="modal" class="btn bg--indigo  box--shadow3" href="#addNewCountryModal" style="color:#fff !important;"><i class="icon-plus"></i> Add Balance</button> ';
						}
						echo '
						<button data-toggle="modal" class="btn bg--deep-purple box--shadow3" href="#CustomLedgerModal" style="color:#fff !important;"><i class="icon-calendar"></i> Custom Ledger</button> 
						<button data-toggle="modal" class="btn bg--gray  box--shadow3" href="#CustomBalanceModal" style="color:#fff !important;"><i class="icon-print"></i> Balance Report</button> 
						<button data-toggle="modal" class="btn bg--warning  box--shadow3" href="#BrandBalanceModal" style="color:#fff !important;"><i class="icon-print"></i> Brand Ledger</button>
					</form>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row fullscreen-mode">
				<div class="col-md-12">';

					$adjacents = 3;
					if(!($Limit)) 	{ $Limit = 1000; }
					if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

					$conditions = array ( 
											'select' 	=> "c.customer_id, 
															c.customer_name, 
															c.customer_cellno, 
															c.id_brand,
															COALESCE(SUM(CASE 
																WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
																THEN p.amount 
															END), 0) as totalreceivables, 
															COALESCE(SUM(CASE 
																WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
																THEN p.amount 
															END), 0) as totalpaid,
															(COALESCE(SUM(CASE 
																WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
																THEN p.amount 
															END), 0) 
															- 
															COALESCE(SUM(CASE 
																WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
																THEN p.amount 
															END), 0)) as balance",

											'join' 		=> "LEFT JOIN ".PAYMENTS." p ON c.customer_id = p.id_user AND p.status = 1",

											'where' 	=> array(
																	'c.customer_status'     => 1 // assuming you want only active customers
																),
											'search_by' 	=> $sql2,
											'group_by' 		=> 'c.customer_id',
											'order_by' 		=> 'balance DESC',
											'return_type' 	=> 'count'
										); 

					$Payments = $dblms->getRows(CUSTOMERS. ' c', $conditions);
					
					$count 		= $Payments;
					if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
					$prev 		= $page - 1;							//previous page is page - 1
					$next 		= $page + 1;							//next page is page + 1
					$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
					$lpm1 		= $lastpage - 1;

					$conditions['return_type'] = 'all';
					$Payments 	= $dblms->getRows(CUSTOMERS. ' c', $conditions);
					
					echo '

					<div class="row row-sm">
						
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="bg-teal rounded overflow-hidden">
								<div class="d-flex align-items-center" style="padding: 18px;">
									<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
									<div class="mg-l-20">
										<p class="tx-15 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Customers ('.$count.')</p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">MES: <span id="mgscust">0</span></p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">LHS: <span id="lhscust">0</span></p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">EDU & ONT: <span id="educust">0</span></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
							<div class="bg-br-primary rounded overflow-hidden">
								<div class="pd-25 d-flex align-items-center">
									<i class="icon-money tx-40 lh-0 tx-white op-7"></i>
									<div class="mg-l-20">
										<p class="tx-15 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Receivables</p>
										<p id="receivables" class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
							<div class="bg-orange rounded overflow-hidden">
								<div class="pd-25 d-flex align-items-center">
									<i class="icon-money tx-40 lh-0 tx-white op-7"></i>
									<div class="mg-l-20">
										<p class="tx-15 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Payables</p>
										<p id="payables" class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
							<div class="bg-danger rounded overflow-hidden">
								<div class="d-flex align-items-center" style="padding: 18px;">
									<i class="icon-money tx-40 lh-0 tx-white op-7"></i>
									<div class="mg-l-20">
										<p class="tx-15 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Brand</p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">MES: <span id="mgs">0</span></p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">LHS: <span id="lhs">0</span></p>
										<p class="tx-13 tx-mont tx-lato tx-white tx-bold mg-b-2 lh-1">EDU & ONT: <span id="edu">0</span></p>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="widget">
						<div class="widget-content">';

							if(isset($_SESSION['msg'])) { 
								echo $_SESSION['msg']['status'];
								unset($_SESSION['msg']);
							} 

							if (($count) > 0) {
								
								echo '
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="text-align:center;"> Sr.#</th>
											<th> Customer Name</th>
											<th> Cell #</th>
											<th style="text-align:center; font-weight:bold;">Receivables</th>
											<th style="text-align:center; font-weight:bold;">Payables</th>
											<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
										</tr>
									</thead>
									<tbody>';
										if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
										$totalbalance = 0;
										$mgscust = 0;
										$lhscust = 0;
										$educust = 0;

										foreach($Payments as $rowstd) {
											

											$balance = ($rowstd['totalreceivables']  - $rowstd['totalpaid']);

											if($rowstd['id_brand'] == '1'){
												$edutotaldebit = ($edutotaldebit + ((($balance)>=0) ? $balance : 0));
												$educust++;
											}elseif($rowstd['id_brand'] == '2'){
												$lhstotaldebit = ($lhstotaldebit + ((($balance)>=0) ? $balance : 0));
												$lhscust++;
											}elseif($rowstd['id_brand'] == '7'){
												$mgstotaldebit = ($mgstotaldebit + ((($balance)>=0) ? $balance : 0));
												$mgscust++;
											}

											$srno++;
											echo '
											<tr>
												<td style="width:50px; text-align:center;">'.$srno.'</td>
												<td>'.$rowstd['customer_name'].' </td>
												<td style="width:150px;"> '.$rowstd['customer_cellno'].'</td>
												<td style="text-align:right; width:110px;">'.((($balance)>=0) ? number_format($balance) : '---').'</td>
												<td style="text-align:right; width:110px;">'.((($balance)<0) ? number_format(ltrim($balance,'-')) : '---').'</td>
												<td style="text-align:center;">
												<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Customer Ledger Detail: '.$rowstd['customer_name'].'</b>" data-src="customerledgerview.php?id='.$rowstd['customer_id'].'" href="#"><i class="icon-zoom-in"></i></a> <a class="btn btn-xs btn-information" href="customerledgerprint.php?id='.$rowstd['customer_id'].'" target="_blank"><i class="icon-print"></i></a>
												</td>
											</tr>';
											$totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
    										$totalcrdit = ($totalcrdit + ((($balance)<0) ? ltrim($balance,'-') : 0));

										} 

										echo '
									</tbody>
									<thead>
										<tr>
											<th colspan="3" style="text-align:right;"> Grand Total</th>
											<th style="text-align:right;font-size:16px !important;">'.number_format($totaldebit).'</th>
											<th style="text-align:right;font-size:16px !important;">'.number_format($totalcrdit).'</th>
											<th style="text-align:right;"></th>
										</tr>
									</thead>
								</table>';

								echo $Pagination->get_Paginator('customerledger.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
								
							} else {
								
								echo '
								<div class="col-lg-12">
									<div class="widget-tabs-notification">No Result Found</div>
								</div>';

							}

							echo '
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
</div>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
include_once("ledgers/customers/add.php");
include_once("ledgers/customers/customledger.php");
include_once("ledgers/customers/customBalanceModel.php");
include_once("ledgers/customers/brandBalanceModel.php");
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
<script type="text/javascript" src="js/data.js"></script>
<!--JS_SELECT_LISTS-->
<script>
    $("#id_customer").select2({
        allowClear: true
    });	

	$("#custom_customer").select2({
        allowClear: true
    });
	$("#id_account_edit").select2({
        allowClear: true
    });
	$("#method").select2({
        allowClear: true
    });
	
	$("#id_bank").select2({
        allowClear: true
    });
	
	$("#id_paid_edit").select2({
        allowClear: true
    });
	$("#method_edit").select2({
        allowClear: true
    });
	
	$("#idbrand").select2({
        allowClear: true
    });

	$("#method-list").select2({
        allowClear: true
    });
	
	$("#customer-list").select2({
        allowClear: true
    });
</script>

<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
	$(\'#receivables\').text("'.number_format($totaldebit).'");
	$(\'#payables\').text("'.number_format($totalcrdit).'");
	$(\'#mgs\').text("'.number_format($mgstotaldebit).'");
	$(\'#lhs\').text("'.number_format($lhstotaldebit).'");
	$(\'#edu\').text("'.number_format($edutotaldebit).'");
	$(\'#educust\').text("'.number_format($educust).'");
	$(\'#mgscust\').text("'.number_format($mgscust).'");
	$(\'#lhscust\').text("'.number_format($lhscust).'");
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
} else { 
	header('location: index.php');
}
?>