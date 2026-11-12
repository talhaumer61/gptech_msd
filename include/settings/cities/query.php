<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'city_id'							
							, 'where' 		=> array ( 
														  'city_name' => cleanvars(trim($_POST['city_name'])) 
													 ) 
							, 'return_type' => 'count' 
						); 
    $sqllmscheck = $dblms->getRows(CITIES, $conditions);
	
if(($sqllmscheck)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>City name already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	
} else {
	
//------------------------------------------------
		$data = array(
						  'city_status'		=> cleanvars($_POST['city_status'])	
						, 'city_name'		=> cleanvars(trim($_POST['city_name']))
						, 'id_district'	   	=> cleanvars($_POST['id_district'])					
						, 'id_added'	   	=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'	   	=> date("Y-m-d H:i:s")
					);

		$sqllms  = $dblms->Insert(CITIES , $data);

//--------------------------------------
	if($sqllms) { 
//--------------------------------------
		$remarks = 'Add City: '.cleanvars($_POST['city_name']).' details';
		$datalog = array(
						  'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'filename'	    => strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
						, 'action'		    => 1
						, 'dated'		    => date("Y-m-d H:i:s")
						, 'ip'		    	=> cleanvars($ip)
						, 'remarks'			=> cleanvars($remarks)
						, 'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
						, 'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
			);
		$sqllmslog  = $dblms->Insert(LOGS , $datalog);
		
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
 }// end check customer name 
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
	
//------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'city_id'							
							, 'where' 		=> array ( 
														  'city_name' => cleanvars(trim($_POST['city_name_edit'])) 
													 )
							, 'return_type' => 'count' 
						); 
    $sqllmscheck = $dblms->getRows(CITIES, $conditions);
	
if(($sqllmscheck)>1) { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>City <span style="color:#f00;">"'.$_POST['city_name_edit'].'"</span> already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	
} else {	
	
//------------------------------------------------
	$data = array(
						  'city_status'		=> cleanvars($_POST['city_status_edit'])	
						, 'city_name'		=> cleanvars(trim($_POST['city_name_edit']))
						, 'id_district'	   	=> cleanvars($_POST['id_district_edit'])					
						, 'id_modify'	   	=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'	   	=> date("Y-m-d H:i:s")
					);

	$sqllms = $dblms->Update(CITIES, $data, "WHERE city_id = '".cleanvars($_POST['city_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
		$remarks = 'Update City: '.cleanvars($_POST['city_name_edit']).' details';
		$datalog = array(
						  'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'filename'	    => strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
						, 'action'		    => 2
						, 'dated'		    => date("Y-m-d H:i:s")
						, 'ip'		    	=> cleanvars($ip)
						, 'remarks'			=> cleanvars($remarks)
						, 'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
						, 'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
			);
		$sqllmslog  = $dblms->Insert(LOGS , $datalog);
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} // end query successfully run
} // end check customer name
//--------------------------------------
} // end submit
 