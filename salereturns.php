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
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '3')) { 
	include_once("include/sales/salereturns/query.php");
	include_once("include/header.php");
//----------------------------------------
$sql2 		= '';
$sqlstring	= "";
$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
$customer  	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (".SALES_RETURNS.".job_order_no LIKE '%".$srch."%' OR ".CUSTOMERS.".customer_name LIKE '%".$srch."%' 
							OR ".CUSTOMERS.".customer_cellno LIKE '%".$srch."%' 
							OR ".SALES_RETURNS.".total LIKE '".$srch."' 
							OR ".SALES_RETURNS.".deducation_amount LIKE '".$srch."' 
						)";
	$sqlstring	.= "&srch=".$srch;
}
//----------------------------------------
if(($customer)) { 
	$sql2 		.= " AND ".SALES_RETURNS.".id_customer = '".$customer."'";
	$sqlstring	.= "&customer=".$customer;
}
// get all Customers
    $Customers 	= $mainclass->get_customers();
// get all Items
	$Items		= $mainclass->get_items();
//----------------------------------------
echo '<title>Manage Sales Return - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Job#, Name" style="width:300px;" >
	</div>	
	<div class="form-group">
		<select id="top-list1" data-placeholder="Customer" name="customer" style="width:300px;">
			<option></option>';
				foreach($Customers as $valuectop) {  
					echo ($valuectop['customer_id'] == $customer) ? '<option value="'.$valuectop['customer_id'].'" selected>'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>' : '<option value="'.$valuectop['customer_id'].'">'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>';
				}
echo '</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="salereturns.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '3', 'add' => '1'))) { 
	echo ' <a class="btn btn-success" href="salereturns.php?view=add"><i class="icon-plus"></i> Add Record</a>';
}
//--------------------------------------------
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
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
	echo "<script language=\"javascript\">window.open(\"salesreturnprint.php?id=$printid\",\"_blank\");</script>";
}
//--------------------------------------
include_once("include/sales/salereturns/list.php");
include_once("include/sales/salereturns/add.php");
include_once("include/sales/salereturns/edit.php");
//--------------------------------------
echo '
<script>
	$(".select2").select2({
		allowClear: true
	});
    $("#order_status").select2({
        allowClear: true
    });
	
	$("#job_for").select2({
        allowClear: true
    });
	
	$("#customer").select2({
        allowClear: true
    });
	
	$("#top-list1").select2({
        allowClear: true
    });
	
	$("#top-list2").select2({
        allowClear: true
    });
	$("#top-list3").select2({
        allowClear: true
    });
	$("#top-list4").select2({
        allowClear: true
    });
	
</script>

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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script>
	function getReturnPrdValue(id_item, id_customer, srno) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getReturnPrdValue.php",  
			data: "id_item="+id_item+"&id_customer="+id_customer+"&srno="+srno,  
			success: function(msg){  
				$("#getReturnPrdValue_"+srno).html(msg); 
			}
		});  
	}
</script>
<script src="js/salesreturn.js"></script>

<!--JS_SELECT_LISTS-->
<script>
    $("#order_status").select2({
        allowClear: true
    });
	$("#order_status_edit").select2({
        allowClear: true
    });
	
	 $("#status_edit").select2({
        allowClear: true
    });
	$("#order_status_edit").select2({
        allowClear: true
    });
	
	$("#id_designation").select2({
        allowClear: true
    });
	
	$("#id_designation_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
	$().ready(function() {
		$("#addNewCountry").validate({
			rules: {
				emply_name		: "required",
				emply_status		: "required"
			},
			messages: {
				emply_name		: "This field is required",
				emply_status		: "This field is required"
			},
			submitHandler: function(form) {
			form.submit();
			}
		});
	});
	$(document).ready(function(){
		$(".pickdmy").datepicker({
		format: "dd-mm-yyyy",
		language: "lang",
		autoclose: true,
		todayHighlight: true
		});	
	});
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             emply_name_edit		: "required",
			 emply_status_edit	: "required"
		},
		messages: {
			emply_name_edit		: "This field is required",
			emply_status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>

<script type="text/javascript" src="js/regularnewclients.js"></script>
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