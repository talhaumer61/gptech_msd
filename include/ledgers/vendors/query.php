<?php 
//Update Sale Invoice
if(isset($_POST['submit_payment'])) { 

	$dataadvance = array(
						  'status'			=> '1'
						, 'ledgerfor'		=> '2'
						, 'docs_types'		=> '6'
						, 'id_user'			=> cleanvars($_POST['id_vendor'])
						, 'dated'			=> date('Y-m-d')
						, 'amount'			=> cleanvars($_POST['balance_opening'])
						, 'debit_credit'	=> '1'
						, 'remarks'			=> get_doctype(6)
						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'		=> date("Y-m-d H:i:s")
					);
		
	$sqllmsInsertadvance  = $dblms->Insert(PAYMENTS , $dataadvance);

		
if($sqllmsInsertadvance) {
	//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
}
//--------------------------------------


}
