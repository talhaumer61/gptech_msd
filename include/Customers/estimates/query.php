<?php 
// ADD ESTIMATE
if(isset($_POST['submit_estimate'])) { 
	
	$conditions = array ( 
							  'select' 		=> 'estimate_id'
							, 'order_by' 	=> ' estimate_id DESC'
							, 'return_type' => 'single' 
						); 
    $reultorder 	= $dblms->getRows(ESTIMATES, $conditions);
	$countorder 	= $reultorder['estimate_id'];
		
	if($countorder<9) {
		$orderno = 'EST-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'EST-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'EST-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'EST-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'EST-0'.($countorder+1);
	}else {
		$orderno = 'EST-'.($countorder+1);
	}
	

	$dataEst = array(
						  'estimate_status'		=> '1'
						, 'estimate_no'			=> cleanvars($orderno)
						, 'estimate_date'		=> date('Y-m-d')
						, 'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'			=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(ESTIMATES , $dataEst);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$Estgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			// CHECK ID IF NOT EMPTY
			if(!empty($_POST['id_item'][$ichk])) {
		
			$sqllmsitemchecker  = $dblms->querylms("SELECT id FROM ".ESTIMATES_DETAIL."   
															  WHERE  id_estimate = '".cleanvars($latest_id)."' 
															  AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

				$Estgrandtotal = ($Estgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
											  'id_estimate'		=> cleanvars($latest_id)
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);

					
				}
			}

		}
		

		$remarks = 'Add Customer Estimate  # : '.cleanvars($orderno).' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
		unset($_SESSION['cart']);

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		
		header("Location: customerestimates.php?view=payments&id=".$latest_id."", true, 301);
		exit();

	}

}

//UPDATE ESTIMATE
if(isset($_POST['submit_changes'])) { 

	$proStatus = '1';


	
	$dataInv = array(

						  'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);

	$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".cleanvars($_POST['estimate_id'])."'");


	if($qryUpdate) { 

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".ESTIMATES_DETAIL."  WHERE id_estimate = '".cleanvars($_POST['estimate_id'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$sqllmsitemchecker  = $dblms->querylms("SELECT id FROM ".ESTIMATES_DETAIL."   
																WHERE  id_estimate = '".cleanvars($_POST['estimate_id'])."' 
																AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
				if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


						$dataInvDetail = array(
												  'id_estimate'		=> cleanvars($_POST['estimate_id'])
												, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
												, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
												, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
												, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
												, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
											);

						$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);


					}
			}

		}

		$remarks = 'Update Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
		unset($_SESSION['cart']);
		unset($_SESSION['estimate_id']);

		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: customerestimates.php?view=payments&id=".cleanvars($_POST['estimate_id']), true, 301);
		exit();

	}
}

// REQUEST AMOUNT
if(isset($_POST['submit_request'])) { 

	$date_remaining_payment = date('Y-m-d', strtotime($_POST['date_remaining_payment']));

	$dataInv = array(
						  'estimate_status'			=> '4'					
						, 'request_amount'			=> cleanvars($_POST['request_amount'])
						, 'date_remaining_payment'	=> cleanvars($date_remaining_payment)
						, 'id_modify'				=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'				=> date("Y-m-d H:i:s")											
					);

	$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");
	

	if($qryUpdate) { 

		$remarks = 'Request Payment Generated Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);


		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Request Payment Generated</div>';
		header("Location: customerestimates.php", true, 301);
		exit();

	}
}


//submit_converttojoborder
if(isset($_POST['submit_converttojoborder'])) { 

	if($_POST['submit_converttojoborder'] == 'savehold') {
		$hredredirect = 'customerestimates.php';
	} else {
		$hredredirect = 'customerestimates.php?view=payments&id='.$_POST['estimate_id'];
	}

	$dataInv = array(
						  'estimate_status'		=> 1
						, 'estimate_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'request_amount'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'estimate_remarks'	=> cleanvars($_POST['estimate_remarks'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);
	
	

	$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");
	

	if($qryUpdate) { 

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".ESTIMATES_DETAIL."  WHERE id_estimate = '".cleanvars($_POST['estimate_id'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {


					$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
												  'id_estimate'		=> cleanvars($_POST['estimate_id'])
												, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
												, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
												, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
												, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
												, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
										  );

					$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);


			}

		}

		$remarks = 'Update Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);


		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location:".$hredredirect."", true, 301);
		exit();

	}
}

