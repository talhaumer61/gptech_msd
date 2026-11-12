<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '5')) { 
	include_once("include/payments/cheques/customers/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch 		= (isset($_REQUEST['srch']) && $_REQUEST['srch'] != '') ? $_REQUEST['srch'] : '';
	$customer 	= (isset($_REQUEST['customer']) && $_REQUEST['customer'] != '') ? $_REQUEST['customer'] : '';
	$status 	= (isset($_REQUEST['status']) && $_REQUEST['status'] != '') ? $_REQUEST['status'] : '';

//----------------------------------------
$sql13 		= '';
if(!$status) { 
	$sql13 		.= " AND b.cheque_status = '3'";
}
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (b.slipno LIKE '".$srch."' 
							OR b.amount = '".$srch."' )";
	$sqlstring	.= "&srch=".$srch."";
}

if(($customer)) { 
	$sql2 		.= " AND b.id_paid = '".$customer."'";
	$sqlstring	.= "&customer=".$$customer."";
}


if(($status)) { 
	$sql2 		.= " AND b.cheque_status = '".$status."'";
	$sqlstring	.= "&status=".$status."";
}
//----------------------------------------
echo '<title>Manage Customers Cheques - '.TITLE_HEADER.'</title>
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
		<select id="method-list" data-placeholder="Status" name="status" style="width:120px;">
			<option></option>';
			foreach($cheques as $itemcheques) {
				echo '<option value="'.$itemcheques['id'].'">'.$itemcheques['name'].'</option>';
			}
	echo '
		</select>
	</div>
	<div class="form-group">
		<select id="customer-list" data-placeholder="Customer" name="customer" style="width:220px;">
			<option></option>';
			$sqllmscus	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
													FROM ".CUSTOMERS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND customer_status = '1' ORDER BY customer_name ASC");
				while($valuecust 	= mysqli_fetch_array($sqllmscus)) {  
					echo '<option value="'.$valuecust['customer_id'].'">'.$valuecust['customer_name'].' - '.$valuecust['customer_cellno'].'</option>';
				}
	echo'
		</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="customercheques.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
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
	include_once("include/payments/cheques/customers/list.php");
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
//--------------------------------------------------------
	include_once("include/payments/cheques/customers/modal_edit.php");
//--------------------------------------------------------
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
    $("#id_paid").select2({
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
	
	$("#chequestatus_edit").select2({
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

function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("payid[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert("at least one checkbox should be selected");
	}
	return checked;
}

function onDelete()  {  
	if(confirm("Do you want to Clear Cheques?")==true)  {  
		return true;  
	}  else  {  
		return false;  
	}  
}  
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