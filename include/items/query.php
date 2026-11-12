<?php 

if(isset($_POST['submit_add'])) { 
	
	$conditions = array ( 
							  'select' 		=> 'item_id'								
							, 'where' 		=> array( 
													  'item_name' => cleanvars(trim($_POST['item_name'])) 
													, 'item_code' => cleanvars(trim($_POST['item_code']))
												)
							, 'return_type' => 'count' 
						); 
    $sqllmscheck 	= $dblms->getRows(ITEMS, $conditions);
	
	if(($sqllmscheck)>0) { 
			$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Item name already exists.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		
	} else {
		
			$data = array (
								'item_status'			=> cleanvars($_POST['item_status'])
								, 'item_code'			=> cleanvars($_POST['item_code'])
								, 'id_cat'				=> cleanvars($_POST['id_cat'])
								, 'id_brand'			=> cleanvars(implode(",",$_POST['id_brand']))
								, 'id_publisher'		=> cleanvars($_POST['id_publisher'])
								, 'item_name'			=> cleanvars($_POST['item_name'])
								, 'item_reorder'		=> cleanvars($_POST['item_reorder'])
								, 'item_maxquantity'	=> cleanvars($_POST['item_maxquantity']) 
								, 'item_details'		=> cleanvars($_POST['item_details'])
								, 'item_pricepurchase'	=> cleanvars($_POST['item_pricepurchase'])
								, 'item_pricesale'		=> cleanvars($_POST['item_pricesale'])
								, 'item_pricedealership'=> cleanvars($_POST['item_pricedealership'])
								, 'item_priceretail'	=> cleanvars($_POST['item_priceretail'])
								, 'item_classes'		=> cleanvars(implode(",",$_POST['item_classes']))
								, 'item_weight'			=> cleanvars($_POST['item_weight'])
								, 'cgs'					=> cleanvars($_POST['cgs'])
								, 'income_department'	=> cleanvars($_POST['income_department'])	
						);

			$sqllmsItem  = $dblms->Insert(ITEMS , $data);
			$_SESSION['msg']['status'] =  '';
			
		if($sqllmsItem) { 
			//latest PK of Table
			$idLatest = $dblms->lastestid();
			//Check File is not empty
			if(!empty($_FILES['std_photo']['name'])) { 

				//File Extension
				$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
				$extension 		= strtolower($path_parts['extension']);

				//Check File extension
				if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) {

					//File Path
					
					$directoryName 	= 'uploads/items';

					//Set File Name
					$img_dir		= $directoryName."/";
					$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['item_code'])).'_'.$idLatest.".".($extension);
					$img_fileName	= to_seo_url(cleanvars($_POST['item_code'])).'_'.$idLatest.".".($extension);

					//Update File Name in DB
					$dataUpload = array (
											'item_photo'	=> $img_fileName
										);
					$sqllmsUpload = $dblms->Update(ITEMS, $dataUpload, "WHERE item_id = '".$idLatest."'");
					
					//Move File to the Directory
					$mode = '0644';
					move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
					chmod ($originalImage, octdec($mode));

					
				} else{
					//Set Error MSG in Session
					$_SESSION['msg']['status'] .= '<div class="alert-box warning">Photo not uploaded. Only jpg ,jpeg, gif and png format allowed.</div>';
					
				}

			}
			$remarks = 'Add Item: '.cleanvars($_POST['item_name']).' details';
			$dataLog = array (
								'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '1'
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
								, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
								, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
							);
			
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
			
			$_SESSION['msg']['status'] .= '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
			
		}
	}

}

if(isset($_POST['submit_changes'])) { 
	

	$data = array (
						  'item_status'			=> cleanvars($_POST['item_status_edit'])
						, 'item_code'			=> cleanvars($_POST['item_code_edit'])
						, 'id_cat'				=> cleanvars($_POST['id_cat_edit'])
						, 'id_brand'			=> cleanvars(implode(",",$_POST['id_brand_edit']))
						, 'id_publisher'		=> cleanvars($_POST['id_publisher_edit'])
						, 'item_name'			=> cleanvars($_POST['item_name_edit'])
						, 'item_reorder'		=> cleanvars($_POST['item_reorder_edit'])
						, 'item_maxquantity'	=> cleanvars($_POST['item_maxquantity_edit']) 
						, 'item_details'		=> cleanvars($_POST['item_details_edit'])
						, 'item_pricepurchase'	=> cleanvars($_POST['item_pricepurchase_edit'])
						, 'item_pricesale'		=> cleanvars($_POST['item_pricesale_edit'])
						, 'item_pricedealership'=> cleanvars($_POST['item_pricedealership_edit'])
						, 'item_priceretail'	=> cleanvars($_POST['item_priceretail_edit'])
						, 'item_classes'		=> cleanvars(implode(",",$_POST['item_classes_edit']))
						, 'item_weight'			=> cleanvars($_POST['item_weight_edit'])
						, 'cgs'					=> cleanvars($_POST['cgs_edit'])
						, 'income_department'	=> cleanvars($_POST['income_department_edit'])	
				);
	$qryUpdate = $dblms->Update(ITEMS, $data, "WHERE item_id = '".$_GET['id']."'");

	$_SESSION['msg']['status'] = '';
	
	if($qryUpdate) { 
		

		//Check File is not empty
		if(!empty($_FILES['std_photo']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) {

				//File Path
				
				$directoryName 	= 'uploads/items';

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['item_code_edit'])).'_'.$_GET['id'].".".($extension);
				$img_fileName	= to_seo_url(cleanvars($_POST['item_code_edit'])).'_'.$_GET['id'].".".($extension);

				//Update File Name in DB
				$dataUpload = array (
										'item_photo'	=> $img_fileName
									);
				$sqllmsUpload = $dblms->Update(ITEMS, $dataUpload, "WHERE item_id = '".$_GET['id']."'");
				

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

				
			} else{
				//Set Error MSG in Session
				$_SESSION['msg']['status'] .= '<div class="alert-box warning">Photo not uploaded. Only jpg ,jpeg, gif and png format allowed.</div>';
				
			}

		}
	
		$remarks = 'Update Items: '.cleanvars($_POST['item_name_edit']).' details';

		$dataLog = array (
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
							, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
							, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
		
		$_SESSION['msg']['status'] .= '<div class="alert-box notice"><span>Success: </span>Record update successfully.</div>';
		header("Location: ".$_POST['hrefredirect']."", true, 301);
		exit();
		
	}
	
}
