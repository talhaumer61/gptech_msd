<?php 
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
<h1>Monthly Attendance Report</h1>
<h3>From Date: <u>'.$_POST['fromdate'].'</u> To Date: <u>'.$_POST['todate'].'</u></h3><br>';
//------------------------------------------------
									
	$sqllms  	= $dblms->querylms("SELECT *  
										FROM ".EMPLY_ATTENDANCE." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation  
										WHERE e.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND el.id_dept  = '".cleanvars($_POST['id_dept'])."' LIMIT 1");
//------------------------------------------------
if(mysqli_num_rows($sqllms)>0) { 
//------------------------------------------------
echo '
<table style="border-collapse:collapse; border:1px solid #ccc;" align="center"  border="1" width="50%" cellpadding="3" cellspacing="3">
<tr>
	<th style="text-align:center;">Sr.#</th>
	<th style="text-align:center;">Emply #</th>
	<th>Employee Name</th>
	<th>Designation</th>
	<th>Department</th>
	<th style="text-align:center;">Dated</th>
	<th style="text-align:center;">Clock In</th>
	<th style="text-align:center;">Clock Out</th>
	<th style="text-align:center;">Working Hours</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
echo'
<tr>
	<td style="width:70px; text-align:center;">'.$srno.'</td>
	<td  style="text-align:center; width:70px;">'.$rowstd['emply_no'].'</td>
	<td>'.$rowstd['emply_name'].'</td>
	<td>'.$rowstd['designation_name'].'</td>
	<td>'.$rowstd['dept_name'].'</td>
	<td style="width:90px; text-align:center;">'.$rowstd['dated'].'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['clock_in'].'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['clock_out'].'</td>
	<td style="width:110px; text-align:center;">'. $interval->format('%H:%i').'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
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