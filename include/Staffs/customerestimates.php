<?php 
if(($_SESSION['userlogininfo']['LOGINIDA'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '34') || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '39')) { 
	include_once("estimates/query.php");
	$sql2 		= '';
	$sqlstatus2 = '';
	$sqlstring	= "";
	$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer  	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	$sts  		= (isset($_GET['sts']) && $_GET['sts'] != '') ? $_GET['sts'] : '';
	$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (".ESTIMATES.".estimate_no LIKE '".$srch."' OR ".CUSTOMERS.".customer_name LIKE '%".$srch."%' 
								OR ".CUSTOMERS.".customer_cellno LIKE '%".$srch."%' 
								OR ".CUSTOMERS.".customer_code LIKE '".$srch."')";
		$sqlstring	.= "&srch=".$srch;
	}

	if(($customer)) { 
		$sql2 		.= " AND ".ESTIMATES.".id_customer = '".$customer."'";
		$sqlstring	.= "&customer=".$customer;
	}

	// get all Customers
    $Customers 	= $mainclass->get_customers();
	// get all Items
	$Items		= $mainclass->get_items();
	
	echo '<title>Customers Estimates - '.TITLE_HEADER.'</title>
	<div class="matter">
		<div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<form class="navbar-form navbar-left form-small" action="" method="get">
						<div class="form-group">
							<input type="text" class="form-control" name="srch" placeholder="Job#, Name" style="width:250px;" >
						</div>	
						<div class="form-group">
							<select id="top-list1" data-placeholder="Customer" name="customer" style="width:350px;">
								<option></option>';
								foreach($Customers as $valuectop) {  
									echo ($valuectop['customer_id'] == $customer) ? '<option value="'.$valuectop['customer_id'].'" selected>'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>' : '<option value="'.$valuectop['customer_id'].'">'.$valuectop['customer_code'].' - '.$valuectop['customer_name'].'</option>';
								}
								echo '
							</select>
							<script>
								$("#top-list1").select2({
									allowClear: true
								});
							</script>
						</div>
						
						<button type="submit" class="btn btn-primary">Search</button>
						<a href="customerestimates.php?view='.LMS_VIEW.'&filter=all" class="btn btn-purple"><i class="icon-list"></i> All</a>';

						if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '34', 'add' => '1'))) { 
							echo ' <a class="btn btn-success" href="customerestimates.php?view=add"><i class="icon-plus"></i> Add Estimate</a>';
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
								if(!empty($printid)){
									echo "<script language=\"javascript\">window.open(\"customerestimatesprint.php?id=$printid\",\"_blank\");</script>";
								}
							}
							include_once("estimates/list.php");
							include_once("estimates/payment_request.php");
							include_once("estimates/challan_generated.php");
							include_once("estimates/payment_request_edit.php");
							include_once("estimates/manual_payment.php");
							include_once("estimates/add.php");
							include_once("estimates/addcopied.php");
							include_once("estimates/edit.php");
							include_once("estimates/convertjoborder.php");
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
			</div>
		</div
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
<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
				<h4 class="modal-title" style="font-weight:700;"> Confirmation Alert!</h4>
			</div>
            <form action="" method="POST">
				<div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-information" data-dismiss="modal" aria-hidden="true">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
<script src="js/estimates.js"></script>
<script src="js/stockin.js"></script>
 <script>
        (function($) {
            "use strict";
            $(document).on(\'click\', \'.confirmationBtn\', function() {
                var modal = $(\'#confirmationModal\');
                let data = $(this).data();
                modal.find(\'.question\').text(`${data.question}`);
                modal.find(\'form\').attr(\'action\', `${data.action}`);
                modal.modal(\'show\');
            });
        })(jQuery);
    </script>
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
<script>

	function get_PrdEstimateValue(id_item, srno) {  
		var idcustomer = $("#id_customer").val();
		$.ajax({  
			type: "POST",  
			url: "include/ajax/get_PrdEstimateValue.php",  
			data: "idcustomer="+idcustomer+"&id_item="+id_item+"&srno="+srno,  
			success: function(msg){  
				$("#getPrdEstimateValue_"+srno).html(msg); 
			}
		});  
	}
	
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
