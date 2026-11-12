<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) { 
//----------------------------------------
echo '<title> Vendors Balance Sheet - '.TITLE_HEADER.'</title>
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
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="vendorbalancesheet.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
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
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT SUM(b.grandtotal) AS totalreceivables, c.vendor_id, c.vendor_name, c.vendor_cellno  
										FROM ".PURCHASES." b 
										INNER JOIN ".VENDORS." c ON c.vendor_id = b.id_vendor   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										GROUP BY b.id_vendor ORDER BY totalreceivables DESC");
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th> Vendor Name</th>
	<th style="text-align:center;"> Payable</th>
	<th style="text-align:center;"> Paid</th>
	<th style="text-align:center;"> Pending</th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$sqllmspaid  = $dblms->querylms("SELECT SUM(amount) AS totalpaid FROM ".PAYMENTS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND pay_type = '2' AND id_paid = '".cleanvars($rowstd['vendor_id'])."' ");
	$rowspaid = mysqli_fetch_array($sqllmspaid);
//------------------------------------------------
$balance = ($rowstd['totalreceivables']);
if($balance>0) { 
$srno++;
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td>'.$rowstd['vendor_name'].' '.$rowstd['vendor_cellno'].'</td>
	<td style="text-align:right; width:120px;">'.number_format($rowstd['totalreceivables']).'</td>
	<td style="text-align:right; width:120px;">'.number_format($rowspaid['totalpaid']).'</td>
	<td style="text-align:right; width:120px;">'.number_format($balance).'</td>
</tr>';
}
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
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
//------------------------------------
//--------------------------------------------------
} else {
	echo '<h1 style="margin-top: 200px; color: #f00; font-weight: 600; text-align: center;">Sorry, you have no right to access this page</h1>';
	
}
//------------------------------------
?>