<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
		$conditions = array ( 
								'select' 		=> 'id',
								'order_by' 		=> 'id DESC',
								'return_type' 	=> 'single' 
							); 
    	$reultorder = $dblms->getRows(STOCKS_TAKING, $conditions);
		$countorder = $reultorder['id'];
			
		if($countorder<9) {
			$orderno = 'ST-00000'.($countorder+1);
		} else if($countorder<99) {
			$orderno = 'ST-0000'.($countorder+1);
		} else if($countorder<999) {
			$orderno = 'ST-000'.($countorder+1);
		} else if($countorder<9999) {
			$orderno = 'ST-00'.($countorder+1);
		} else if($countorder<99999) {
			$orderno = 'ST-0'.($countorder+1);
		}else {
			$orderno = 'ST-'.($countorder+1);
		}

	$dataInv = array(
						  'status'					=> '4'
						, 'taking_no'				=> cleanvars($orderno)
						, 'taking_type'				=> cleanvars($_POST['taking_type'])
						, 'taking_date'				=> date('Y-m-d', strtotime(cleanvars($_POST['taking_date'])))				
						, 'taking_by'				=> cleanvars($_POST['taking_by'])
						, 'remarks'					=> cleanvars($_POST['remarks'])
						, 'id_added'				=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'				=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(STOCKS_TAKING , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$total_systemstock = 0;
		$total_systemstockamount = 0;
		$total_physicallystock = 0;
		$total_physicallyamount = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {
		
///----------------------------------------------
				
			$checkconditions = array ( 
										  'select' 		=> 'id'
										, 'where' 		=> array( 
																	  'id_taking' 	=> cleanvars($latest_id)
																	, 'id_item' 	=> cleanvars($_POST['id_item'][$ichk])
																)
										, 'return_type' => 'count' 
									); 
			$valuechecker 	= $dblms->getRows(STOCKS_TAKINGDETAIL, $checkconditions);
			if(($valuechecker) == 0) {

				$dataInvDetail = array(
											  'id_taking'				=> cleanvars($latest_id)
											, 'id_item'					=> cleanvars($_POST['id_item'][$ichk])
											, 'sale_price'				=> cleanvars($_POST['sale_price'][$ichk])
											, 'system_stock'			=> cleanvars($_POST['system_stock'][$ichk])
											, 'system_stockamount'		=> cleanvars($_POST['system_stockamount'][$ichk])
											, 'physically_stock'		=> cleanvars($_POST['physically_stock'][$ichk])
											, 'physically_stockamount'	=> cleanvars($_POST['physically_stockamount'][$ichk])
									  );

				$sqllmsInsertDetail  = $dblms->Insert(STOCKS_TAKINGDETAIL,$dataInvDetail);
				
				$total_systemstock 		= ($total_systemstock + $_POST['system_stock'][$ichk]);
				$total_systemstockamount= ($total_systemstockamount + $_POST['system_stockamount'][$ichk]);
				$total_physicallystock 	= ($total_physicallystock + $_POST['physically_stock'][$ichk]);
				$total_physicallyamount = ($total_physicallyamount + $_POST['physically_stockamount'][$ichk]);

					
				}
			}

		}
		
			$dataupdateInv = array(
						  'total_systemstock'		=> cleanvars($total_systemstock)
						, 'total_systemstockamount'	=> cleanvars($total_systemstockamount)
						, 'total_physicallystock'	=> cleanvars($total_physicallystock)
						, 'total_physicallyamount'	=> cleanvars($total_physicallyamount)
			);

			$qryUpdate2nd = $dblms->Update(STOCKS_TAKING, $dataupdateInv, "WHERE id = '".$latest_id."'");
	
		

		$remarks = 'Add Stocks Taking # : '.cleanvars($_POST['st_no']).' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		header("Location: stockstaking.php", true, 301);
		exit();

	}

}

//Update Purchase Order
if(isset($_POST['submit_changes'])) { 
	
		//Assign Job Order Status
	if($_POST['submit_changes'] == 'saveconfirmed'){

		$proStatus = '1';

	} else{

		$proStatus = '3';

	}
		
		$dataInv = array(
						  'status'					=> $proStatus 
						, 'taking_type'				=> cleanvars($_POST['taking_type'])
						, 'taking_date'				=> date('Y-m-d', strtotime(cleanvars($_POST['taking_date'])))				
						, 'taking_by'				=> cleanvars($_POST['taking_by'])
						, 'remarks'					=> cleanvars($_POST['remarks'])
						, 'id_modify'				=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'				=> date("Y-m-d H:i:s")											
					);
	

	$qryUpdate = $dblms->Update(STOCKS_TAKING, $dataInv, "WHERE id = '".$_POST['id']."'");
	

	if($qryUpdate) { 

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".STOCKS_TAKINGDETAIL."  WHERE id_taking = '".cleanvars($_POST['id'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				
				$checkconditions = array ( 
										  'select' 		=> 'id'
										, 'where' 		=> array( 
																	  'id_taking' 	=> cleanvars($_POST['id'])
																	, 'id_item' 	=> cleanvars($_POST['id_item'][$ichk])
																)
										, 'return_type' => 'count' 
									); 
				$valuechecker 	= $dblms->getRows(STOCKS_TAKINGDETAIL, $checkconditions);
				if(($valuechecker) == 0) {

					$dataInvDetail = array(
												  'id_taking'				=> cleanvars($_POST['id'])
												, 'id_item'					=> cleanvars($_POST['id_item'][$ichk])
												, 'sale_price'				=> cleanvars($_POST['sale_price'][$ichk])
												, 'system_stock'			=> cleanvars($_POST['system_stock'][$ichk])
												, 'system_stockamount'		=> cleanvars($_POST['system_stockamount'][$ichk])
												, 'physically_stock'		=> cleanvars($_POST['physically_stock'][$ichk])
												, 'physically_stockamount'	=> cleanvars($_POST['physically_stockamount'][$ichk])
										  );

					$sqllmsInsertDetail  = $dblms->Insert(STOCKS_TAKINGDETAIL,$dataInvDetail);
					
					$total_systemstock 		= ($total_systemstock + $_POST['system_stock'][$ichk]);
					$total_systemstockamount= ($total_systemstockamount + $_POST['system_stockamount'][$ichk]);
					$total_physicallystock 	= ($total_physicallystock + $_POST['physically_stock'][$ichk]);
					$total_physicallyamount = ($total_physicallyamount + $_POST['physically_stockamount'][$ichk]);
											


					}
			}

		}
		
		$dataupdateInv = array(
						  'total_systemstock'		=> cleanvars($total_systemstock)
						, 'total_systemstockamount'	=> cleanvars($total_systemstockamount)
						, 'total_physicallystock'	=> cleanvars($total_physicallystock)
						, 'total_physicallyamount'	=> cleanvars($total_physicallyamount)
			);


		$qryUpdate2nd = $dblms->Update(STOCKS_TAKING, $dataupdateInv, "WHERE id = '".$_POST['id']."'");

		$remarks = 'Update Stock Taking ID : '.cleanvars($_POST['id']).' details';
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
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	}
}

