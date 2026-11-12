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
	
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) { 
	include_once("include/ledgers/vendors/query.php");
	include_once("include/header.php");
	
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	
	if(($srch)) { 
		$sql2 		.= " AND (".VENDORS.".vendor_name LIKE '%".$srch."%' 
							OR ".VENDORS.".vendor_cellno LIKE '".$srch."')";
		$sqlstring	.= "&srch=".$srch."";
	}
	
	// get all Vendors
	$Vendors		= $mainclass->get_vendors();
	

echo '<title>Manage Vendors Ledger  - '.TITLE_HEADER.'</title>
<div class="matter">
	<div class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<form class="navbar-form navbar-left form-small" action="" method="get">
							<div class="form-group">
								<input type="text" class="form-control" name="srch" placeholder="Name, Cell #" style="width:350px;" >
							</div>	
							<button type="submit" class="btn btn-primary">Search</button>
							<a href="vendorledger.php" class="btn btn-purple"><i class="icon-list"></i> All</a>  ';
							
							if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'add' => '1'))) {	
								echo '
								<button data-toggle="modal" class="btn btn-success box--shadow3" href="#addNewCountryModal"><i class="icon-plus"></i> Add Balance</button> ';
							}
							echo '	
							<!--a href="vendorsbalanceprint.php" class="btn btn-information" target="_blank"><i class="icon-print"></i> Balance Report</a--> 
							<button data-toggle="modal" class="btn bg--gray  box--shadow3" href="#CustomBalanceModal" style="color:#fff !important;"><i class="icon-print"></i> Balance Report</button> 
						</form>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row fullscreen-mode">
					<div class="col-md-12">';


						$payconditions = array ( 
													'select' 	=> 'SUM('.PAYMENTS.'.amount) AS totalpayable, 
																	'.VENDORS.'.vendor_id, '.VENDORS.'.vendor_name, '.VENDORS.'.vendor_cellno ',
													'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PAYMENTS.".id_user",
													'where' 	=> array( 
																		''.PAYMENTS.'.ledgerfor' 	=> 2, 
																		''.PAYMENTS.'.debit_credit' => 1 ,
																		''.VENDORS.'.vendor_status' => 1 
																	), 
													'search_by' 	=> $sql2,
													'group_by' 		=> ''.PAYMENTS.'.id_user',
													'order_by' 		=> 'totalpayable DESC ',
													'return_type' 	=> 'all' 
												); 
						$Payments 	= $dblms->getRows(PAYMENTS, $payconditions);
						
						
						$payableconditions = array ( 
													'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as totalpayable, 
																	SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as totalpaid",
													'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PAYMENTS.".id_user",
													'where' 	=> array( 
																		''.VENDORS.'.vendor_status' => 1 
																	), 
													'not_equal'	=> array( 
																		''.PAYMENTS.'.id' 	=> 0
																	), 
													'search_by' 	=> $sql2,
													'return_type' 	=> 'single' 
												); 
						$resulttotalpayable 	= $dblms->getRows(PAYMENTS, $payableconditions);
						

						echo '
						<div class="row row-sm">

								<div class="col-lg-6 col-sm-6 col-xs-12"> </div>
								
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="bg-teal rounded overflow-hidden">
									<div class="pd-25 d-flex align-items-center">
										<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
										<div class="mg-l-20">
										<p class="tx-15 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Vendors</p>
										<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.count($Payments).'</p>
										</div>
									</div>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
									<div class="bg-br-primary rounded overflow-hidden">
									<div class="pd-25 d-flex align-items-center">
										<i class="icon-money tx-40 lh-0 tx-white op-7"></i>
										<div class="mg-l-20">
										<p class="tx-15 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Balance </p>
										<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.number_format($resulttotalpayable['totalpayable'] - $resulttotalpayable['totalpaid']).'</p>
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

										if (!empty($Payments)) {
											echo '
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="text-align:center;"> Sr.#</th>
														<th> Vendor Name</th>
														<th style="text-align:right;"> Balance</th>
														<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
													</tr>
												</thead>
												<tbody>';
													$srno = 0;
													$totalbalance = 0;

													foreach($Payments as $rowstd) { 
														
														$paidconditions = array ( 
																					'select' 	=> "SUM(amount) AS totalpaid",
																					'where' 	=> array( 
																										'id_user' 		=> cleanvars($rowstd['vendor_id']),
																										'ledgerfor' 	=> 2,
																										'debit_credit' 	=> 2
																									), 
																					'return_type' 	=> 'single' 
																				); 
														$rowspaid 	= $dblms->getRows(PAYMENTS, $paidconditions);
															
														$balance = ($rowstd['totalpayable']  - $rowspaid['totalpaid']);

														$srno++;
														echo '
														<tr>
															<td style="width:50px; text-align:center;">'.$srno.'</td>
															<td>'.$rowstd['vendor_name'].' '.$rowstd['vendor_cellno'].'</td>
															<td style="text-align:right; width:120px;">'.number_format($balance).'</td>
															<td style="text-align:center;">
															<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Vendor Ledger Detail: '.$rowstd['vendor_name'].'</b>" data-src="vendorledgerview.php?id='.$rowstd['vendor_id'].'" href="#"><i class="icon-zoom-in"></i></a> <a class="btn btn-xs btn-information" href="vendorledgerprint.php?id='.$rowstd['vendor_id'].'" target="_blank"><i class="icon-print"></i></a>
															</td>
														</tr>';
														$totalbalance = ($totalbalance + $balance);
													}
													echo '
												</tbody>
												<thead>
													<tr>
														<th colspan="2" style="text-align:right;"> Total Receiveable</th>
														<th style="text-align:right;">'.number_format($totalbalance).'</th>
														<th style="text-align:right;"></th>
													</tr>
												</thead>
											</table>';
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
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
include_once("include/ledgers/vendors/add.php");
include_once("include/ledgers/vendors/custombalanceModal.php");
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
    $("#id_vendor").select2({
        allowClear: true
    });	

	$("#id_account").select2({
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
	
	$("#id_bank_edit").select2({
        allowClear: true
    });

	$("#method-list").select2({
        allowClear: true
    });
	
	$("#customer-list").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             id_paid	: "required",
			 method		: "required"
		},
		messages: {
			id_paid		: "This field is required",
			method		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             id_paid_edit	: "required",
			 method_edit	: "required"
		},
		messages: {
			id_paid_edit	: "This field is required",
			method_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var dated_edit 				= $(this).attr("data-com-dated");
        var id_paid_edit 			= $(this).attr("data-com-paid");
		var slipno_edit 			= $(this).attr("data-com-slipno");
		var amount_edit 			= $(this).attr("data-com-amount");
		var method_edit 			= $(this).attr("data-com-method");
		var cheque_edit 			= $(this).attr("data-com-cheque");
		var cheque_date_edit 		= $(this).attr("data-com-chequedate");
		var id_bank_edit 			= $(this).attr("data-com-bank");
		var id_account_edit 		= $(this).attr("data-com-account");
		var remarks_edit 			= $(this).attr("data-com-remarks");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")			.val(dated_edit);
		$("#slipno_edit")			.val(slipno_edit);
		$("#amount_edit")			.val(amount_edit);
		$("#cheque_edit")			.val(cheque_edit);
		$("#cheque_date_edit")		.val(cheque_date_edit);
		$("#remarks_edit")			.val(remarks_edit);
		$("#id_edit")				.val(id_edit);

       //pre-select data in pull down lists
       $("#id_paid_edit")			.select2().select2("val", id_paid_edit); 
	   $("#method_edit")			.select2().select2("val", method_edit); 
	   $("#id_bank_edit")			.select2().select2("val", id_bank_edit); 
	   $("#id_account_edit")		.select2().select2("val", id_account_edit); 
  });
    
});
</script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
      $("#customer_cnic").mask("99999-9999999-9");
      $("#customer_cnic_edit").mask("99999-9999999-9");
	  $("#customer_cellno").mask("0399-9999999");
      $("#customer_cellno_edit").mask("0399-9999999");

        });
</script>
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

} else { 
	
	header('location: index.php');
}

?>