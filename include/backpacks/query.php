<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
	$conditions = array ( 
							  'select' 		=> 'package_id'								
							, 'where' 		=> array( 
													  'package_name' => cleanvars(trim($_POST['package_name'])) 
													, 'id_class' 	 => cleanvars(($_POST['id_class']))
													, 'id_brand' 	 => cleanvars(($_POST['id_brand']))
												)
							, 'return_type' => 'count' 
						); 
    $sqllmscheck 	= $dblms->getRows(PACKAGES, $conditions);
if(($sqllmscheck)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Package name already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	
} else {
	$dataInv = array(
						  'package_status'		=> '1'
						, 'package_name'		=> cleanvars($_POST['package_name'])
						, 'package_detail'		=> cleanvars($_POST['package_detail'])
						, 'id_brand'			=> cleanvars($_POST['id_brand'])
						, 'id_class'			=> cleanvars($_POST['id_class'])
						, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'			=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(PACKAGES , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$countorder = $latest_id;

		if($countorder<9) {
			$orderno = 'BPK-00000'.($countorder);
		} else if($countorder<99) {
			$orderno = 'BPK-0000'.($countorder);
		} else if($countorder<999) {
			$orderno = 'BPK-000'.($countorder);
		} else if($countorder<9999) {
			$orderno = 'BPK-00'.($countorder);
		} else if($countorder<99999) {
			$orderno = 'BPK-0'.($countorder);
		}else {
			$orderno = 'BPK-'.($countorder);
		}
		
		$packageitems 	= 0;
		$packageqty 	= 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk]) && !empty($_POST['qty'][$ichk])) {
		
///----------------------------------------------
			$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".PACKAGES_DETAIL."   
											WHERE id_package = '".cleanvars($latest_id)."' 
											AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$dataInvDetail = array (
												  'id_package'	=> cleanvars($latest_id)
												, 'id_item'		=> cleanvars($_POST['id_item'][$ichk])
												, 'qty'			=> cleanvars($_POST['qty'][$ichk])
											);

					$sqllmsInsertDetail  = $dblms->Insert(PACKAGES_DETAIL,$dataInvDetail);
					$packageqty = ($packageqty  + $_POST['qty'][$ichk]);
					$packageitems = ($packageitems  + 1);

				}
			}

		}
		
		$dataUpdate = array (
						  		  'package_no'		=> $orderno								
						  		, 'package_items'	=> $packageitems								
						  		, 'package_qty'		=> $packageqty								
							);		

		$qryUpdate = $dblms->Update(PACKAGES, $dataUpdate, "WHERE package_id = '".$latest_id."'");
		

		$remarks = 'Add Package # : '.cleanvars($orderno).' details';
		
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
		header("Location: backpacks.php", true, 301);
		exit();

	}
}

}

//Update Purchase Order
if(isset($_POST['submit_changes'])) { 
	
	$dataInv = array(
						  'package_status'		=> '1'
						, 'package_name'		=> cleanvars($_POST['package_name'])
						, 'package_detail'		=> cleanvars($_POST['package_detail'])
						, 'id_brand'			=> cleanvars($_POST['id_brand'])
						, 'id_class'			=> cleanvars($_POST['id_class'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);
	
	$qryUpdate = $dblms->Update(PACKAGES, $dataInv, "WHERE package_id = '".cleanvars($_POST['package_id'])."'");
	

	if($qryUpdate) { 
		

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".PACKAGES_DETAIL."  WHERE id_package = '".cleanvars($_POST['package_id'])."'");
		
		$packageitems 	= 0;
		$packageqty 	= 0;

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk]) && !empty($_POST['qty'][$ichk])) { 
				
				$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".PACKAGES_DETAIL."   
																WHERE id_package = '".cleanvars($_POST['package_id'])."' 
																AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
				
					$dataInvDetail = array (
												  'id_package'	=> cleanvars($_POST['package_id'])
												, 'id_item'		=> cleanvars($_POST['id_item'][$ichk])
												, 'qty'			=> cleanvars($_POST['qty'][$ichk])
											);

					$sqllmsInsertDetail  = $dblms->Insert(PACKAGES_DETAIL,$dataInvDetail);
					$packageqty = ($packageqty  + $_POST['qty'][$ichk]);
					$packageitems = ($packageitems  + 1);
			}

		}
		
		$dataUpdate = array (
						  		  'package_items'	=> $packageitems								
						  		, 'package_qty'		=> $packageqty								
							);		

		$packageUpdate = $dblms->Update(PACKAGES, $dataUpdate, "WHERE package_id = '".$_POST['package_id']."'");

		$remarks = 'Update Package ID : '.cleanvars($_POST['package_id']).' details';
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
		header("Location: backpacks.php", true, 301);
		exit();

	}
}

