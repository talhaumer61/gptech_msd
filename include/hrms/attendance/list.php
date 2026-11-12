<?php 

//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *    
										FROM ".EMPLY_ATTENDANCE." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY el.id DESC");
//--------------------------------------------------
	$sql_print  = "SELECT *    
										FROM ".EMPLY_ATTENDANCE." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY el.id DESC";
//--------------------------------------------------
	$count = mysqli_num_rows($sqllms);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *      
										FROM ".EMPLY_ATTENDANCE." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY el.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
	<input type="hidden" name="type" value="Attendance">
	<input type="hidden" name="print_sql" value="'.$sql_print.'">
	<button type="submit" class="btn btn-info">Export</button>
	Total Records: ('.number_format($count).')
</form>	
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
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
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
if($page ==1) {  
	$srno = 0;
} else {
	$srno = ($Limit * ($page-1));
}
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$date_a 	= new DateTime(date("h:i:s A", strtotime($rowstd['clock_in'])));
	$date_b 	= new DateTime(date("h:i:s A", strtotime($rowstd['clock_out'])));
	$interval 	= date_diff($date_a,$date_b);
//------------------------------------------------
$srno++;
echo '
<tr>
	<td style="width:70px; text-align:center;">'.$srno.'</td>
	<td  style="text-align:center; width:70px;">'.$rowstd['emply_no'].'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowstd['emply_no'].' - '.$rowstd['emply_name'].' ('.$rowstd['designation_name'].')</b>" data-src="employeeview.php?id='.$rowstd['emply_id'].'" href="#">'.$rowstd['emply_name'].'</a></td>
	<td>'.$rowstd['designation_name'].'</td>
	<td>'.$rowstd['dept_name'].'</td>
	<td style="width:90px; text-align:center;">'.$rowstd['dated'].'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['clock_in'].'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['clock_out'].'</td>
	<td style="width:110px; text-align:center;">'. $interval->format('%H:%i').'</td>
	<td style="text-align:center;">';
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '30', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="attendance.php?id='.$rowstd['id'].'"><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '30', 'delete' => '1'))) { 
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
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
//--------------------------------------------------
$pagination = "";

if($lastpage > 1) {	
//previous button
if ($page > 1) {
	$pagination.= '<li><a href="attendance.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="attendance.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="attendance.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="attendance.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="attendance.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="attendance.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="attendance.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="attendance.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="attendance.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="attendance.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="attendance.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="attendance.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="attendance.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="attendance.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="attendance.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="attendance.php?page='.$next.$sqlstring.'">Next</a></li>';
} else {
	$pagination.= "";
}
	echo $pagination;
}

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
} // end if id not
//--------------------Import----------------------------
