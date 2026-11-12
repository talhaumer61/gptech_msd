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
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '15')) {  
	
	include_once("include/settings/company/query.php");
	include_once("include/header.php");
	
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$cstatus	= (isset($_GET['cstatus']) && $_GET['cstatus'] != '') ? $_GET['cstatus'] : '1';
	
	if(($srch)) { 
		$sql2 		.= " AND (cm.company_name LIKE '%".$srch."%' 
								OR ad.ade_whatsapp LIKE '".$srch."' 
								OR ad.ade_email LIKE '".$srch."' 
								OR cm.company_code = '".$srch."' 
								OR ad.ade_name LIKE '%".$srch."%' )";
		$sqlstring	.= "&srch=".$srch;
	}

	if(($cstatus)) { 
		$sql2 		.= "  AND cs.customer_status =  '".$cstatus."'";
		$sqlstring	.= "&cstatus=".$cstatus;
	}

	// get all Ads
	$Ades		= $mainclass->get_ades();
echo '<title>Manage Zone - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name, code" value="'.$srch.'" style="width:350px;" >
	</div>	
	<div class="form-group">
		<select id="top-list1" data-placeholder="Status" name="cstatus" style="width:170px;">
			<option></option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'"'; if($itemadm_status['status_id'] == $cstatus){echo' selected';}echo'>'.$itemadm_status['status_name'].'</option>';
			}
			echo '
		</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="company.php" class="btn btn-purple"><i class="icon-list"></i> All</a> ';
	
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'add' => '1'))) { 
	echo '<button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Zone</button>';
}
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

if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}

	include_once("include/settings/company/list.php");
	
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

	include_once("include/settings/company/add.php");
	include_once("include/settings/company/edit.php");
	
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
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
    $("#top-list1").select2({
        allowClear: true
    });
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';

} else { 
	header('location: index.php');
}
?>