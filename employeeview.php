<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
$sqllmspro  = $dblms->querylms("SELECT *   
										FROM ".EMPLOYEES." emp 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = emp.id_designation  
										INNER JOIN ".DEPTS." dept ON dept.dept_id = emp.id_dept   
										WHERE emp.emply_id = '".cleanvars($_GET['id'])."' LIMIT 1");
//----------------------------------------
$rowstdpro = mysqli_fetch_array($sqllmspro);
//------------------------------------------------
if($rowstdpro['emply_photo']) { 
	$stdphoto = '<span style="float:right;"><img class="image-boardered" src="images/employees/'.$rowstdpro['emply_photo'].'" alt="'.$rowstdpro['emply_name'].'" width="100" height="100" />';
} else {
	$stdphoto = '<span style="float:right;"><img class="image-boardered" src="images/employees/default.png" alt="'.$rowstdpro['emply_name'].'" width="100" height="100" /></span>';
}
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Profile of '.$rowstdpro['emply_name'].'</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.png">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
</style>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp">
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12">
<table class="table table-bordered table-hover" border="1">
<tbody>
<tr>
	<td bgcolor="#FAFAFA" style="vertical-align:middle;"><strong>Emply #</td>
	<td style="vertical-align:middle;"><b>'.$rowstdpro['emply_no'].'</b></td>
	<td colspan="2" rowspan="2">'.$stdphoto.'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA" style="vertical-align:middle;"><strong>Name</td>
	<td style="vertical-align:middle;">'.$rowstdpro['emply_name'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA" width="15%"><strong>CNIC</strong></td>
	<td>'.$rowstdpro['emply_cnic'].'</td>
	<td bgcolor="#FAFAFA" width="15%"><strong>Email Address</strong></td>
	<td>'.$rowstdpro['emply_email'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA" width="15%"><strong>Father Name</strong></td>
	<td>'.$rowstdpro['emply_fathername'].'</td>
	<td bgcolor="#FAFAFA" width="15%"><strong>Contact #</strong></td>
	<td>'.$rowstdpro['emply_cellno'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA" width="15%"><strong>Department</strong></td>
	<td>'.$rowstdpro['dept_name'].'</td>
	<td bgcolor="#FAFAFA" width="15%"><strong>Designation</strong></td>
	<td>'.$rowstdpro['designation_name'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA"><strong>Postal Address</strong></td>
	<td colspan="3">'.$rowstdpro['emply_address'].'</td>
</tr>
</tbody>
</table>';
//--------------Fee History----------------------------------
	$sqllmsleaves  = $dblms->querylms("SELECT abs(datediff(el.date_from,el.date_to))+1 as difference, el.id, el.leave_type, l.leave_name, 
										el.id_leave, el.date_from, el.date_to, el.id_leave, el.reason, el.duration, el.alternate_emply, d.dept_name      
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_emply = '".cleanvars($_GET['id'])."' 
										AND el.date_from LIKE '".date("Y")."%' ORDER BY el.id DESC");

$leavesarray = array();
$CasualLeave = 0;
$MedicalLeave = 0;
while($rowstdfee = mysqli_fetch_array($sqllmsleaves))  {
	$leavesarray[] = $rowstdfee;
	if($rowstdfee['id_leave'] == 1) { 
		$CasualLeave = ($CasualLeave + $rowstdfee['difference']);
	} 
	
	if($rowstdfee['id_leave'] == 2) { 
		$MedicalLeave = ($MedicalLeave + $rowstdfee['difference']);
	} 

}
//--------------------------------------------------
echo '
<h4 class="modal-title" style="font-weight:700;color:blue;">Leaves Balance</h4>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th width="15%">Casual Leave</th>
	<td>'.(24-$CasualLeave).' </td>
	<th style="text-align:right;" width="15%">Medical Leave</th>
	<td>'.(8-$MedicalLeave).'</th>
</tr>
</thead>
</table>';
//--------------------------------------------------
if (mysqli_num_rows($sqllmsleaves) > 0) {
//------------------------------------------------
echo '
<h4 class="modal-title" style="font-weight:700;">Leaves History</h4>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="width:50px; text-align:center;">Sr. #</th>
	<th>Leave</th>
	<th style="text-align:center;">Type</th>
	<th style="text-align:center;">Total</th>
	<th style="text-align:center;">From Date</th>
	<th style="text-align:center;">To Date</th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($leavesarray as $itemleave) {
//------------------------------------------------
	$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td>'.$itemleave['leave_name'].'</td>
	<td style="width:80px; text-align:center;">'.get_leavetype($itemleave['leave_type']).'</td>
 	<td style="width:60px; text-align:center;">'.$itemleave['difference'].'</td>
	<td style="width:90px; text-align:center;">'.$itemleave['date_from'].'</td>
	<td style="width:90px; text-align:center;">'.$itemleave['date_to'].'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
}
//------------End Education History------------------------------------
echo '
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
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
?>