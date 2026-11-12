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

	include_once("include/header.php");
//----------------------------------------
//----------------------------------------
$sql2 = '';
$sqlstring	= "";
//----------------------------------------
if(($_GET['srch'])) { 
	$sql2 		.= " AND (country_name LIKE '".$_GET['srch']."%' OR country_code LIKE '".$_GET['srch']."')";
	$sqlstring	.= "&srch=".$_GET['srch']."";
}
//----------------------------------------
if(($_GET['council'])) { 
	$sql2 		.= " AND id_council = '".$_GET['council']."'"; 
	$sqlstring	.= "&council=".$_GET['council']."";
}
//----------------------------------------
echo '<title>Manage Countries - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name, code" >
	</div>
	<div class="form-group">
		<select id="council" data-placeholder="Council" name="council" style="width:200px;">
				<option value=""></option>';
			foreach($councils as $itemcouncils) {
				echo '<option value="'.$itemcouncils['id'].'">'.$itemcouncils['name'].'</option>';
			}
	echo'
			</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="country.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
	<button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Country</button>
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
$sqllms  = $dblms->querylms("INSERT INTO ".COUNTRIES."(
														country_status								, 
														country_code								, 
														country_name								,
														id_council
													  )
	   											VALUES(
														'".cleanvars($_POST['country_status'])."'	, 
														'".cleanvars($_POST['country_code'])."'		, 
														'".cleanvars($_POST['country_name'])."'		,
														'".cleanvars($_POST['id_council'])."'
													  )"
							);
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".COUNTRIES." SET country_status	= '".cleanvars($_POST['country_status_edit'])."'
 													, country_code		= '".cleanvars($_POST['country_code_edit'])."'
													, country_name		= '".cleanvars($_POST['country_name_edit'])."'
													, id_council		= '".cleanvars($_POST['id_council_edit'])."'
												WHERE country_id		= '".cleanvars($_POST['country_id'])."'");
}
//------------------------------------------------
if (!($Limit))   { $Limit = 300; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT country_id, country_status, country_code, country_name, id_council  
										FROM ".COUNTRIES." 
										WHERE country_id != '' $sql2 
										ORDER BY country_name ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT country_id, country_status, country_code, country_name, id_council  
										FROM ".COUNTRIES." 
										WHERE country_id != '' $sql2 
										ORDER BY country_name ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th> ID</th>
	<th> Code</th>
	<th> Name</th>
	<th> Council</th>
	<th> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['country_status']);
if($rowstd['id_council']) {
	$councilstatus = get_councils($rowstd['id_council']);
} else {
	$councilstatus = '';
}
echo '
<tr>
	<td>'.$rowstd['country_id'].'</td>
	<td>'.$rowstd['country_code'].'</td>
	<td style="min-width:250px;"><a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Country" data-height="350" data-width="100%" data-cls-name="'.$rowstd['country_name'].'" data-cls-code="'.$rowstd['country_code'].'" data-cls-status="'.$rowstd['country_status'].'" data-cls-council="'.$rowstd['id_council'].'" data-cls-id="'.$rowstd['country_id'].'" data-target="#editCountryModal">'.$rowstd['country_name'].'</a> </td>
	<td>'.$councilstatus.'</td>
	<td>'.$ctystatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Class" data-height="350" data-width="100%" data-cls-name="'.$rowstd['country_name'].'" data-cls-code="'.$rowstd['country_code'].'" data-cls-status="'.$rowstd['country_status'].'" data-cls-council="'.$rowstd['id_council'].'" data-cls-id="'.$rowstd['country_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a>
		<button class="btn btn-xs btn-danger ajax-delete-record" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?" data-popconfirm-placement="left" data-mysql-record-id="2" data-mysql-record-id4="1" data-mysql-table-name="tasks" data-ajax-url=""> <i class="icon-trash"></i></button>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="country.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="country.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="country.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
} 
	echo $Nav;
echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add New Country</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Country Name</label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="country_name" name="country_name" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Country Code</label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="country_code" name="country_code" required autocomplete="off">
		</div>
	</div>


	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> Council</label>
		<div class="col-lg-12">
			<select id="id_council" name="id_council" style="width:100%" autocomplete="off">
				<option value="">Select Council</option>';
			foreach($councils as $itemcouncils) {
				echo '<option value="'.$itemcouncils['id'].'">'.$itemcouncils['name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Status</label>
		<div class="col-lg-12">
			<select id="country_status" name="country_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Create Country" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Country Bio Data</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Country Name</label>
		<div class="col-lg-12">
			<input type="text" class="form-control" name="country_name_edit"id="country_name_edit" autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Country Code</label>
		<div class="col-lg-12">
			<input type="text" class="form-control" name="country_code_edit"id="country_code_edit" autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> Council</label>
		<div class="col-lg-12">
			<select id="id_council_edit" name="id_council_edit" style="width:100%" autocomplete="off">
				<option value="">Select Council</option>';
			foreach($councils as $itemcouncils) {
				echo '<option value="'.$itemcouncils['id'].'">'.$itemcouncils['name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>
    
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> Status</label>
		<div class="col-lg-12">
			<select id="country_status_edit" name="country_status_edit" style="width:100%" autocomplete="off">
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
	<input type="hidden" id="country_id_edit" name="country_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

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
<script>

    $("#country_status").select2({
        allowClear: true
    });
	$("#country_status_edit").select2({
        allowClear: true
    });
	$("#id_council").select2({
        allowClear: true
    });
	$("#id_council_edit").select2({
        allowClear: true
    });
	$("#council").select2({
        allowClear: true
    });
</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewCountry").validate({
		rules: {
             country_name		: "required",
			 country_code		: "required",
			 country_status		: "required"
		},
		messages: {
			country_name		: "This field is required",
			country_code		: "This field is required",
			country_status		: "This field is required"
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
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editCountry").validate({
		rules: {
             country_name_edit		: "required",
			 country_code_edit		: "required",
			 country_status_edit	: "required"
		},
		messages: {
			country_name_edit		: "This field is required",
			country_code_edit		: "This field is required",
			country_status_edit		: "This field is required"
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
        var country_name_edit 	= $(this).attr("data-cls-name");
		var country_code_edit 	= $(this).attr("data-cls-code");
		var country_status_edit = $(this).attr("data-cls-status");
		var id_council_edit 	= $(this).attr("data-cls-council");
		var country_id_edit 	= $(this).attr("data-cls-id");

        //set modal input values dynamically
		$("#country_code_edit")	.val(country_code_edit);
		$("#country_name_edit")	.val(country_name_edit);
		$("#country_id_edit")	.val(country_id_edit);

       //pre-select data in pull down lists
       $("#country_status_edit").select2().select2("val", country_status_edit); 
	   $("#id_council_edit")	.select2().select2("val", id_council_edit); 
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
}
?>