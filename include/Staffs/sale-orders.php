<?php 

if(($_SESSION['userlogininfo']['LOGINIDA'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '1')) { 

	include_once("joborders/query.php");
	
	$mainclass->deleteolderjoborders();
	
	$sql2 		= '';
	$sqlstatus2 = '';
	$sqlstring	= "";
	$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer  	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	$sts  		= (isset($_GET['sts']) && $_GET['sts'] != '') ? $_GET['sts'] : '';
	$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (".JOB_ORDER.".job_order_no LIKE '".$srch."' OR ".CUSTOMERS.".customer_name LIKE '%".$srch."%' 
								OR ".CUSTOMERS.".customer_cellno LIKE '%".$srch."%' 
								OR ".JOB_ORDER.".total LIKE '".$srch."' 
								OR ".JOB_ORDER.".opening_balance LIKE '".$srch."' 
								OR ".JOB_ORDER.".advance LIKE '".$srch."' 
								OR ".JOB_ORDER.".grand_total LIKE '".$srch."' 
							)";
		$sqlstring	.= "&srch=".$srch;
	}

	if(($customer)) { 
		$sql2 		.= " AND ".JOB_ORDER.".id_customer = '".$customer."'";
		$sqlstring	.= "&customer=".$customer;
	}
	

	if((!$sts)) { 
		$sql2		.= " AND ".JOB_ORDER.".job_order_status IN (1,2)";
		$sqlstring	.= "";
	}
		

	if(($sts)) { 
		if($sts == 'all') {
			$sql2 		.= "";
			$sqlstring	.= "&sts=".$sts;
		} else {
			$sql2 		.= " AND ".JOB_ORDER.".job_order_status = '".$sts."'";
			$sqlstring	.= "&sts=".$sts;
		}
	}
	
	// get all Customers
    $Customers 	= $mainclass->get_customers();
	// get all Items
	$Items		= $mainclass->get_items();
	// get all Packaeges
	$Packages	= $mainclass->get_packages();
	
echo '<title>Manage Job Orders - '.TITLE_HEADER.'</title>

<div class="matter">

	<div class="navbar navbar-default" role="navigation">

		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<form class="navbar-form navbar-left form-small" action="" method="get">
					<div class="form-group">
						<input type="text" class="form-control" name="srch" placeholder="Job#, Name" style="width:350px;" >
					</div>	
					<div class="form-group">
						<select id="top-list1" class="select2" data-placeholder="Customer" name="customer" style="width:350px;">
							<option></option>';

							foreach($Customers as $valuectop) {  
								echo ($valuectop['customer_id'] == $customer) ? '<option value="'.$valuectop['customer_id'].'" selected>'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>' : '<option value="'.$valuectop['customer_id'].'">'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>';
							}
							echo '
						</select>
					</div>
					
					<div class="form-group">
						<select id="top-list2" class="select2" data-placeholder="Status" name="sts" style="width:170px;">
							<option></option>';
							echo ($sts == 'all') ? '<option value="all" selected>All</option>' : '<option value="all">All</option>';
							foreach($orders as $listorderstatus) { 
								echo ($listorderstatus['id'] == $sts) ? '<option value="'.$listorderstatus['id'].'" selected>'.$listorderstatus['name'].'</option>' : '<option value="'.$listorderstatus['id'].'">'.$listorderstatus['name'].'</option>';
							}
							echo '
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Search</button>
					<a href="sale-orders.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
					
					if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '1', 'add' => '1'))) { 
						echo ' <a class="btn btn-success" href="sale-orders.php?view=add"><i class="icon-plus"></i> Add Job Order</a>';
					}

					echo '	
				</form>
			</div>
			
		</div>

	</div>
	
	<div class="container">
	
		<div class="row fullscreen-mode">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-content">';
					
						if(isset($_SESSION['msg'])) { 
							echo $_SESSION['msg']['status'];
							unset($_SESSION['msg']);
							echo "<script language=\"javascript\">window.open(\"ordersprint.php?id=$printid\",\"_blank\");</script>";
						}
						
						include_once("joborders/list.php");
						include_once("joborders/add.php");
						include_once("joborders/newadd.php");
						include_once("joborders/addcopied.php");
						include_once("joborders/edit.php");
						
						echo '

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
<script src="js/joborder.js"></script>
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
	function getPrdValue(id_item, srno) {  
		// only proceed if an item is actually selected
		if (!id_item || id_item === "") return;

		var idcustomer = $("#id_customer").val(); 
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getPrdValue.php",  
			data: "idcustomer="+idcustomer+"&id_item="+id_item+"&srno="+srno,  
			success: function(msg){ 
				$("#getPrdValue_"+srno).html(msg); 
			}
		});  
	}
	function getBagpackValue(id_package, srno) {  
		// only proceed if a package is actually selected
		if (!id_package || id_package === "") return;
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getBagpackValue.php",  
			data: "id_package="+id_package+"&srno="+srno,  
			success: function(msg){ 
				$("#getPrdValue_"+srno).html(msg); 
			}
		});  
	}
	function numberWithCommas(field) {
			let element = document.getElementById(field.id);
			let amount = element.value.replace(/,/g, \'\');
			if(amount.charAt(0)==\'-\'){
				amount = \'-\'+amount.substring(1).replace(/-/g, \'\');
			}else{
				amount = amount.replace(/-/g, \'\');
			}
			element.value = amount.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).ready(function(){  
		// Accept Only Numbers, Commas & (-) Minus Sign
		$(".numbers").on("keypress keyup blur",function (event) {    
			$(this).val($(this).val().replace(/[^-\d,]+/g, ""));
			if ((event.which < 48 || event.which > 57) && event.which!=44  && event.which!=45 ) {
				event.preventDefault();
				return false;
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
