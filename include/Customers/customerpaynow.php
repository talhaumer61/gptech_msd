<?php 
//----------------------------------------
echo '<title>Online Payment  - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_HEADING_BAR-->
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="images/default.png" alt=""/></div>
	<div class="headerbar-project-title pull-left">
		<h3>Online Payment</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINNAME'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<!--WI_HEADING_BAR-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//------------------------------------------------
	$debitcreditconditions = array ( 
								'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
													".CUSTOMERS.".customer_id, ".CUSTOMERS.".customer_code, ".CUSTOMERS.".customer_name, 
													".CUSTOMERS.".customer_personcell, ".CUSTOMERS.".customer_cellno, ".CUSTOMERS.".customer_email, ".ADES.".ade_id, 
													".ADES.".ade_name, ".ADES.".ade_cellno, ".COMPANY.".company_id, ".COMPANY.".company_name",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user
													INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
													INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' 		=> array ( 
															  ''.PAYMENTS.'.status' => 1
															, ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
														), 
								'return_type' 	=> 'single' 
							); 
    $rowstd 		= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance = ($rowstd['TotalDebit'] - $rowstd['TotalCredit']);

	if($rowstd['customer_email']){
		$emailaddress = $rowstd['customer_email'];
	} else {
		$emailaddress = SALES_EMAIL;
	}

	if($rowstd['customer_cellno']) {
		$cellno = $rowstd['customer_cellno'];
	} else if($rowstd['customer_personcell']) {
		$cellno = $rowstd['customer_personcell'];
	} else {
		$cellno = SALES_CELLNO;
	}
//------------------------------------------------
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%">
<form class="form-horizontal" action="'.SITE_URL.'/PayFast/" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="customer_email" name="customer_email" value="'.$emailaddress.'">
<input type="hidden" name="customer_cellno" name="customer_cellno" value="'.$cellno.'">
<input type="hidden" name="customer_id" name="customer_id" value="'.$rowstd['customer_id'].'">
<input type="hidden" name="customer_name" name="customer_name" value="'.$rowstd['customer_name'].'">
<input type="hidden" name="control" name="control" value="customerpayment">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'customerledger.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Online Payment Detail</h4>
	</div>

<div class="modal-body">
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<input type="text" class="form-control" id="customername" name="customername" required value="'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
		</div> 
	</div>


	<div class="col-sm-41">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>

	<div style="clear:both;padding:5px;"></div>
	<div class="col-sm-41">
		
	</div>
	<div class="col-sm-81">
		<div class="col-lg-12 heading-modal" style="margin-top:20px;  font-weight:600;">Payment Details</div>
	</div>
	<div class="col-sm-41">
		
	</div>
	<div class="col-sm-81">
		<div class="col-lg-12">
			<input id="fullpayment" name="payamount" type="radio" value="'.($openingbalance).',1" class="checkbox-inline" required> 
			<b>Pay Total Amount Due: <span style="color:#00f;">'.number_format($openingbalance).'</span></b>
		</div>
		<div class="col-lg-12">
			<div class="col-sm-32"><input id="othername" name="payamount" type="radio" value="10,2" class="checkbox-inline" required> 
			<b>Pay Other Amount:</b></div> <div class="col-sm-41" id="result"><input type="hidden" id="otheramnt" name="otheramnt" value="0"></div>
		</div>
		
		
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerledger.php\'">Closed</button>
	<button type="submit" class="btn btn-info" value="savepayment" id="submit_paynow" name="submit_paynow" onClick=\'return confirmSubmit()\'> Pay Now </button> 
</div>
</div>
</form>

</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<!--JS_SELECT_LISTS-->

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>
<script>
$(document).ready(function() {
// Jquery code here ///
$("input[type=\'radio\']").change(function() {
class1=$("input[name=payamount]:checked").val()
$(\'#result\').load(\'include/ajax/get_estimatepayment.php?class=\'+class1);
});
///
});
</script>

<script>
	$(".select2").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_type").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#inv_form").validate({
		rules: {
             company_name_edit		: "required",
			 company_status_edit	: "required"
		},
		messages: {
			company_name_edit		: "This field is required",
			company_status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';

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
<script src="js/estimates.js"></script>
<script src="js/stockin.js"></script>
<script>

	function get_PrdEstimateValue(id_item, srno) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_PrdEstimateValue.php",  
			data: "id_item="+id_item+"&srno="+srno,  
			success: function(msg){  
				$("#getPrdEstimateValue_"+srno).html(msg); 
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
	
	$("#vendor-list").select2({
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
