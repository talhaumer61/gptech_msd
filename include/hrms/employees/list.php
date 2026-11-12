<?php 

//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *   
										FROM ".EMPLOYEES." emp 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = emp.id_designation  
										INNER JOIN ".DEPTS." dep ON dep.dept_id = emp.id_dept   
										WHERE emp.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY emp.emply_no ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *     
										FROM ".EMPLOYEES." emp 
										INNER JOIN ".DESIGNATIONS." des ON des.designation_id = emp.id_designation  
										INNER JOIN ".DEPTS." dep ON dep.dept_id = emp.id_dept   
										WHERE emp.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY emp.emply_no ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="text-align:center;">Emply #</th>
	<th width="35px" style="text-align:center;">Pic</th>
	<th> Employee Name</th>
	<th> Phone</th>
	<th> Email</th>
	<th> Designation</th>
	<th> Department</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['emply_status']);
if($rowstd['id_shift']) { 
	$shftid = $rowstd['id_shift'];
} else { 
	$shftid = '';
}
//------------------------------------------------
if($rowstd['emply_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/employees/'.$rowstd['emply_photo'].'" alt="'.$rowstd['emply_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/employees/default.png" alt="'.$rowstd['emply_name'].'"/>';
}

if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'edit' => '1'))) { 
	$bankname  = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Employees" data-height="350" data-width="100%" data-com-status="'.$rowstd['emply_status'].'" data-com-emplyno="'.$rowstd['emply_no'].'" data-com-name="'.$rowstd['emply_name'].'" data-com-fathername="'.$rowstd['emply_fathername'].'" data-com-phone="'.$rowstd['emply_cellno'].'" data-com-cnic="'.$rowstd['emply_cnic'].'" data-com-email="'.$rowstd['emply_email'].'" data-com-address="'.$rowstd['emply_address'].'" data-com-address="'.$rowstd['emply_address'].'" data-com-joindate="'.$rowstd['emply_joindate'].'" data-com-bsalary="'.$rowstd['emply_basicsalary'].'" data-com-designation="'.$rowstd['id_designation'].'" data-com-dept="'.$rowstd['id_dept'].'" data-com-shift="'.$shftid.'" data-com-id="'.$rowstd['emply_id'].'" data-target="#editCountryModal">'.$rowstd['emply_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Employees" data-height="350" data-width="100%" data-com-status="'.$rowstd['emply_status'].'" data-com-emplyno="'.$rowstd['emply_no'].'" data-com-name="'.$rowstd['emply_name'].'" data-com-fathername="'.$rowstd['emply_fathername'].'"  data-com-phone="'.$rowstd['emply_cellno'].'" data-com-cnic="'.$rowstd['emply_cnic'].'" data-com-email="'.$rowstd['emply_email'].'" data-com-address="'.$rowstd['emply_address'].'" data-com-address="'.$rowstd['emply_address'].'" data-com-joindate="'.$rowstd['emply_joindate'].'" data-com-bsalary="'.$rowstd['emply_basicsalary'].'" data-com-designation="'.$rowstd['id_designation'].'" data-com-dept="'.$rowstd['id_dept'].'" data-com-shift="'.$shftid.'" data-com-id="'.$rowstd['emply_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['emply_name'];
	$bankedit = ' ';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:70px; text-align:center;">'.$rowstd['emply_no'].'</td>
	<td>'.$stdphoto.'</td>
	<td style="min-width:250px;">'.$bankname.' </td>
	<td>'.$rowstd['emply_cellno'].'</td>
	<td>'.$rowstd['emply_email'].'</td>
	<td>'.$rowstd['designation_name'].'</td>
	<td>'.$rowstd['dept_name'].'</td>
	<td style="text-align:center; width:50px;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'delete' => '1'))) { 	
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
	$Nav .= '<li><a href="employees.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="employees.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="employees.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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