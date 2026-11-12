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
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '35')) { 
//----------------------------------------
	include_once("include/payments/customersonline/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch 		= (isset($_REQUEST['srch']) && $_REQUEST['srch'] != '') ? $_REQUEST['srch'] : '';
	$customer 	= (isset($_REQUEST['customer']) && $_REQUEST['customer'] != '') ? $_REQUEST['customer'] : '';
	$method 	= (isset($_REQUEST['method']) && $_REQUEST['method'] != '') ? $_REQUEST['method'] : '';
//----------------------------------------
	$sql2 		.= " AND ".PAYMENTS.".pay_mode IN (4,6)";
if(($srch)) { 
	$sql2 		.= " AND (".PAYMENTS.".systemslip_no LIKE '%".$srch."' 
							OR ".PAYMENTS.".receipt_no LIKE '".$srch."' 
							OR ".PAYMENTS.".amount = '".$srch."' )";
	$sqlstring	.= "&srch=".$srch."";
}

if(($customer)) { 
	$sql2 		.= " AND ".PAYMENTS.".id_user = '".$customer."'";
	$sqlstring	.= "&customer=".$customer."";
}

if(($method)) { 
	$sql2 		.= " AND ".PAYMENTS.".pay_mode = '".$method."'";
	$sqlstring	.= "&method=".$method."";
}
// get all Customers
    $Customers 	= $mainclass->get_customers();
	$Paycats 	= $mainclass->get_paymentcategory();
//----------------------------------------
echo '<title>Manage Customer Online Payments - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:250px;" >
	</div>
	<div class="form-group">
		<select id="method-list" data-placeholder="Method" name="method" style="width:150px;">
			<option></option>';
			foreach($pay_types as $itempaytypes) { 
				if($itempaytypes['id']=='4') {
					echo ($itempaytypes['id'] == $method) ? '<option value="'.$itempaytypes['id'].'" selected>'.$itempaytypes['name'].'</option>' : '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
				}
			}
	echo '
		</select>
	</div>
	<div class="form-group">
		<select id="customer-list" data-placeholder="Customer" name="customer" style="width:300px;">
			<option></option>';

				foreach($Customers as $valuevendor) { 
					echo ($valuevendor['customer_id'] == $customer) ? '<option value="'.$valuevendor['customer_id'].'" selected>'.$valuevendor['customer_code'].' - '.$valuevendor['customer_name'].'</option>' : '<option value="'.$valuevendor['customer_id'].'">'.$valuevendor['customer_code'].' - '.$valuevendor['customer_name'].'</option>';	
				}
	echo'
		</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="customeronlinepayments.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
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
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
//------------------------------------------------
	include_once("include/payments/customersonline/list.php");
//	----------------------------------------------
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
//--------------------------------------------
	include_once("include/payments/customersonline/modal_edit.php");
//--------------------------------------------
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
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>
    $("#id_paid").select2({
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
	$("#id_cat_edit").select2({
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
	
	$("#customer-list").select2({
        allowClear: true
    });
	
	$("#method-list").select2({
        allowClear: true
    });
	$("#invoice-list").select2({
        allowClear: true
    });
	$("#method_modal").select2({
        allowClear: true
    });
	$("#id_paid_credit").select2({
        allowClear: true
    });
	$("#method_modalcredit").select2({
        allowClear: true
    });
	$("#method_modal_crnote").select2({
        allowClear: true
    });
	
	function get_bankaccounts(pmode) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_bankaccounts.php",  
            data: "pmode="+pmode,  
            success: function(msg){  
                $("#getbankaccounts").html(msg);
            }
        });  
    }

	function get_customerbalance(id_user) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_customerbalance.php",  
            data: "id_user="+id_user,  
            success: function(msg){  
                $("#getcustomerbalance").html(msg);
            }
        });  
    }
	
	function get_customerbalanceModal(id_user) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_customerbalanceModal.php",  
            data: "id_user="+id_user,  
            success: function(msg){  
                $("#getcustomerbalanceModal").html(msg);
            }
        });  
    }
	
	function get_customerbalanceCreditnote(id_user) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/customer/get_customerbalanceCreditnote.php",  
            data: "id_user="+id_user,  
            success: function(msg){  
                $("#getcustomerbalanceCreditnote").html(msg);
            }
        });  
    }
</script>

<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
      $("#customer_cnic").mask("99999-9999999-9");
      $("#customer_cnic_edit").mask("99999-9999999-9");
	  $("#vendor_cellno").mask("0399-9999999");
      $("#vendor_cellno_edit").mask("0399-9999999");

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
//------------------------------------
} else { 
//------------------------------------
	header('location: index.php');
}
//------------------------------------
?>