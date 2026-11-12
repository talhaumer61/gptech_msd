<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA'] != 1) {  
	header('location: index.php');
} else { 
	include_once("include/purchase_invoice/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$vendor		= (isset($_GET['vendor']) && $_GET['vendor'] != '') ? $_GET['vendor'] : '';
//----------------------------------------
    if(($srch)) { 
        $sql2 	.= "AND (
                            i.purchaseinvoice_no LIKE '%".$srch."%' 
                            OR v.vendor_name LIKE '".$srch."'  
                        )";
        $sqlstring	.= "&srch=".$srch;
    }

	if(($vendor)) { 
        $sql2 	.= "AND i.id_vendor = '".$vendor."'";
        $sqlstring	.= "&vendor=".$vendor;
    }
//----------------------------------------
echo '<title>Manage Purchase Invoice - '.TITLE_HEADER.'</title>
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
		<select id="top-list1" data-placeholder="Company" name="company" style="width:250px;">
			<option></option>';
			 $sqllmsctop	= $dblms->querylms("SELECT company_id, company_name, company_code  
                                                    FROM ".COMPANY." 
                                                    WHERE company_id != '0' ORDER BY company_name ASC");
				$companyarray = array();
				while($valuectop 	= mysqli_fetch_array($sqllmsctop)) { 
					$companyarray[] = $valuectop;
					echo '<option value="'.$valuectop['company_id'].'">'.$valuectop['company_code'].' - '.$valuectop['company_name'].'</option>';
				}
echo '</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="purchase-invoice.php" class="btn btn-purple">
        <i class="icon-list"></i> All
    </a>
	<a class="btn btn-success" href="purchase-invoice.php?view=add">
        <i class="icon-plus"></i> Add Record
    </a>
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
//----------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}
//----------------------------------------------------------
	include_once("include/purchase_invoice/listVendor.php");
	include_once("include/purchase_invoice/listDetail.php");
    include_once("include/purchase_invoice/add.php");
    include_once("include/purchase_invoice/edit.php");
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
	function get_paymethoddetail(payment_method) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_paymethoddetail.php",  
            data: "payment_method="+payment_method,  
            success: function(msg){  
                $("#getpaymethoddetail").html(msg);
            }
        });  
    }
	function get_vendorpaymentdetail(id_vendor) {   
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_vendorpaymentdetail.php",  
            data: "id_vendor="+id_vendor,  
            success: function(msg){  
                $("#getvendorpaymentdetail").html(msg);
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
}
?>