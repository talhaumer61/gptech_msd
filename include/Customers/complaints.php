<?php
    include_once("complaints/query.php");
    include_once("include/header.php");

	$sql2 		= '';
	$sql3 		= '';
	$sqlstring	= "";
	$srch			= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$status			= (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : '';
	$priority		= (isset($_GET['priority']) && $_GET['priority'] != '') ? $_GET['priority'] : '';
	$yearMonth		= (isset($_GET['yearmonth']) && $_GET['yearmonth'] != '') ? $_GET['yearmonth'] : '';


	if($srch != '') {
		$sql2 		.= " AND c.complaint_title LIKE '%".$srch."%'";
		$sqlstring	.= "&srch=".$srch."";
	}
	if($status != '') {
		$sql3       .= "AND c.complaint_status = '".$status."' ";
		$sqlstring	.= "&status=".$status."";
	} 
	if($priority != '') {
		$sql2       .= "AND c.complaint_priority = '".$priority."' ";
		$sqlstring	.= "&priority=".$priority."";
	} 
	if($yearMonth != '') {
		$sql2       .= "AND c.date_added LIKE '".$yearMonth."%' ";
		$sqlstring	.= "&yearmonth=".$yearMonth."";
	}

	$arrayAdmins = array();
	$sqllmsAdmins  = $dblms->querylms("SELECT adm_id, adm_username, adm_fullname 
											FROM ".ADMINS." 
											WHERE adm_status = '1' AND adm_logintype = '1'
											ORDER BY adm_username ASC");
	while($valueAdmin = mysqli_fetch_array($sqllmsAdmins)) {

		$arrayAdmins[] = $valueAdmin;
	}

	$conditions = array ( 
							'select' 		=> ''.CUSTOMERS.'.customer_id',
							'where' 		=> array( 
														''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													), 
							'limit' 		=> 1,
							'return_type' 	=> 'single' 
						); 
	$valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);
	$id_customer 	= $valueCustomer['customer_id'];
	
	echo'
	<title>Manage Tasks - '.TITLE_HEADER.'</title>
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
							<input type="text" class="form-control" value="'.$srch.'" name="srch" placeholder="Search by Title" style="width:250px;" >
						</div>
						<div class="form-group">
							<select id="tstatus" name="status" data-placeholder="Status" style="width:150px">
								<option></option>';
								foreach($taskStatus as $key => $cstatus) {
									echo '<option value="'.$key.'" '.(($key == $status) ? 'selected' : '').'>'.$cstatus.'</option>';
								}
							echo '
							</select>
						</div>
						<div class="form-group">
							<select id="priority_level" data-placeholder="Priority" name="priority" style="width:150px">
								<option></option>';
								foreach($priorityLevels as $key => $level) {
									echo '<option value="'.$key.'" '.(($key == $priority) ? 'selected' : '').'>'.$level.'</option>';
								}
							echo '
							</select>
						</div>
						<div class="form-group">
							<input type="text" class="form-control pickayearmonth" name="yearmonth" value="'.$yearMonth.'" placeholder="Search by Year-Month" style="width:150px;" autocomplete="off">
						</div>
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
						<a href="complaints.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
					
						echo '
						<a class="btn btn-success" href="complaints.php?view=add"><i class="icon-plus"></i> Add Complaint</a>
						<!--<a href="complaints.php?ab='.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).'" class="btn btn-xs btn-purple text-white">Assigned By You</a>
						<a href="complaints.php?rp='.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).'" class="btn btn-xs btn-primary text-white">Assigned To You</a>
						-->';
						echo '
						<script>
							$("#projects-list").select2({
								allowClear: true
							});
							$("#projects-list1").select2({
								allowClear: true
							});
							$("#projects-list2").select2({
								allowClear: true
							});
							$("#projects-list3").select2({
								allowClear: true
							});
							$("#projects-list4").select2({
								allowClear: true
							});
							$("#tstatus").select2({
								allowClear: true
							});
							$("#priority_level").select2({
								allowClear: true
							});
						</script>
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
				<div class="col-md-12">';
							if(isset($_SESSION['msg'])) { 
								echo $_SESSION['msg']['status'];
								unset($_SESSION['msg']);
							}

							include_once("complaints/list.php");
							include_once("complaints/add.php");
							include_once("complaints/edit.php");
							include_once("complaints/messages.php");
							echo '
						</div>
					</div>
				</div>
			</div>
			<!--WI_MY_TASKS_TABLE-->
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
	<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
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
	<!--JS_SELECT_LISTS-->
	<script type="text/javascript" src="js/ebro_form_validate.js"></script>
	<script>
		$("#status").select2({
			allowClear: true
		});
		$("#status_edit").select2({
			allowClear: true
		});
		
		$("#setup_session").select2({
			allowClear: true
		});
		$("#setup_session_edit").select2({
			allowClear: true
		});
		
		$("#id_prg").select2({
			allowClear: true
		});
		$("#id_prg_edit").select2({
			allowClear: true
		});
	</script>
	<script>
		<!--Get Transcript Data by Student ID-->
		function get_transcriptdetails(type, id_std) {
			$("#loading1").html(\'<img src="images/ajax-loader-horizintal.gif"> loading...\');  
			$.ajax({
				type: "POST",
				url: "include/ajax/exam/get_transcriptdetails.php",
				data: "type="+type+"&id_std="+id_std,
				success: function(msg){  
					$("#get_transcript_details").html(msg);
					$("#loading1").html(\'\'); 
				}
			});  
		}
	</script>
	<!--JS_SELECT_LISTS-->
	<!--JS_ADD_NEW_TASK_MODAL-->
	<script type="text/javascript">
	$().ready(function() {
		//USED BY: WI_EDIT_NEW_TASK_MODAL
		//ACTIONS: validates the form and submits it
		//REQUIRES: jquery.validate.js
		$("#editBcat").validate({
			rules: {
				setup_session_edit	: "required",
				status_edit: "required"
			},
			messages: {
				setup_session_edit	: "This field is required",
				status_edit	: "This field is required"
			},
			submitHandler: function(form) {
			//alert("form submitted");
			form.submit();
			}
		});
	});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
		//USED BY: WI_EDIT_TASK_MODAL
		//ACTIONS: dynamically add data into modal form
		//REQUIRES: jquery.js
		//ACTIONS-2: creates a pull down/select for each specified field (with preselected values)
		//REQUIRES-2: select2.js
			
		//---edit item link clicked-------
		$(".edit-bcat-modal").click(function(){
		
			//get variables from "edit link" data attributes
			var setup_session_edit 	= $(this).attr("data-type-name");
			var status_edit 		= $(this).attr("data-type-status");
			var cat_id_edit 		= $(this).attr("data-type-id");

			//set modal input values dynamically
			$("#setup_session_edit")	.val(setup_session_edit);
			$("#cat_id_edit")			.val(cat_id_edit);

		//pre-select data in pull down lists
		$("#status_edit")		.select2().select2("val", status_edit); 
	});
		
	});
	</script>
	<script type="text/javascript" src="js/custom/all-vendors.js"></script>
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
		//USED BY: All date picking forms
		$(document).ready(function(){
			$(".pickayearmonth").datepicker({
			format: "yyyy-mm",
			language: "lang",
			autoclose: true,
			todayHighlight: true
			});	
		});
	</script>
	<script type="text/javascript">
		$(function () {
			$(".footable").footable();
		});
	</script>
	<script type="text/javascript" src="js/custom/custom.js"></script>
	<script type="text/javascript" src="js/custom/custom.general.js"></script>
	</body>
	</html>';

?>