<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin(); 
//------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA'] == 1 || $_SESSION['userlogininfo']['LOGINIDA'] == 2) {  
//----------------------------------------
	include_once("include/settings/admins/query.php");
	include_once("include/header.php");
//----------------------------------------
$sql2 		= '';
$sqlstring	= "";
$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (adm_username LIKE '%".$srch."%' 
							OR adm_fullname LIKE '%".$srch."' 
							OR adm_email LIKE '%".$srch."' 
							OR adm_phone LIKE '%".$srch."' )";
	$sqlstring	.= "&srch=".$srch;
}
//----------------------------------------
echo '<title>Manage Administrators - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="User Name" style="width:350px;" >
	</div>
	<button type="submit" class="btn btn-primary">Search User</button>
	<a href="administrators.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'add' => '1'))) { 
	echo ' <a class="btn btn-success" href="administrators.php?view=add"><i class="icon-plus"></i> Add User</a>';
}
//--------------------------------------------
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
//----------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}
//------------------------------------------------
	include_once("include/settings/admins/list.php");
	include_once("include/settings/admins/add.php");
	include_once("include/settings/admins/edit.php");
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
//--------------------------------------------
	include_once("include/settings/admins/modal_edit.php");
//--------------------------------------------
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

    $("#adm_status").select2({
        allowClear: true
    });
	$("#adm_status_edit").select2({
        allowClear: true
    });
	
	$("#adm_type").select2({
        allowClear: true
    });
	$("#adm_type_edit").select2({
        allowClear: true
    });
	$("#id_company").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_office").select2({
        allowClear: true
    });
	$("#id_office_edit").select2({
        allowClear: true
    });
	
</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {

	$("#addNewUsr").validate({
		rules: {
			 adm_fullname: "required",
			 adm_status: "required",
			 adm_username: "required",
			 adm_userpass: "required"
		},
		messages: {
			adm_fullname: "This field is required",
			adm_status: "This field is required",
			adm_username: "This field is required",
			adm_userpass: "This field is required"
		},
		submitHandler: function(form) { 
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->
<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {

	$("#editUsr").validate({
		rules: {
             adm_fullname_edit: "required",
			 adm_username_edit: "required",
			 adm_status_edit: "required"
		},
		messages: {
			adm_fullname_edit: "This field is required",
			adm_username_edit: "This field is required",
			adm_status_edit: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
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

$(document).ready(function() {
  $("#checkall").click(function() {
    var checked = $(this).prop("checked");
    $("#checkboxes").find("input:checkbox").prop("checked", checked);
  });
})

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
//------------------------------------
	header('location: index.php');
}
//------------------------------------
?>