<?php 

if(($_SESSION['userlogininfo']['LOGINIDA'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '2')) { 
	
	include_once("sales_invoice/query.php");
	
	
	$sql2 		= '';
	$sqlstatus2 = '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	$sts  		= (isset($_GET['sts']) && $_GET['sts'] != '') ? $_GET['sts'] : '';
	$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';
	
    if(($srch)) { 
        $sql2 	.= "AND (
                            ".SALES_INVOICE.".salesinvoice_no LIKE '%".$srch."%' 
                            OR ".SALES_INVOICE.".total LIKE '".$srch."'
							OR ".SALES_INVOICE.".prev_balance LIKE '".$srch."'
							OR ".SALES_INVOICE.".paid LIKE '".$srch."'
                        )";
        $sqlstring	.= "&srch=".$srch;
    }
	
	if(($customer)) { 
		$sql2 		.= " AND ".SALES_INVOICE.".id_customer = '".$customer."'";
		$sqlstring	.= "&customer=".$customer;
	}
	
	if((!$sts)) { 
		$sql2		.= " AND ".SALES_INVOICE.".salesinvoice_status IN (3,4)";
		$sqlstring	.= "";
	}
	
	
	if(($sts)) { 
		if($sts == 'all') {
			$sql2 		.= "";
			$sqlstring	.= "&sts=".$sts;
		} else {
			$sql2 		.= " AND ".SALES_INVOICE.".salesinvoice_status = '".$sts."'";
			$sqlstring	.= "&sts=".$sts;
		}
	}
	
	// get all Customers
    $Customers 	= $mainclass->get_customers();
	
	echo '<title>Manage Sales Invoice Category - '.TITLE_HEADER.'</title>
	<div class="matter">
		<div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<form class="navbar-form navbar-left form-small" action="" method="get">
						<div class="form-group">
							<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:300px;" >
						</div>
						<div class="form-group">
							<select id="top-list1" data-placeholder="Customer" name="customer" style="width:300px;">
								<option></option>';
								foreach($Customers as $valuectop) {  
									echo ($valuectop['customer_id'] == $customer) ? '<option value="'.$valuectop['customer_id'].'" selected>'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>' : '<option value="'.$valuectop['customer_id'].'">'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>';
								}
								echo '
							</select>
						</div>
					
						<div class="form-group">
							<select id="top-list2" data-placeholder="Status" name="sts" style="width:170px;">
								<option></option>';
								// echo ($sts == 'all') ? '<option value="all" selected>All</option>' : '<option value="all">All</option>';
								foreach($saletypes as $listorderstatus) { 
									if($listorderstatus['id'] != '4' && ($listorderstatus['id'] ==  '3' || $listorderstatus['id'] ==  '5' || $listorderstatus['id'] ==  '1')) {
										echo ($listorderstatus['id'] == $sts) ? '<option value="'.$listorderstatus['id'].'" selected>'.$listorderstatus['name'].'</option>' : '<option value="'.$listorderstatus['id'].'">'.$listorderstatus['name'].'</option>';
									}
								}
								echo '
							</select>
							<script>
								$("#top-list2").select2({
									allowClear: true
								});	
							</script>
						</div>
						<button type="submit" class="btn btn-primary">Search</button>
						<a href="sales-invoice.php" class="btn btn-purple">
							<i class="icon-list"></i> All
						</a>
						<!--
						<a class="btn btn-success" href="sales-invoice.php?view=add">
							<i class="icon-plus"></i> Add Record
						</a>
						-->
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
								echo "<script language=\"javascript\">window.open(\"saleinvoiceprint.php?id=$printid\",\"_blank\");</script>";
							}

							include_once("sales_invoice/list.php");
							include_once("sales_invoice/add.php");
							include_once("sales_invoice/edit.php");
			
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

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
	
include_once("sales_invoice/dispatch-modal.php");
	
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
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script>
	jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
	  $("#dispatchcellno_edit").mask("0399-9999999");
        });
</script>
<script>

function getCustomerDetails(id_customer) {  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/getCustomerDetails.php",  
		data: "id_customer="+id_customer,  
		success: function(msg){  
			$("#getCustomerDetails").html(msg); 
		}
	});  
}
function getPrdValue(id_item, srno) {  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/getPrdValue.php",  
		data: "id_item="+id_item+"&srno="+srno,  
		success: function(msg){  
			$("#getPrdValue_"+srno).html(msg); 
		}
	});  
}


</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
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
