<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Attendance Report </title>
<style type="text/css">
body {overflow: -moz-scrollbars-vertical; margin:0; font-family: Arial, Helvetica, sans-serif, Calibri, "Calibri Light"; }
@page {	margin: 0cm; width:95% !important; } 
/* All margins set to 2cm */
@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
	@page { 
		 size: A4 landscape;
	    margin: 0.5cm;
	}
	thead {display: table-header-group;}
}


@page :first {  margin-top: 0cm    /* Top margin on first page 10cm */ }
h1 { text-align:center;margin:0; margin-top:0; margin-bottom:10px; font-size:25px; font-weight:bold; text-transform:uppercase; }
h3 { text-align:center; margin:0; margin-top:0; margin-bottom:0px; font-size:20px; font-weight:bold; text-transform:uppercase; }
h4 { text-align:center; margin:0; margin-bottom:5px; font-weight:normal; font-size:14px;  }
.payable { border:2px solid #000; padding:2px; text-align:center; font-size:13px; }
th {
	background-color:#eee;	
}
</style>
<script language="JavaScript1.2">
function openwindow() {
	window.open("attendancereport.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
</head>

<body>
<br>
<h1>Monthly Attendance Report</h1>
<h3>From Date: <u>'.$_POST['formdate'].'</u> To Date: <u>'.$_POST['todate'].'</u></h3>';

	$monthKeyID	 	 = searchArrayKeyVal("id", date("m", strtotime($_POST['formdate'])), $monthsname);
	$monthnamefrom 	 = $monthsname[$monthKeyID]['name'];
	$monthKeyto		 = searchArrayKeyVal("id", date("m", strtotime($_POST['todate'])), $monthsname);
	$monthnameto 	 = $monthsname[$monthKeyto]['name'];
	$datefrom  		 = date("d", strtotime($_POST['formdate']));
	$dateto  		 = date("d", strtotime($_POST['todate']));
	$yearfrom  		 = date("Y", strtotime($_POST['formdate']));
	$yearto  		 = date("Y", strtotime($_POST['todate']));

//------------------------------------------------
		$sqllmsdeptstop  = $dblms->querylms("SELECT dept_id, dept_name 
										FROM ".DEPTS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND dept_status = '1' ORDER BY dept_name ASC");
//------------------------------------------------
		while($rowdeptop = mysqli_fetch_array($sqllmsdeptstop)) {
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * FROM  ".EMPLOYEES." e 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation 
										WHERE e.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND e.id_dept = '".cleanvars($rowdeptop['dept_id'])."' 
										AND e.emply_status = '1'  
										ORDER BY e.emply_no ASC");

//------------------------------------------------
if(mysqli_num_rows($sqllms)>0) {
echo '
<table width="95%" class="page" border="0" align="center" style="border-collapse:collapse;">
<tr>
	<td><h1>'.$rowdeptop['dept_name'].'</h1>
</tr>


<tr>
	<td>
<table style="border-collapse:collapse; border:1px solid #ccc;" border="1" width="100%" cellpadding="3" cellspacing="3">
<tr>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Sr#</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Emply. #</th>
	<th style="text-align:left; font-size:13px; font-weight:bold;">Employee Name</th>
	<th style="text-align:left; font-size:13px; font-weight:bold;">Designation</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Absent</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Without Pay</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Clock In</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Clock Out</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Tortal Absent</th>
	
</tr>';
$srno = 0;
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$date = $_POST['formdate'];
	// End date
	$end_date = $_POST['todate'];
	
	$counter = 0;
//------------------------------------------------
	$counter = 0;
	$absent = 0;
	$unpaid = 0;
	$clockin = 0;
	$clockout = 0;
	while (strtotime($date) <= strtotime($end_date)) { 
	$counter++;
	//	echo date("l, d/m/Y", strtotime($date)).'<br>';	
//------------------------------------------------
$dayname = date('l', strtotime($date));							
//------------------------------------------------
	$sqllmsattend  	= $dblms->querylms("SELECT el.clock_out, el.clock_in  
										FROM ".EMPLY_ATTENDANCE." el 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND el.id_dept  = '".cleanvars($rowstd['id_dept'])."'  
										AND el.id_emply = '".cleanvars($rowstd['emply_id'])."'
										AND el.dated  = '".$date."' LIMIT 1 ");
if(mysqli_num_rows($sqllmsattend)>0) {
	$rowattends = mysqli_fetch_array($sqllmsattend);
//----------------Missing Clock in--------------------------------
	if(empty($rowattends['clock_in'])) { 
		$clockin++;
	} 
//----------------------Missing Clock Out--------------------------
	if(empty($rowattends['clock_out'])) { 
		$clockout++;
	} 
}
//-----------------If attendance not found-------------------------------	
if(mysqli_num_rows($sqllmsattend)<1) { 
	$sqllmsleve  = $dblms->querylms("SELECT l.leave_name, el.leave_type    
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND el.id_emply = '".cleanvars($rowstd['emply_id'])."'  AND el.leave_type = '1'
										AND ('".$date."' BETWEEN el.date_from  AND el.date_to)");	
//-------------------If leave not found-----------------------------
	if(mysqli_num_rows($sqllmsleve)<1) { 
		$sqllmsupaid  = $dblms->querylms("SELECT l.leave_name, el.leave_type    
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND el.id_emply = '".cleanvars($rowstd['emply_id'])."'  AND el.leave_type = '2' 
										AND ('".$date."' BETWEEN el.date_from  AND el.date_to)");	
		if(mysqli_num_rows($sqllmsupaid)>0) { 
			$unpaid++;
		} else { 
		
		$sqllmsshift  = $dblms->querylms("SELECT day    
										FROM ".SHIFT_DETAIL."
										WHERE id_shift = '".cleanvars($rowstd['id_shift'])."' 
										AND day = '".$dayname."' LIMIT 1");
//-----------------if working day-------------------------------	
		if(mysqli_num_rows($sqllmsshift)>0) { 
			$sqllmsholids  = $dblms->querylms("SELECT id    
										FROM ".HOLIDAYS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND status = '1'
										AND ('".$date."' BETWEEN date_start AND date_end) ");
//-----------------if not holiday-------------------------------	
			if(mysqli_num_rows($sqllmsholids)<1) { 

				$absent++;
			}
//-----------------end holiday check-------------------------------	
		} 
		}
//-----------------end working day check-------------------------------	
	}
//-----------------end leave check-------------------------------	
	
	}
//-----------------end attendance check -------------------------------
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
//-----------------end date while loop -------------------------------
	}

if($clockin>5) {
	$tlclockin = "($clockin/2) = ";
	$clockinabsent = floor($clockin/2);
} else { 
	$tlclockin = '';
	$clockinabsent = '';
}

if($clockout>5) {
	$tlclockout = "($clockout/2) = ";
	$clockoutabsent = floor($clockout/2);
} else { 
	$tlclockout = '';
	$clockoutabsent = '';
}
if(($absent + $clockinabsent + $clockoutabsent + $unpaid)>0) {
$srno++;
//-------------------------------------------------
echo '
<tr>
	<td style="text-align:center; font-size:12px; width:35px;">'.$srno.'</td>
	<td style="text-align:center; font-size:12px; width:55px;">'.$rowstd['emply_no'].'</td>
	<td style="text-align:left; font-size:12px;">'.$rowstd['emply_name'].'</td>
	<td style="text-align:left; font-size:12px; width:250px;">'.$rowstd['designation_name'].'</td>
	<td style="text-align:center; font-size:12px; width:70px;">'.$absent.'</td>
	<td style="text-align:center; font-size:12px; width:100px;">'.$unpaid.'</td>
	<td style="text-align:center; font-size:12px; width:80px;">'.$tlclockin.$clockinabsent.'</td>
	<td style="text-align:center; font-size:12px; width:80px;">'.$tlclockout.$clockoutabsent.'</td>
	<td style="text-align:center; font-size:12px; width:100px;">'.($absent + $clockinabsent + $clockoutabsent + $unpaid).'</td>
</tr>';
}
//-------------------------------------------------
} // end emply while loop 
//-------------------------------------------------
unset($date,$absent,$end_date, $clockout, $clockin);	
	//echo 'Total Days: '.$counter.'<br> Total Absent: '.$absent;
//-------------------------------------------------
echo '
</table>
	<td>
</tr>
</table>

<div class="page-break"></div>';
//------------------------------------------------
} // end if dept emply check 
//------------------------------------------------
} // end dept while loop
?>
</body>
<script type="text/javascript" language="javascript1.2">
<!--
 //Do print the page
if (typeof(window.print) != 'undefined') {
    window.print();
}
-->
</script>
</html>