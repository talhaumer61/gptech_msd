<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '12')) {
	include_once("include/header.php");
//----------------------------------------
//----------------------------------------
$sql2 = '';
$sqlstring	= "";
//----------------------------------------
if(($_GET['srch'])) { 
	$sql2 		.= " AND media_name LIKE '%".$_GET['srch']."%'";
	$sqlstring	.= "&srch=".$_GET['srch']."";
}
//----------------------------------------
echo '<title>Manage Media - '.TITLE_HEADER.'</title>
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
	<a href="media.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'add' => '1'))) { 
	echo ' <button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Media</button>';
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
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT media_name  
										FROM ".MEDIA." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND media_name = '".cleanvars($_POST['media_name'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box error"><span>error: </span>Media "<b>'.cleanvars($_POST['media_name']).'</b>" already exists.</div>';
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".MEDIA."(
														media_status						, 
														media_name							,
														id_office							, 
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['media_status'])."'			, 
														'".cleanvars($_POST['media_name'])."'			,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Media: "'.cleanvars($_POST['media_name']).'" detail';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
	}
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".MEDIA." SET  media_status			= '".cleanvars($_POST['media_status_edit'])."'
												  , media_name			= '".cleanvars($_POST['media_name_edit'])."' 
												  , id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company			= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
   											  WHERE media_id			= '".cleanvars($_POST['media_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Media: "'.cleanvars($_POST['media_name_edit']).'" details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
//--------------------------------------
	}
//--------------------------------------
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT media_id, media_status, media_name  
										FROM ".MEDIA." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY media_name ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th> ID</th>
	<th> Name</th>
	<th> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['media_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'edit' => '1'))) { 
	$bankname  = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Designation" data-height="350" data-width="100%" data-com-status="'.$rowstd['media_status'].'" data-com-name="'.$rowstd['media_name'].'"  data-com-id="'.$rowstd['media_id'].'" data-target="#editCountryModal">'.$rowstd['media_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Designation" data-height="350" data-width="100%" data-com-status="'.$rowstd['media_status'].'" data-com-name="'.$rowstd['media_name'].'" data-com-id="'.$rowstd['media_id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['media_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;">'.$rowstd['media_id'].'</td>
	<td style="min-width:250px;">'.$bankname.' </td>
	<td style="width:70px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'delete' => '1'))) { 	
	echo '<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
}
echo ' 
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
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
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Media Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="media_name" name="media_name" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="media_status" name="media_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Create Media" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Media Detail</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="media_name_edit" name="media_name_edit" required autofocus autocomplete="off">
		</div>
	</div>
	    
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="media_status_edit" name="media_status_edit" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadms_tatus) {
				echo "<option value='$itemadms_tatus[status_id]'>$itemadms_tatus[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="media_id_edit" name="media_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->';
}
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
    $("#media_status").select2({
        allowClear: true
    });
	$("#media_status_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             media_name		: "required",
			 media_status		: "required"
		},
		messages: {
			media_name		: "This field is required",
			media_status		: "This field is required"
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
             media_name_edit		: "required",
			 media_status_edit	: "required"
		},
		messages: {
			media_name_edit		: "This field is required",
			media_status_edit		: "This field is required"
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
		var media_status_edit 			= $(this).attr("data-com-status");
        var media_name_edit 			= $(this).attr("data-com-name");
		var media_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#media_name_edit")			.val(media_name_edit);
		$("#media_id_edit")				.val(media_id_edit);

       //pre-select data in pull down lists
       $("#media_status_edit")			.select2().select2("val", media_status_edit); 
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
?>