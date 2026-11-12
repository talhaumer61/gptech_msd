<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	include "functions/db_functions.php";
	$mainclass	= new main();
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '9')) { 
//----------------------------------------
	include_once("include/sales/invoices/query.php");
	include_once("include/header.php");
	// get Item Catgories
	$Itemcats	= $mainclass->get_itemcategories();
	// get all Customers
    $Customers 	= $mainclass->get_customers();
	// get all Items
	$Items		= $mainclass->get_items();
	// get all Company
	$Company	= $mainclass->get_companies();
//----------------------------------------
echo '<title>Manage Reports - '.TITLE_HEADER.'</title>
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
	<div class="headerbar-project-title pull-left">
		<h3 style="color:#555;">Reports</h3>
	</div>
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

if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '20')) { 

echo '
<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--blue  box--shadow3"><b><i class="icon-foler-open"></i> Sales / Return Reports</b> </div>
				<div class="box-content">
					<ul>
						<!-- li><a data-toggle="modal" href="#byCustomersummarydateSaleModal">By Customer Summary (Date Wise) </a></li>
						<li><a data-toggle="modal" href="#byCustomerdetaildateSaleModal">By Customer Detail (Date Wise)</a></li>
						<li><a data-toggle="modal" href="#departmentSummarySaleModal">By Department Summary</a></li>
						<li><a data-toggle="modal" href="#departmentDetailSaleModal">By Department Detail</a></li>
						<li><a data-toggle="modal" href="#zoneSummaryModal"> By Zone Summary</a></li>
						<li><a data-toggle="modal" href="#zoneDetailModal"> By Zone Detail</a></li>
						<li><a data-toggle="modal" href="#brandSummaryModal"> By Brands Summary</a></li>
						<li><a data-toggle="modal" href="#brandDetailModal"> By Brands Detail</a></li -->
						<li><a data-toggle="modal" href="#companySummaryModal"> Zone-wise Sale Summary</a></li>
						<li><a data-toggle="modal" href="#companyDetailModal"> Zone-wise Sale Detail</a></li>
						<!-- li><a data-toggle="modal" href="#companyCategorysaleSummaryModal"> Category wise Company Sales</a></li -->
						<li><a data-toggle="modal" href="#companyRetrunSummaryModal"> Zone-wise Sale Return Summary</a></li>
						<li><a data-toggle="modal" href="#companyReturnDetailModal"> Zone-wise Sale Return Detail</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- WI_Menu -->';
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '22')) { 

echo '
<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--deep-purple box--shadow3"><b><i class="icon-foler-open"></i> Stocks Reports</b> </div>
				<div class="box-content">
					<!-- ul>
						<li><a data-toggle="modal" href="#belowReorderModal"> Below Re-order Level</a></li>
						<li><a data-toggle="modal" href="#equalReorderModal"> Equal Re-order Level</a></li>
						<li><a data-toggle="modal" href="#upperLimitModal"> Maximum Stock (Upper Limit)</a></li>
						<li><a data-toggle="modal" href="#stockBalanceModal"> Stock Balance Report</a></li>
						<li><a data-toggle="modal" href="#stockAgingdateModal"> Stock Aging (Date wise) Report</a></li>
						<li><a data-toggle="modal" href="#stockAgingmonthModal"> Stock Aging (Month wise) Report</a></li>
					</ul -->
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--green box--shadow3"><b><i class="icon-foler-open"></i> Dispatch Reports</b> </div>
				<div class="box-content">
					<!-- ul>
						<li><a data-toggle="modal" href="#dispatchInvoicesModal"> Invoices Report</a></li>
						<li><a data-toggle="modal" href="#dispatchDonGiftsModal"> Donations / Gifts Report</a></li>
					</ul -->
				</div>
			</div>
		</div>
	</div>

</div>
<!-- WI_Menu -->';
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '23')) { 


echo '
<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--teal box--shadow3"><b><i class="icon-foler-open"></i> Customer Ledgers</b> </div>
				<div class="box-content">
					<ul>
						<!-- li><a data-toggle="modal" href="#customerLedgerModal"> Customers Ledger</a></li>
						<li><a data-toggle="modal" href="#balancesheetModal"> Balance Sheet</a></li>
						<li><a data-toggle="modal" href="#balancesheetBrandsummaryModal"> Brands wise Balance Sheet Summary</a></li>
						<li><a data-toggle="modal" href="#balancesheetBranddetailModal"> Brands wise Balance Sheet Detail</a></li>
						<li><a data-toggle="modal" href="#balancesheetZonesummaryModal"> Zone wise Balance Sheet Summary</a></li>
						<li><a data-toggle="modal" href="#balancesheetZonedetailModal"> Zone wise Balance Sheet Detail</a></li -->
						<li><a data-toggle="modal" href="#balancesheetCompanysummaryModal"> Zone-wise Balance Summary</a></li>
						<li><a data-toggle="modal" href="#balancesheetCompanydetailModal"> Zone wise Balance Detail Report</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--red box--shadow3"><b><i class="icon-foler-open"></i> Purchase Reports</b> </div>
				<div class="box-content">
					<!-- ul>
						<li><a data-toggle="modal" href="#purchaseCategoryModal"> Category wise Report</a></li>
						<li><a data-toggle="modal" href="#purchaseCategoryGRNModal"> Category wise GRN Report</a></li>
						<li><a data-toggle="modal" href="#dispatchDonGiftsModal"> Donations / Gifts Report</a></li>
					</ul -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- WI_Menu -->';
}

echo '<div style="clear:both;"></div>';
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '25')) { 

echo '

<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--dark box--shadow3"><b><i class="icon-foler-open"></i> Collection Reports</b> </div>
				<div class="box-content">
					<ul>
						<li><a data-toggle="modal" href="#cashbankCollectionsummaryModal"> Zone-wise Collection Summary</a></li>
						<li><a data-toggle="modal" href="#cashbankCollectiondetailModal"> Zone-wise Collection Detail</a></li>
						<!-- li><a data-toggle="modal" href="#collectionBrandsummaryModal"> Brand Wise Collections</a></li>
						<li><a data-toggle="modal" href="#collectionZonesummaryModal"> Zone Wise Collections</a></li>
						<li><a data-toggle="modal" href="#collectionCompanysummaryModal"> Company Wise Collections</a></li -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- WI_Menu -->';
}

if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '30')) { 

echo '

<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--black box--shadow3"><b><i class="icon-foler-open"></i> Item Reports</b> </div>
				<div class="box-content">
					<!-- ul>
						<li><a data-toggle="modal" href="#topSalesModal"> Top Sale Items</a></li>
						<li><a data-toggle="modal" href="#lowestSalesModal"> Lowest Sale Items</a></li>
						<li><a data-toggle="modal" href="#zonewiseSalesModal"> Zone Wise Sale Items</a></li>
						<li><a data-toggle="modal" href="#brandwiseSalesModal"> Brands Wise Sale Items</a></li>
						<li><a data-toggle="modal" href="#companywiseSalesModal">Company Wise Sale Items</a></li>
						<li><a data-toggle="modal" href="#zoneitemcategorySalesModal">Zone Items Category Sales</a></li>
					</ul -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- WI_Menu -->';
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '25')) { 

echo '

<!--WI_Menu-->
<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark bg--pink box--shadow3"><b><i class="icon-foler-open"></i> Sales & CGS Reports</b> </div>
				<div class="box-content">
					<!-- ul>
						<li><a data-toggle="modal" href="#cgsBrandsummaryModal"> Brand Wise Summary</a></li>
						<li><a data-toggle="modal" href="#cgsBranddetailModal"> Brand Wise Detail</a></li>
						<li><a data-toggle="modal" href="#cgsCategorydetailModal"> Category wise Company Gross Income Summary</a></li>
					</ul -->
				</div>
			</div>
		</div>
	</div>
	
	
</div>
<!-- WI_Menu -->';
}
echo '

<div style="clear:both;"></div>


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
//------------------------------------------------
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '20')) { 
	// Stock Modals
	include_once("include/reports/modals/modal_belowReorder.php");
	include_once("include/reports/modals/modal_equalReorder.php");
	include_once("include/reports/modals/modal_upperlimit.php");
	include_once("include/reports/modals/modal_stockbalance.php");
	include_once("include/reports/modals/modal_stockcategoryaging.php");
	include_once("include/reports/modals/modal_stockcategorymonthly.php");
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '22')) { 
	//sales Modals
	include_once("include/reports/modals/modal_salescustomersummarydatewise.php");
	include_once("include/reports/modals/modal_salescustomerdetaildatewise.php");
	include_once("include/reports/modals/modal_salesdepartmentsummary.php");
	include_once("include/reports/modals/modal_salesdepartmentdetail.php");
	include_once("include/reports/modals/modal_saleszonesummary.php");
	include_once("include/reports/modals/modal_saleszonedetail.php");
	include_once("include/reports/modals/modal_salesbrandsummary.php");
	include_once("include/reports/modals/modal_salesbranddetail.php");
	include_once("include/reports/modals/modal_salescompanysummary.php");
	include_once("include/reports/modals/modal_salescompanydetail.php");
	include_once("include/reports/modals/modal_salesreturncompanysummary.php");
	include_once("include/reports/modals/modal_salesreturncompanydetail.php");
	include_once("include/reports/modals/modal_salescategorycompanydetail.php");
	// dispatch Modals
	include_once("include/reports/modals/modal_dispatchinvoices.php");
	include_once("include/reports/modals/modal_dispatchdonationsgifts.php");
	
	
}

if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '23')) { 	
// balance sheets

	include_once("include/reports/modals/modal_customerledger.php");
	include_once("include/reports/modals/modal_balancesheet.php");
	include_once("include/reports/modals/modal_balancebranddetail.php");
	include_once("include/reports/modals/modal_balancebrandsummary.php");
	include_once("include/reports/modals/modal_balancezonedetail.php");
	include_once("include/reports/modals/modal_balancezonesummary.php");
	include_once("include/reports/modals/modal_balancecompanydetail.php");
	include_once("include/reports/modals/modal_balancecompanysummary.php");
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '25')) { 	
// Collection reports

	include_once("include/reports/modals/modal_cashbankcollectionsummary.php");
	include_once("include/reports/modals/modal_cashbankcollectiondetail.php");
	include_once("include/reports/modals/modal_collectionbrandsummary.php");
	include_once("include/reports/modals/modal_collectionzonesummary.php");
	include_once("include/reports/modals/modal_collectioncompanysummary.php");
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '25')) { 	
// CGS reports

	include_once("include/reports/modals/modal_cgsbrandsummary.php");
	include_once("include/reports/modals/modal_cgsbranddetail.php");
	include_once("include/reports/modals/modal_cgscatgorydetail.php");
}
	
if( ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '30')) { 	
// Items reports

	include_once("include/reports/items/modals/modal_topSales.php");
	include_once("include/reports/items/modals/modal_lowestSales.php");
	include_once("include/reports/items/modals/modal_zonewiseSales.php");
	include_once("include/reports/items/modals/modal_brandwiseSales.php");
	include_once("include/reports/items/modals/modal_companywiseSales.php");
	include_once("include/reports/items/modals/modal_zoneitemcategorySales.php");
}
	
include_once("include/reports/items/modals/modal_purchaseCategory.php");
include_once("include/reports/items/modals/modal_purchaseGrnCategory.php");
//------------------------------------------------
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

	function get_categoryitemsforpurchase(idcat) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_categoryitemsforpurchase.php",  
			data: "idcat="+idcat,  
			success: function(msg){  
				$("#getcategoryitemsforpurchase").html(msg); 
			}
		});  
	}
	function get_categoryitemsforpurchasern(idcat) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_categoryitemsforpurchase.php",  
			data: "idcatgrn="+idcat,  
			success: function(msg){  
				$("#getcategoryitemsforpurchasegrn").html(msg); 
			}
		});  
	}
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