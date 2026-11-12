<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Absent Dates  Report </title>
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
		 size: A4 portrait;
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
<h1>Monthly Absent Dates Report</h1>
<h3>From Date: <u>'.$_POST['fromdate'].'</u> To Date: <u>'.$_POST['todate'].'</u></h3><br>';
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * FROM  ".EMPLOYEES." e 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation 
										INNER JOIN ".DEPTS." dp ON dp.dept_id = e.id_dept 
										WHERE e.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND e.emply_id = '".cleanvars($_POST['id_emply'])."' LIMIT 1");

//------------------------------------------------
if(mysqli_num_rows($sqllms)>0) { 
$valuerows = mysqli_fetch_array($sqllms);
echo '
<table width="95%" class="page" border="0" align="center" style="border-collapse:collapse;">
<tr>
	<td width="15%">Department:</td>
	<td align="left" width="35%">'.$valuerows['dept_name'].'</td>
	<td width="15%">Designation:</td>
	<td align="left">'.$valuerows['designation_name'].'</td>
</tr>

<tr>
	<td>Emply #:</td>
	<td align="left">'.$valuerows['emply_no'].'</td>
	<td>Name:</td>
	<td align="left">'.$valuerows['emply_name'].'</td>
</tr>
</table>
<br>
<table style="border-collapse:collapse; border:1px solid #ccc;" align="center"  border="1" width="50%" cellpadding="3" cellspacing="3">
<tr>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Sr#</th>
	<th style="text-align:center; font-size:13px; font-weight:bold;">Dated</th>	
</tr>';
//------------------------------------------------
$srno = 0;
//------------------------------------------------
$date = $_POST['fromdate'];
	// End date
	$end_date = $_POST['todate'];
	
	$counter = 0;
	while (strtotime($date) <= strtotime($end_date)) {
//--------------------total attendance ----------------------------
	$sqllmsattend  = $dblms->querylms("SELECT dated 
										FROM ".EMPLY_ATTENDANCE." el 
										WHERE el.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND el.id_emply = '".cleanvars($valuerows['emply_id'])."'
										AND el.dated  = '".$date."' LIMIT 1 ");
$valueattend = mysqli_fetch_array($sqllmsattend);

//------------------------------------------------
if(!$valueattend['dated']) { 
//-----------check holiday------------------------------------
$sqllmsholids  = $dblms->querylms("SELECT id    
										FROM ".HOLIDAYS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ('".$date."' BETWEEN date_start AND date_end) ");
//------------------------------------------------
	$sqllmswithpaid  = $dblms->querylms("SELECT id    
										FROM ".EMPLY_LEAVES."
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND id_emply = '".cleanvars($valuerows['emply_id'])."'  AND leave_type = '1'
										AND ('".$date."' BETWEEN date_from  AND date_to)");
//------------------------------------------------
	$dayname = date('l', strtotime($date));
if($valuerows['id_shift'] != 6 && $dayname != 'Sunday' && (mysqli_num_rows($sqllmsholids)<1) && (mysqli_num_rows($sqllmswithpaid)<1)) { 
//------------------------------------------------
$srno++;
echo '
<tr>
	<td style="text-align:center; font-size:12px; width:35px;">'.$srno.'</td>
	<td style="text-align:left; font-size:12px;">'.date("l, d/m/Y", strtotime($date)).'</td>
</tr>';
//------------------------------------------------
} else if($valuerows['id_shift'] == 6 && $dayname != 'Friday' && (mysqli_num_rows($sqllmsholids)<1) && (mysqli_num_rows($sqllmswithpaid)<1)) { 
//------------------------------------------------
$srno++;
echo '
<tr>
	<td style="text-align:center; font-size:12px; width:35px;">'.$srno.'</td>
	<td style="text-align:left; font-size:12px;">'.date("l, d/m/Y", strtotime($date)).'</td>
</tr>';
}
//------------------------------------------------
}
 $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
}
//------------------------------------------------
echo '
</table>
	<td>
</tr>
</table>
<div class="page-break"></div>';
//------------------------------------------------
}
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