<?php 
//Update Sale Invoice
if(isset($_POST['submit_stock'])) { 



		//Check if ID item is not empty
		if(!empty($_POST['stock_opening'])>0) {
			
			
					
			$dataStck = array(
				'id_item'						=> cleanvars($_POST['id_item'])						,
				'qty'							=> cleanvars($_POST['stock_opening'])				,
				'stock_type'					=> 1												,
				'reference_no'					=> ''												,
				'reference_type'				=> 4												,
				'dated'							=> date('Y-m-d')									,
				'remarks'						=> get_stockrefs("4")								,
				'id_added'						=> cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ,
				'date_added'					=> date("Y-m-d H:i:s")
			);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);

	
		}
if($sqllmsInsertHistory) {
	//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
}
//--------------------------------------


}

//Update Opening Stock detail
if(isset($_POST['submit_openingchanges'])) { 			
					
			$dataStck = array(
								'unitprice'			=> cleanvars($_POST['unitprice_edit'])					,
								'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 	,
								'date_modify'		=> date("Y-m-d H:i:s")
							);

		$qryUpdate = $dblms->Update(STOCK, $dataStck, "WHERE id = '".$_POST['stock_id']."'");

if($qryUpdate) {
	//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
}
//--------------------------------------


}
