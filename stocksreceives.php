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
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '19')) { 
	
	include_once("include/stocksreceives/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$vendor		= (isset($_GET['vendor']) && $_GET['vendor'] != '') ? $_GET['vendor'] : '';
	$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';
//----------------------------------------
    if(($srch)) { 
        $sql2 	.= "AND (
                            ".PURCHASE_ORDER.".po_order_no LIKE '".$srch."' 
                            OR  ".STOCK.".grn LIKE '".$srch."'  
                        )";
        $sqlstring	.= "&srch=".$srch;
    }
//----------------------------------------
    if(($vendor)) { 
        $sql2 	.= "AND ".VENDORS.".vendor_id = '".$vendor."'";
        $sqlstring	.= "&vendor=".$vendor;
    }
	
// get all Vendors
    $Vendors 	= $mainclass->get_vendors();	
//----------------------------------------
echo '<title>Goods Received Note  - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:300px;" >
	</div>
	<div class="form-group">
		<select id="top-list1" data-placeholder="Vendors" name="vendor" style="width:300px;">
			<option></option>';

				foreach($Vendors as $listvends) { 
					echo '<option value="'.$listvends['vendor_id'].'">'.$listvends['vendor_name'].' - '.$listvends['vendor_cellno'].'</option>';
				}
echo '</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="stocksreceives.php" class="btn btn-purple">
        <i class="icon-list"></i> All
    </a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) { 	
	echo '<a class="btn btn-warning" href="stocksreceives.php?view=addstock"><i class="icon-plus"></i> Add Stock in</a> ';
}
echo '
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
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//----------------------------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
	echo "<script language=\"javascript\">window.open(\"stocksreceivesprint.php?grn=$printid\",\"_blank\");</script>";
}
//----------------------------------------------------------
    include_once("include/stocksreceives/list.php");
    include_once("include/stocksreceives/addStock.php");
    include_once("include/stocksreceives/edit.php");

//----------------------------------------------------------
echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->   
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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->

<script src="js/stockin.js"></script>
<script>
	function get_vendordetail(id_vendor) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_vendordetail.php",  
			data: "id_vendor="+id_vendor,  
			success: function(msg){  
				$("#getVendorDetails").html(msg); 
			}
		});  
	}
	function get_vendororder(id_vendor) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_vendororders.php",  
			data: "id_vendor="+id_vendor,  
			success: function(msg){  
				$("#getVendorOrders").html(msg); 
			}
		});  
	}
	function get_vendororderdetail(vendor_order) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_vendororderdetails.php",  
			data: "vendor_order="+vendor_order,  
			success: function(msg){  
				$("#getVendorOrderDetail").html(msg); 
			}
		});  
	}

</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
    $("#top-list1").select2({
        allowClear: true
    });	
</script>
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