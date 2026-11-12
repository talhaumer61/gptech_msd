<?php 

if(($_SESSION['userlogininfo']['LOGINIDA'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '1')) { 
	include_once("customerorders/query.php");

	$sql2 		= '';
	$sqlstatus2 = '';
	$sqlstring	= "";
	$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$customer  	= (isset($_GET['customer']) && $_GET['customer'] != '') ? $_GET['customer'] : '';
	$sts  		= (isset($_GET['sts']) && $_GET['sts'] != '') ? $_GET['sts'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (".JOB_ORDER.".job_order_no LIKE '".$srch."' OR ".CUSTOMERS.".customer_name LIKE '%".$srch."%' 
								OR ".CUSTOMERS.".customer_cellno LIKE '%".$srch."%')";
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
							<input type="text" class="form-control" name="srch" placeholder="Job#, Name" style="width:250px;" >
						</div>	
						<div class="form-group">
							<select id="top-list1" class="select2" data-placeholder="Customer" name="customer" style="width:300px;">
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
						<a href="customerorders.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
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
							}
							include_once("customerorders/list.php");
							include_once("customerorders/edit.php");
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
	<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
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
	<script src="js/joborder.js"></script>
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
} else { 
	header('location: index.php');
}
