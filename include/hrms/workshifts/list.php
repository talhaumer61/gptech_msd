<?php 
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *   
										FROM ".SHIFTS."   
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY shift_id DESC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * 
										FROM ".SHIFTS."  
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY shift_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
	Total Records: ('.number_format(($count)).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">Sr.#</th>
	<th>Shift Name</th>
	<th> Detail</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
$srno++;
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['shift_status']);
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td style="width:300px;">'.$rowstd['shift_name'].'</td>
	<td>'.$rowstd['shift_detail'].'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">';
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="workshifts.php?id='.$rowstd['shift_id'].'"><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'delete' => '1'))) { 
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
	$Nav .= '<li><a href="workshifts.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="workshifts.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="workshifts.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
