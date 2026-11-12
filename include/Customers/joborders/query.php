<?php 
//Add Purchase Order
if(isset($_POST['submit_order'])) { 

	//Check if order # already exist
	$conditions = array ( 
								'select' 		=> 'job_order_no',
								'where' 		=> array ( 
														  	'job_order_no' 	=> cleanvars(trim($_POST['job_order_no'])) 
													 	), 
								'return_type' 	=> 'count' 
							); 
    $sqllmscheck = $dblms->getRows(JOB_ORDER, $conditions);
	

	//If already order then show error and exit
	if($sqllmscheck>0) { 

		//Set Error MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Job Order: '.cleanvars($_POST['job_order_no']).' already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else { 
		
		$conditions = array ( 
								'select' 		=> 'job_order_id',
								'order_by' 		=> 'job_order_id DESC',
								'return_type' 	=> 'single' 
							); 
    	$reultorder = $dblms->getRows(JOB_ORDER, $conditions);
		$countorder = $reultorder['job_order_id'];
			
		if($countorder<9) {
			$orderno = 'J-00000'.($countorder+1);
		} else if($countorder<99) {
			$orderno = 'J-0000'.($countorder+1);
		} else if($countorder<999) {
			$orderno = 'J-000'.($countorder+1);
		} else if($countorder<9999) {
			$orderno = 'J-00'.($countorder+1);
		} else if($countorder<99999) {
			$orderno = 'J-0'.($countorder+1);
		}else {
			$orderno = 'J-'.($countorder+1);
		}

		//Remaining Amount
		$remainingAmount = $_POST['inV_grandtotal']; 
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		//Insert Query Fields & Values
		$dataInv = array(
			'job_order_status'	=> '1'													,
			'id_ade'			=> cleanvars($_POST['id_ade'])							,
			'id_customer'		=> cleanvars($_POST['id_customer'])						,
			'job_order_no'		=> cleanvars($orderno)									,
			'dated'				=> cleanvars($dated)									,
			'total'				=> cleanvars($_POST['inV_grandtotal'])					,
			'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))			,
			'paid_date'			=> date('Y-m-d')										,
			'id_company'		=> cleanvars($_POST['id_company'])						,
			'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	,
			'date_added'		=> date('Y-m-d h:i:s')									,
			'balance'			=> cleanvars($_POST['inV_receiveable'])					,
			'opening_balance'	=> cleanvars($_POST['customer_openingbalance'])			,
			'grand_total'		=> cleanvars($_POST['inV_receiveable'])					,
			'remarks'			=> cleanvars($_POST['remarks'])							
		);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataInv);

		//If Insert Query Executed
		if($sqllmsInsert) { 

			//latest PK of Table
			$idLatest = $dblms->lastestid();
			
			$JOgrandtotal = 0;

			//Iterate over Items Array
			for($ichk=0; $ichk<sizeof($_POST['id_item']); $ichk++){

				//Check if ID item is not empty
				if(!empty($_POST['id_item'][$ichk])) {	
					$detailconditions = array ( 
												'select' 		=> 'id',
												'where' 		=> array ( 
																			  'id_job_order' 	=> cleanvars($idLatest) 
																			, 'id_item' 		=> cleanvars($_POST['id_item'][$ichk])
																		), 
												'return_type' 	=> 'count' 
											); 
    				$sqllmsitemchecker = $dblms->getRows(JOB_ORDER_DETAILS, $detailconditions);

					if(($sqllmsitemchecker) == 0) {
						
						$JOgrandtotal = ($JOgrandtotal + $_POST['total_price'][$ichk]);

								$dataOrderDetail = array(
									'id_job_order'			=> cleanvars($idLatest)								,
									'id_company'			=> cleanvars($_POST['id_company'])					,
									'id_item'				=> cleanvars($_POST['id_item'][$ichk])				,
									'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])			,
									'discount'				=> cleanvars($_POST['discount_percentage'][$ichk])	,
									'total_price'			=> cleanvars($_POST['total_price'][$ichk])			,
									'total_qty'				=> cleanvars($_POST['total_qty'][$ichk])			

								);
								$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);

								unset($sqllmsInsertDetail);
					}

				}
			}
		
			$dataupdateInv = array(
				'total'				=> cleanvars($JOgrandtotal)				,
				'balance'			=> cleanvars($JOgrandtotal + $_POST['customer_openingbalance'])		,
				'grand_total'		=> cleanvars($JOgrandtotal + $_POST['customer_openingbalance'])
			);

			$qryUpdate2nd = $dblms->Update(JOB_ORDER, $dataupdateInv, "WHERE job_order_id = '".$idLatest."'");
	
			//Insert Log Remarks
			$remarks = 'Add Job Order: "'.cleanvars($_POST['job_order_no']).'" Details';
			//Insert Query Fields & Values
			$dataLog = array(
				'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		,
				'filename'		=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)	,
				'action'		=> 1														,
				'dated'			=> date('Y-m-d h:i:s')										,
				'ip'			=> cleanvars($ip)											,
				'remarks'		=> cleanvars($remarks)										,
				'id_office'		=> cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])		,
				'id_company'	=> cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])										
			);

			//Execute Insert Query
			$sqllmsInsertLog  = $dblms->Insert(LOGS , $dataLog);

			//Set Success MSG in Session & Exit
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
			header("Location: sale-orders.php", true, 301);
			exit();
		}

	}

}


//Update Purchase Order
if(isset($_POST['bill_changes'])) { 

	//Assign Job Order Status
	if($_POST['bill_changes'] == 'savehold') {
		$jobOrderStatus = '1';
	} else if($_POST['bill_changes'] == 'saveforward') {
		$jobOrderStatus = '2';
	}	

	$balance = $_POST['inV_receiveable'] - $_POST['advance']; 
	$dataOrder = array(
		'job_order_status'	=> $jobOrderStatus										,
		'total'				=> cleanvars($_POST['inV_grandtotal'])					,
		'advance'			=> cleanvars($_POST['advance'])							,
		'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))			,
		'paid_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date']))),
		'paid_method'		=> cleanvars($_POST['payment_method'])					,
		'id_account'		=> cleanvars($_POST['id_account'])						,
		'deposit_slip'		=> cleanvars($_POST['deposit_slip'])					,
		'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	,
		'date_modified'		=> date('Y-m-d h:i:s')									,
		'balance'			=> cleanvars($balance)									,
		'grand_total'		=> cleanvars($_POST['inV_receiveable'])					,
		'remarks'			=> cleanvars($_POST['remarks'])							
	);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(JOB_ORDER , $dataOrder , " WHERE job_order_id = '".cleanvars($_GET['id'])."'");

	//If Update Query Executed
	if($sqllmsUpdate) { 
		
		//Delete Previous Order Details
		$sqllmsDel  = $dblms->querylms("DELETE FROM ".JOB_ORDER_DETAILS." WHERE id_job_order = '".cleanvars($_GET['id'])."'");

		//Iterate over Items Array
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){
			
			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$dataOrderDetail = array(
					'id_job_order'			=> cleanvars($_GET['id'])							,
					'id_company'			=> cleanvars($_POST['id_company'])					,
					'id_item'				=> cleanvars($_POST['id_item'][$ichk])				,
					'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])			,
					'discount'				=> cleanvars($_POST['discount_percentage'][$ichk])	,
					'total_price'			=> cleanvars($_POST['total_price'][$ichk])			,
					'total_qty'				=> cleanvars($_POST['total_qty'][$ichk])			
	
				);
				$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);
			
				unset($sqllmsInsertDetail);
			}
		}

		//Insert Log Remarks
		$remarks = 'Update Job Order: "'.cleanvars($_POST['job_order_no']).'" Details';
		//Insert Query Fields & Values
			$dataLog = array(
				'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		,
				'filename'		=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)	,
				'action'		=> 2														,
				'dated'			=> date('Y-m-d h:i:s')										,
				'ip'			=> cleanvars($ip)											,
				'remarks'		=> cleanvars($remarks)										,
				'id_office'		=> cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])		,
				'id_company'	=> cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])										
			);

			//Execute Insert Query
			$sqllmsInsertLog  = $dblms->Insert(LOGS , $dataLog);
		
	
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: sale-orders.php", true, 301);
		exit();
	
	}
}