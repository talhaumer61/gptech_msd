<?php
$priorityLevels = array(
    1       =>      'Low'       ,
    2       =>      'Medium'    ,
    3       =>      'High'      
);

function get_priority_level($id) {
	
	$listPriority = array (
								  '1'	=> '<span class="label label-info" id="bns-status-badge">Low</span>'				
								, '2'	=> '<span class="label label-warning" id="bns-status-badge">Medium</span>'				
								, '3'	=> '<span class="label label-danger" id="bns-status-badge">High</span>'				
							 );
	return $listPriority[$id];
}

$taskStatus = array(
    1       =>      'Not Started Yet'    ,
    2       =>      'In Progress'        ,
    3       =>      'Completed'         
);

function get_complaint_status($id) {
	
	$listTaskStatus = array (
								  '1'	=> '<span class="label label-warning" id="bns-status-badge">Not Started Yet</span>'				
								, '2'	=> '<span class="label label-info" id="bns-status-badge">In Progress</span>'				
								, '3'	=> '<span class="label label-success" id="bns-status-badge">Completed</span>'				
							 );
	return $listTaskStatus[$id];
}

$departments = array(
    1       =>      'Sales'    ,
    2       =>      'Store'        ,
    3       =>      'Accounts'         
);

function get_department($id) {
	
	$listDepartments = array (
								  '1'	=> '<span class="label label-warning" id="bns-status-badge">Sales</span>'				
								, '2'	=> '<span class="label label-info" id="bns-status-badge">Store</span>'				
								, '3'	=> '<span class="label label-success" id="bns-status-badge">Accounts</span>'				
							 );
	return $listDepartments[$id];
}
?>