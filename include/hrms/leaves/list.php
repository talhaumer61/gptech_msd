<?php 
//------------------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT abs(datediff(el.date_from,el.date_to))+1 as difference, el.id, el.leave_type, l.leave_name, 
										el.date_from, el.date_to, el.id_leave, el.reason, el.duration, el.alternate_emply, 
										e.emply_id, e.emply_no, e.emply_name, d.dept_name, des.designation_name       
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation  
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										AND el.date_from LIKE '".date("Y")."%' ORDER BY el.id DESC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT abs(datediff(el.date_from,el.date_to))+1 as difference, el.id, el.leave_type, l.leave_name, 
										el.date_from, el.date_to, el.id_leave, el.reason, el.duration, el.alternate_emply, 
										e.emply_id, e.emply_no, e.emply_name, d.dept_name, des.designation_name       
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = e.id_designation  
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										AND el.date_from LIKE '".date("Y")."%' ORDER BY el.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">Sr.#</th>
	<th style="text-align:center;">Emply #</th>
	<th>Employee Name</th>
	<th>Department</th>
	<th>Leave</th>
	<th style="text-align:center;">Type</th>
	<th style="text-align:center;">Total</th>
	<th>From Date</th>
	<th>To Date</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
$srno++;
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td style="width:70px;text-align:center;">'.$rowstd['emply_no'].'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowstd['emply_no'].' - '.$rowstd['emply_name'].' ('.$rowstd['designation_name'].')</b>" data-src="employeeview.php?id='.$rowstd['emply_id'].'" href="#">'.$rowstd['emply_name'].'</a></td>
	<td>'.$rowstd['dept_name'].'</td>
	<td>'.$rowstd['leave_name'].'</td>
	<td style="text-align:center;">'.get_leavetype($rowstd['leave_type']).'</td>
	<td style="width:60px; text-align:center;">'.$rowstd['difference'].'</td>
	<td style="width:90px;">'.$rowstd['date_from'].'</td>
	<td style="width:90px;">'.$rowstd['date_to'].'</td>
	<td style="text-align:center;">';
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="employeeleaves.php?id='.$rowstd['id'].'"><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'delete' => '1'))) { 
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
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="employeeleaves.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="employeeleaves.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="employeeleaves.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
} // end if id not
