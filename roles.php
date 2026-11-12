<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA'] != 1) {  
//------------------------------------
	header('location: index.php');
//------------------------------------
} else { 
//------------------------------------
	include_once("include/settings/roles/query.php");
	include_once("include/header.php");
$sql2 		= '';
$sqlstring 	= '';
$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
$type	  	= (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
//----------------------------------------
if(($srch)) {
	$stdsrch	= $srch;
	$sql2 		.= "AND role_name LIKE '%".$stdsrch."%'";
	$sqlstring	.= "&srch=".$stdsrch."";
}

//----------------------------------------
if(($type)) {
	$sql2 		.= "AND role_type = '".$type."'";
	$sqlstring	.= "&type=".$type;
}
//----------------------------------------

echo '<title>Manage Roles - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Role name" style="width:250px;" >
	</div>
	<select id="projects-list1" data-placeholder="Under Role" name="type" style="width:220px">
			<option></option>';
			foreach($roletypes as $toproletypes) {
				echo '<option value="'.$toproletypes['id'].'">'.$toproletypes['name'].'</option>';
			}
echo '	</select>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="roles.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
	<button data-toggle="modal" class="btn btn-success" href="#addNewBcatModal"><i class="icon-plus"></i> Add Role</button>
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
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
	include_once("include/settings/roles/list.php");
//------------------------------------------------
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>
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
//---------------------------------------------------------
	include_once("include/settings/roles/add.php");
	include_once("include/settings/roles/edit.php");
//---------------------------------------------------------
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
<!--JS_SELECT_LISTS-->
<script type="text/javascript" src="js/ebro_form_validate.js"></script>
<script>
    $("#role_status").select2({
        allowClear: true
    });
	$("#role_status_edit").select2({
        allowClear: true
    });
	$("#role_type").select2({
        allowClear: true
    });
	$("#role_type_edit").select2({
        allowClear: true
    });
	$("#projects-list1").select2({
        allowClear: true
    });
	
	
</script>
<!--JS_SELECT_LISTS-->
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
}
//------------------------------------
?>