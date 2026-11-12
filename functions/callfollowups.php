<?php
$call_statuses = array(
							 1       =>      'Connected' 
							,2       =>      'No Answer' 
							,3       =>      'Busy'      
							,4       =>      'Switched Off'      
							,5       =>      'Wrong Number'      
							,6       =>      'Callback Requested'  
						);

$call_purposes = array(
							 1       =>      'Payment recovery' 
							,2       =>      'Order follow-up' 
							,3       =>      'Sales inquiry'      
							,4       =>      'Delivery update'      
							,5       =>      'Complaint / issue'      
							,6       =>      'Stock / availability'  
							,7       =>      'General follow-up'  
						);

$priorityLevels = array(
    1       =>      'Low'       ,
    2       =>      'Medium'    ,
    3       =>      'High'      
);

function get_call_status($id) {
	
	$listPriority = array (
								  '1'	=> '<span class="label label-success" id="bns-status-badge">Connected</span>'				
								, '2'	=> '<span class="label label-warning" id="bns-status-badge">No Answer</span>'				
								, '3'	=> '<span class="label label-warning" id="bns-status-badge">Busy</span>'				
								, '4'	=> '<span class="label label-default" id="bns-status-badge">Switched Off</span>'				
								, '5'	=> '<span class="label label-danger" id="bns-status-badge">Wrong Number</span>'				
								, '6'	=> '<span class="label label-info" id="bns-status-badge">Callback Requested</span>'				
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