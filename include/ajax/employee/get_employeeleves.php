<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['id_emply'])) {
	$emplyno = $_GET['id_emply']; 
//--------------------------------------------	
	$sqllmsleaves  = $dblms->querylms("SELECT abs(datediff(el.date_from,el.date_to))+1 as difference, el.id, el.leave_type, l.leave_name, 
										el.id_leave, el.date_from, el.date_to, el.id_leave, el.reason, el.duration, el.alternate_emply, d.dept_name      
										FROM ".EMPLY_LEAVES." el 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept 
										INNER JOIN ".LEAVES." l ON l.leave_id = el.id_leave 
										WHERE el.id_emply = '".cleanvars($_GET['id_emply'])."' 
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
<h4 class="modal-title" style="font-weight:700; color:green;">Leaves Balance</h4>
	<span style="font-weight:600; color:blue;">Casual Leave: '.(24-$CasualLeave).'</span>
	<span style="margin-left:100px;font-weight:600; color:blue;">Medical Leave: '.(8-$MedicalLeave).'</span>
</tr>
</thead>
</table>';
}
//--------------------------------------------
?>