<?php 
//session_save_path('./tmp');

if(isset($_GET['token']) && !empty($_GET['token'])){
    unset($_SESSION['userlogininfo']);
	unset($_SESSION['userroles']);
	session_destroy();
	cpanelLMSAuserLogin();
}

//**********Admin Area Login checking ***********************/
function checkCpanelLMSALogin() {
// if the session id is not set, redirect to login page
	if(!isset($_SESSION['userlogininfo']['LOGINIDA'])) {
		header("Location: login.php");
		exit;
	}else if($_SESSION['userlogininfo']['LOGINAFOR'] == '2'){
		// require_once ("dbsetting/lms_vars_config.php");
		// require_once ("dbsetting/classdbconection.php");
		// require_once ("functions/functions.php");
		$dblms = new dblms();
		// Check if user is a school/customer (logintype or role may indicate that)
		$customerConditions = array(
			'select'        => '*',
			'where'         => array('customer_loginid' => $_SESSION['userlogininfo']['LOGINIDA']),
			'limit'         => 1,
			'return_type'   => 'single'
		);
		$customer = $dblms->getRows(CUSTOMERS, $customerConditions);

		// Define mandatory fields for a complete profile
		$requiredFields = [
			'customer_email',
			'customer_cellno',
			'customer_contactperson',
			'customer_personcell',
			'customer_address',
			'id_city'
		];

		// Check for missing fields
		$incomplete = false;
		foreach ($requiredFields as $field) {
			if (empty($customer[$field])) {
				$incomplete = true;
				break;
			}
		}

		// Store the flag in session
		$_SESSION['profile_incomplete'] = $incomplete;
		
	}
	// For admin logout
	if(isset($_GET['logout'])) {
		panelLMSALogout();
	}
}

//***************Function for admin login*********************
function cpanelLMSAuserLogin() {

	require_once ("dbsetting/lms_vars_config.php");
	require_once ("dbsetting/classdbconection.php");
	require_once ("functions/functions.php");
	$dblms = new dblms();
	if(isset($_GET['token']) && !empty($_GET['token'])){
		
		$Json	= get_dataHashingOnlyExp($_GET['token'], false);
  		$data 	= json_decode($Json, true);

		$loginconditions = array ( 
									'select' 	=> 'a.adm_logintype, a.adm_id, a.adm_type, a.adm_username, a.adm_fullname, a.id_office, a.id_company, c.id_brand',
									'join' 		=> "INNER JOIN ".ADMINS." a ON a.adm_id =  c.customer_loginid ",
									'where' 	=> array( 
															'c.customer_codelhsmes' => $data['customer_token'] 
														), 
									'limit' 		=> 1,
									'return_type' 	=> 'single' 
								); 
		$row = $dblms->getRows(CUSTOMERS.' c', $loginconditions);
		if($row){
			$_SESSION['rollback_url'] 	= $data['rollback_url'];
			$_SESSION['brand'] 			= $row['id_brand'];
		}else{

			$rollback_response = array(
										'title'      => 	'Error'
										,'text'       => 	'You are not authorized to access MSD Portal'
										,'type'       => 	'error'
										,'url'        => 	$data['rollback_url']
									);
			$rollbackJSON = get_dataHashingOnlyExp(json_encode($rollback_response), true);
			if (strpos($data['rollback_url'], '?') !== false) {
			    $redirection = "&rollback_response=".$rollbackJSON."";
            } else {
			    $redirection = "?rollback_response=".$rollbackJSON."";
            }
			header("Location: ".$data['rollback_url'].$redirection."");
			exit();
		}
		
	}else{
        //******* if we found an error save the error message in this variable**********
    	$errorMessage = '';
    	$admin_user   = cleanvars($_POST['login_id']);
    	$admin_pass1  = cleanvars($_POST['login_pass']);
    	$admin_pass3  = md5($admin_pass1);
    
        //*************** first, make sure the adminname & password are not empty******
    	if($admin_user == '') {
    		$errorMessage = 'You must enter your User Name';
    	} else if ($admin_pass3 == '') {
    		$errorMessage = 'You must enter the User Password';
    	} else {
            // **************Check the admin name and password exist*****************
        
        	$loginconditions = array ( 
        								'select' 		=> 'adm_logintype, adm_id, adm_type, adm_username, adm_fullname, id_office, id_company',
        								'where' 		=> array( 
        															'adm_status' 	=> 1 ,
        															'adm_username' 	=> $admin_user, 
        															'adm_userpass' 	=> $admin_pass3 
        														), 
        								'limit' 		=> 1,
        								'return_type' 	=> 'single' 
        							); 
            $row = $dblms->getRows(ADMINS, $loginconditions);
    	}
	}
    //************** if the admin name and password exist then **************** 	
	if (!empty($row)) {

        // ***************Login time when the admin login **************
    	$userlogininfo = array();
    		$userlogininfo['LOGINIDA'] 			= $row['adm_id'];
    		$userlogininfo['LOGINTYPE'] 		= $row['adm_type'];
    		$userlogininfo['LOGINUSER'] 		= $row['adm_username'];
    		$userlogininfo['LOGINNAME'] 		= $row['adm_fullname'];
    		$userlogininfo['LOGINOFFICE'] 		= $row['id_office'];
    		$userlogininfo['LOGINCOMPANY'] 		= $row['id_company'];	
    		$userlogininfo['LOGINAFOR'] 		= $row['adm_logintype'];
    	$_SESSION['userlogininfo'] 				= $userlogininfo;
        
        //----- roles in Array ----
        $rightdata = array();
        	$roleconditions = array ( 
        								'select' 		=> '*',
        								'where' 		=> array( 
        															'id_adm' => cleanvars($row['adm_id'])
        														), 
        								'order_by' 		=> 'right_type ASC',
        								'return_type' 	=> 'all' 
        							); 
        $Roles = $dblms->getRows(ADMIN_ROLES, $roleconditions);
	
    	foreach($Roles as $valueroles) {
    		$rightdata[] = 	array (
    								'right_name' 	=> $valueroles['right_name'],
    								'add' 			=> $valueroles['added'],
    								'edit' 			=> $valueroles['updated'],
    								'delete' 		=> $valueroles['deleted'],
    								'view' 			=> $valueroles['view'],
    								'type' 			=> $valueroles['right_type']
    							);
        }
	
        $_SESSION['userroles'] = $rightdata;

		$remarks = 'Login to Software';
		
		$dataLog = array(
    						  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
    						, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
    						, 'action'		=> '4'
    						, 'dated'		=> date("Y-m-d H:i:s")
    						, 'ip'			=> cleanvars($ip)
    						, 'remarks'		=> cleanvars($remarks)
    						, 'id_office'	=> cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])
    						, 'id_company'	=> cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])
		                );
		                     	
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
		

        //**************Store into session url  Last page visit*******************  
	    header("Location: dashboard.php");

	
	} else {

        //********** admin name and password dosn't much *******************
	    $errorMessage = '<span style="color: red;"><p> Invalid User Name or Password.</p></span>';
	}

    return $errorMessage;
    //mysqli_close($link);
}

//****************Logout Function for admin site *******************************
function panelLMSALogout() {
	if (isset($_SESSION['userlogininfo']['LOGINIDA'])) {
		unset($_SESSION['userlogininfo']);
		unset($_SESSION['userroles']);
		session_destroy();
	}
	if(!empty($_SESSION['rollback_url'])){
	    require_once ("functions/functions.php");
	    $rollback_response = array(
										 'title'      => 	'Success'
										,'text'       => 	'Welcome back From MSD Portal'
										,'type'       => 	'success'
										,'url'        => 	$_SESSION['rollback_url']
									);
		$rollbackJSON = get_dataHashingOnlyExp(json_encode($rollback_response), true);
		if (strpos($_SESSION['rollback_url'], '?') !== false) {
		    $redirection = "&rollback_response=".$rollbackJSON."";
        } else {
		    $redirection = "?rollback_response=".$rollbackJSON."";
        }
		header("Location: ".$_SESSION['rollback_url'].$redirection."");
	}else{
		header("Location: login.php");
	}
	exit;
}
?>