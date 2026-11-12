<?php
// IP ADDRESS
function get_ip_address($url) {
	// Parse the URL to get the hostname
	$parsed_url = parse_url($url);
	if (isset($parsed_url['host'])) {
		$hostname = $parsed_url['host'];
	} else {
		// In case the URL does not have a scheme, assume it's a hostname
		$hostname = $url;
	}
	
	// Get the IP address associated with the hostname
	$ip_address = gethostbyname($hostname);
	return $ip_address;
}

// STATUS
$complete_incomplete = array (
								array('status_id'=>1, 'status_name'=>'Completed')		
								, array('status_id'=>2, 'status_name'=>'Partially Complete')
								, array('status_id'=>3, 'status_name'=>'In-Progress')
								, array('status_id'=>4, 'status_name'=>'Pending')
								, array('status_id'=>5, 'status_name'=>'Canceled')
								, array('status_id'=>6, 'status_name'=>'Save & Hold')
							);


function get_complete($id) {
	$listcomplete= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Complete</span>', 
							'2' => '<span class="label label-info" id="bns-status-badge">Partially Complete</span>',
							'3' => '<span class="label label-info" id="bns-status-badge">In-Progress</span>',
							'4' => '<span class="label label-warning" id="bns-status-badge">Pending</span>',
							'5' => '<span class="label label-danger" id="bns-status-badge">Canceled</span>',
							'6' => '<span class="label label-warning" id="bns-status-badge">Save & Hold</span>',
						);
	return $listcomplete[$id];
}

// STATUS 
$admstatus = array (
						  array('status_id'=>1, 'status_name'=>'Active')		
						, array('status_id'=>2, 'status_name'=>'Inactive')
				   );
$ad_status = array (
						  array('status_id'=>1, 'status_name'=>'Active')		
						, array('status_id'=>2, 'status_name'=>'Inactive')
				   );

function get_admstatus($id) {
	$listadmstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
							'2' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>');
	return $listadmstatus[$id];
}

function get_admstatus1($id) {
	$listadmstatus= array (
							'1' => 'Active', 
							'2' => 'Inactive'
						 );
	return $listadmstatus[$id];
}
// PAYMENT STATUS
$payments = array (
						array('id'=>1, 'name'=>'Paid')		, 
						array('id'=>2, 'name'=>'Pending')	, 
						array('id'=>3, 'name'=>'Unpaid')
				   );

function get_payments($id) {
	$listpayments = array (
							'1' => '<span class="label label-info" id="bns-status-badge">Paid</span>'		, 
							'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'3' => '<span class="label label-danger" id="bns-status-badge">Unpaid</span>'
						  );
	return $listpayments[$id];
}


// ADMIN RIGHTS
$admtypes = array (
					array('id'=>1, 'name'=>'Administrator'),
					array('id'=>2, 'name'=>'Director'),
					array('id'=>3, 'name'=>'Accountant'),
					array('id'=>4, 'name'=>'Simple')
				   );

function get_admtypes($id) {
	$listadmrights = array (
							'1'	=> 'Administrator',
							'2'	=> 'Director',
							'3'	=> 'Accountant',
							'4'	=> 'Simple'
							);
	return $listadmrights[$id];
}

//--------------- Class Names ----------
$classnames = array (
						  array('id'=>1,  'name' => 'Playgroup')
						, array('id'=>2,  'name' => 'Nursery')
						, array('id'=>3,  'name' => 'Prep')
						, array('id'=>4,  'name' => 'One (Grade I)')
						, array('id'=>5,  'name' => 'Two (Grade II)')
						, array('id'=>6,  'name' => 'Three (Grade III)')
						, array('id'=>7,  'name' => 'Four (Grade IV)')
						, array('id'=>8,  'name' => 'Five (Grade V)')
						, array('id'=>9,  'name' => 'Six (Grade VI)')
						, array('id'=>10, 'name' => 'Seven (Grade VII)')
						, array('id'=>11, 'name' => 'Eight (Grade VIII)')
						, array('id'=>12, 'name' => 'Nine (Grade IX)')
						, array('id'=>13, 'name' => 'Ten (Grade X)')
				   );

function get_classnames($id) {
	$listitem = array (
							  '1'	=> 'Playgroup'
							, '2'	=> 'Nursery'
							, '3'	=> 'Prep'
							, '4'	=> 'One (Grade I)'
							, '5'	=> 'Two (Grade II)'
							, '6'	=> 'Three (Grade III)'
							, '7'	=> 'Four (Grade IV)'
							, '8'	=> 'Five (Grade V)'
							, '9'	=> 'Six (Grade VI)'
							, '10'	=> 'Seven (Grade VII)'
							, '11'	=> 'Eight (Grade VIII)'
							, '12'	=> 'Nine (Grade IX)'
							, '13'	=> 'Ten (Grade X)'
					);
	return $listitem[$id];
}


// PROVINCES
$provinces = array (
						  array('id'=>1,  'name' => 'Azad Jammu and Kashmir')
						, array('id'=>2,  'name' => 'Balochistan')
						, array('id'=>3,  'name' => 'Gilgit-Baltistan')
						, array('id'=>4,  'name' => 'Islamabad Capital Territory')
						, array('id'=>5,  'name' => 'Khyber Pakhtunkhwa')
						, array('id'=>6,  'name' => 'Punjab')
						, array('id'=>7,  'name' => 'Sindh')
				   );

function get_provinces($id) {
	$list = array (
						  '1'	=> 'Azad Jammu and Kashmir'
						, '2'	=> 'Balochistan'
						, '3'	=> 'Gilgit-Baltistan'
						, '4'	=> 'Islamabad Capital Territory'
						, '5'	=> 'Khyber Pakhtunkhwa'
						, '6'	=> 'Punjab'
						, '7'	=> 'Sindh'
					);
	return $list[$id];
}

// ITEM TYPES
$itemtype = array (
						  array('id'=>1, 'name'=>'Book')
						, array('id'=>2, 'name'=>'Work Book')
						, array('id'=>3, 'name'=>'Note Book')
						, array('id'=>4, 'name'=>'Uniforms')
				   );

function get_itemtypes($id) {
	$listitem =  array (
							 '1'	=> 'Book'		
							,'2'	=> 'Work Book'	
							,'3'	=> 'Note Book'	
							,'4'	=> 'Uniforms'
						);
	return $listitem[$id];
}


// STOCK TAKING TYPES
$stocktaking = array (
						  array('id'=>1, 'name'=>'All Items')
						, array('id'=>2, 'name'=>'Partial Items')
					);

function get_stocktakings($id) {
	$list 	= array (
						 '1'	=> 'All Items'
						, '2'	=> 'Partial Items'
					);
	return $list[$id];
}



// INVOICE LOGO
$invoicelogo = array (
						  array('id'=>1, 'name'=>'MES')
						, array('id'=>2, 'name'=>'Laurel Publishers')
					);

function get_invoicelogo($id) {
	$list 	= array (
						 '1'	=> 'MES'
						, '2'	=> 'Laurel Publishers'
					);
	return $list[$id];
}


// ORDER SATTUS
$orders = array (
					  array('id'=>1, 'name'=>'Save & Hold')
					, array('id'=>2, 'name'=>'Pending')	
					, array('id'=>3, 'name'=>'In-Progress')
					, array('id'=>4, 'name'=>'Dispatched')
					, array('id'=>5, 'name'=>'Cancel')
				);

function get_orders($id) {
	$listorders = array (
							  '1'	=> '<span class="label bg-warning-dark" id="bns-status-badge"> Save & Hold</span>'
							, '2'	=> '<span class="label bg-orange" id="bns-status-badge">Pending</span>'			
							, '3'	=> '<span class="label bg-info-dark" id="bns-status-badge">In-Progress</span>'	
							, '4'	=> '<span class="label bg-success-dark" id="bns-status-badge">Dispatched</span>'
							, '5'	=> '<span class="label bg-danger" id="bns-status-badge">Cancel</span>'
						);
	return $listorders[$id];
}



// SALE TYPES
$saletypes = array (
						array('id'=>1, 'name'=>'Pending')	
						, array('id'=>2, 'name'=>'Save & Hold')
						, array('id'=>3, 'name'=>'Confirmed')	
						, array('id'=>4, 'name'=>'Dispatched')
						, array('id'=>5, 'name'=>'Completed')	
						, array('id'=>6, 'name'=>'Cancel')
				   );

function get_saletypes($id) {
	$list = array (
						  '1'	=> '<span class="label label-warning" id="bns-status-badge">Pending</span>'	
						, '2'	=> '<span class="label label-danger" id="bns-status-badge">Save & Hold</span>'
						, '3'	=> '<span class="label label-success" id="bns-status-badge">Confirmed</span>' 
						, '4'	=> '<span class="label label-info" id="bns-status-badge">Dispatched</span>'	
						, '5'	=> '<span class="label bg-primary-dark" id="bns-status-badge">Completed</span>'
						, '6'	=> '<span class="label label-danger" id="bns-status-badge">Cancel</span>'
					);
	return $list[$id];
}


// ORDER ITEM STATUS
$ordersitem = array (
						  array('id'=>1, 'name'=>'Dispatched')	
						, array('id'=>2, 'name'=>'Pending')		
						, array('id'=>3, 'name'=>'Cancel')
				   );

function get_ordersitem($id) {
	$listordersitem = array (
								  '1'	=> 'Dispatched'	
								, '2'	=> 'Pending'	
								, '3'	=> 'Cancel'		
							);
	return $listordersitem[$id];
}


// ESTIMATE STATUS
$estimatestatus = array (
							  array('id'=>1, 'name'=>'Save & Hold')
							, array('id'=>2, 'name'=>'Pending')
							, array('id'=>3, 'name'=>'Cancel')
							, array('id'=>4, 'name'=>'Requested')
							, array('id'=>5, 'name'=>'Approved')
							, array('id'=>6, 'name'=>'Challan Generated')
							, array('id'=>7, 'name'=>'Paid')
						);

function get_estimatestatus($id) {
	$list = array (
						  '1'	=> '<span class="label label-warning" id="bns-status-badge">Save & Hold</span>'
						, '2'	=> '<span class="label label-warning" id="bns-status-badge">Pending</span>'
						, '3'	=> '<span class="label label-danger" id="bns-status-badge">Cancel</span>'
						, '4'	=> '<span class="label label-primary" id="bns-status-badge">Requested</span>'
						, '5'	=> '<span class="label label-success" id="bns-status-badge">Approved</span>'
						, '6'	=> '<span class="label label-purple" id="bns-status-badge">Challan Generated</span>'
						, '7'	=> '<span class="label label-info" id="bns-status-badge">Paid</span>'
					);
	return $list[$id];
}

// STATUS YES NO
$statusyesno = array (
						 array('id'=>1, 'name'=>'Yes')
					   , array('id'=>0, 'name'=>'No')
				    );

function get_statusyesno($id) {
	
	$liststatusyesno = array (
								'1'	=> 'Yes',	'0'	=> 'No'
							 );
	return $liststatusyesno[$id];
}

// DESIGN BY
$designby = array (
						 array('id'=>1, 'name'=>'Client')
						,array('id'=>2, 'name'=>'Fresh')
				   );

function get_designby($id) {
	
	$listdesignby = array (
								  '1'	=> 'Client'		
								, '2'	=> 'Fresh'
							 );
	return $listdesignby[$id];
}


// ZONES
$zonenames = array (
						  array('id'=>1, 'name'=>'AJK')				 
						, array('id'=>2, 'name'=>'Balochistan')		
						, array('id'=>3, 'name'=>'Chakwal')			
						, array('id'=>4, 'name'=>'Faisalabad')		
						, array('id'=>5, 'name'=>'Gujrat')			
						, array('id'=>6, 'name'=>'Gujranwala')		
						, array('id'=>7, 'name'=>'Karachi & Sindh')	
						, array('id'=>8, 'name'=>'KPK')				
						, array('id'=>9, 'name'=>'Lahore')			
						, array('id'=>10, 'name'=>'Multan')			
						, array('id'=>11, 'name'=>'Rawalpindi') 		
						, array('id'=>12, 'name'=>'Vehari') 
				   );

function get_zonenames($id) {
	$list = array (
					  '1'		=> 'AJK'				 
					, '2' 	=> 'Balochistan'		 
					, '3' 	=> 'Chakwal'			 
					, '4' 	=> 'Faisalabad'			 
					, '5' 	=> 'Gujrat'				 
					, '6' 	=> 'Gujranwala'			 
					, '7' 	=> 'Karachi & Sindh'	 
					, '8' 	=> 'KPK'				 
					, '9' 	=> 'Lahore'				 
					, '10' 	=> 'Multan'				
					, '11' 	=> 'Rawalpindi'			
					, '12' 	=> 'Vehari'				
				);
	return $list[$id];
}

// BRANDS
$brandnames = array (
						  array('id' => 1,  'code' => 'EDUC',  'name' => 'Educare & Ontep')
						, array('id' => 2,  'code' => 'LHSP', 'name' => 'Laurel Home Schools')
						// , array('id' => 3,  'code' => 'LHIC', 'name' => 'Laurel Home International Colleges (LHIC)')
						// , array('id' => 4,  'code' => 'MAS',  'name' => 'Minhaj Affiliated Schools (MAS)')
						// , array('id' => 5,  'code' => 'MCMT', 'name' => 'Minhaj College of Management & Technology')
						// , array('id' => 6,  'code' => 'MGSP',  'name' => 'Minhaj Grammar Schools')
						, array('id' => 7,  'code' => 'MGS',  'name' => 'Minhaj Grammar Schools')
						// , array('id' => 8,  'code' => 'MPSP',  'name' => 'Minhaj Public Schools')
						// , array('id' => 9,  'code' => 'ONTP',  'name' => 'Ontep')
						// , array('id' => 10, 'code' => 'PUSS', 'name' => 'Pak Urdu School System (PUSS)')
						// , array('id' => 11, 'code' => 'TVI',  'name' => 'Techzoid Vocational Institutes (TVI)') 
				   );

function get_brandnames($id) {
	$list = array (
					  '1' => 'Educare & Ontep (EDUC)'
					, '2' => 'Laurel Home Schools (LHSP)'
					// , '3' => 'Laurel Home International Colleges (LHIC)'
					// , '4' => 'Minhaj Affiliated Schools (MAS)'
					// , '5' => 'Minhaj College of Management & Technology (MCMT)'
					// , '6' => 'Minhaj Grammar Schools (MGSP)'
					, '7' => 'Minhaj Grammar Schools (MGS)'
					// , '8' => 'Minhaj Public Schools (MPSP)'
					// , '9' => 'Ontep (ONTP)'
					// , '10'=> 'Pak Urdu School System (PUSS)'
					// , '11'=> 'Techzoid Vocational Institutes (TVI)'
				);
	return $list[$id];
}

// PUBLISHERS
function get_publishers($id = '') {
	$listPublisher = array (
								  '1' => 'Laural Publisher'
								, '2' => 'Gohar Publisher'
								, '3' => 'Jhangir Publisher'
								, '4' => 'Albakio Publisher'
								, '5' => 'MQ Publisher'
								, '6' => 'MQ sale center'
							);
	if(!empty($id)){
		return $listPublisher[$id];
	}else{
		return $listPublisher;
	}						
}

// BRAND CODES

function get_brandcode($id) {
	$list = array (
						  '1'	=> 'EDC'
						, '2' 	=> 'LHIS'
						, '3' 	=> 'LHIC'
						, '4' 	=> 'MAS'
						, '5' 	=> 'MCMT'
						, '6' 	=> 'MGS'
						, '7' 	=> 'MMS'
						, '8' 	=> 'MPS'
						, '9' 	=> 'ONT'
						, '10' 	=> 'PUSS'
						, '11' 	=> 'TVI'
				);
	return $list[$id];
}


// PAYMENT TYPES
$pay_types = array (
						  array('id'=>1, 'name'=>'Bank')
						, array('id'=>2, 'name'=>'Cash')
						, array('id'=>3, 'name'=>'A/C Office')
						, array('id'=>4, 'name'=>'Payfast')
						, array('id'=>5, 'name'=>'Others')
						, array('id'=>6, 'name'=>'RAAST QR Payment')
				   );

function get_paytypes($id) {
		$listpaytypes = array (
								  '1' => 'Bank'
								, '2' => 'Cash'
								, '3' => 'A/C Office'
								, '4' => 'Payfast'	
								, '5' => 'Others'	
								, '6' => 'RAAST QR Payment'	
							);
	return $listpaytypes[$id];
}



// COLLECTION BANK ACCOUNTS
$bankAccounts = array (
						  array('id'=>1, 'bank'=>'HBL' 										, 'acc_number'=>'019779001922-03')		 
						, array('id'=>2, 'bank'=>'HBL' 										, 'acc_number'=>'019700103513-03')		
						, array('id'=>3, 'bank'=>'MBL' 										, 'acc_number'=>'02930105776366')		
						, array('id'=>6, 'bank'=>'MBL(MES)'									, 'acc_number'=>'02930105986000')		
						, array('id'=>4, 'bank'=>'FINJA' 									, 'acc_number'=>'98000002144')			
						, array('id'=>5, 'bank'=>'FINJA'									, 'acc_number'=>'98000003179')			
						, array('id'=>7, 'bank'=>'Meezan Bank(Minhaj Education Society)'	, 'acc_number'=>'0293-0105986000')			
						, array('id'=>8, 'bank'=>'UBL(Laurel Publisher)'					, 'acc_number'=>' 2136_336568823')			
							
					  );

function get_bankAccounts($id) {
    $listpaytypes = array (
                                  '1' => 'HBL (019779001922-03)'
                                , '2' => 'HBL (019700103513-03)'
                                , '3' => 'MBL (02930105776366)'
                                , '4' => 'FINJA (98000002144)'
                                , '5' => 'FINJA (98000003179)'
                                , '6' => 'MBL(MES) (02930105986000)'
                                , '7' => 'Meezan Bank (0293-0105986000)'
                                , '8' => 'UBL (2136_336568823)'
                        );
    return $listpaytypes[$id];
}


// PAYMENT TYPES
$ptypes = array (
					  array('id'=>1, 'name'=>'Receive')
					, array('id'=>2, 'name'=>'Return') 
					, array('id'=>3, 'name'=>'Adjustment')
				);

function get_pptypes($id) {
	$listpptypes = array ('1' => 'Receive', '2' => 'Return', '3' => 'Adjustment');
	return $listpptypes[$id];
}
// INCOME / EXPENSES
$incomeexpense = array (
							array('id'=>1, 'name'=>'Income')
							,array('id'=>2, 'name'=>'Expense')
						);

function get_incomeexpense($id) {
	$listincomeexpense = array ('1' => 'Income', '2' => 'Expense');
	return $listincomeexpense[$id];
}

// DISPATCH VIA
$dispatchvia = array (
						  array('id'=>1, 'name'=>'By Hand') 
						, array('id'=>2, 'name'=>'Parcel')	
						, array('id'=>3, 'name'=>'Bility')	
						, array('id'=>4, 'name'=>'N/A')	
				   );

function get_dispatchvia($id) {
	$list = array (
					  '1' => 'By Hand'
					, '2' => 'Parcel'
					, '3' => 'Bility'
					, '4' => 'N/A'
				 );
	return $list[$id];
}

// CUSTOMER TYPES
$customertype = array (
						  array('id'=>1, 'name'=>'School')
						, array('id'=>2, 'name'=>'Dealer')
						, array('id'=>3, 'name'=>'Employee')
						, array('id'=>4, 'name'=>'Retail')
				   );

function get_customertype($id) {
	$list = array (
					  '1' => 'School'
					, '2' => 'Dealer'
					, '3' => 'Employee'
					, '4' => 'Retail'
				 );
	return $list[$id];
}

// LEDGER FOR
$ledgerfor = array (
						  array('id'=>1, 'name'=>'Customers')	
						, array('id'=>2, 'name'=>'Vendors')						
				   );

function get_ledgerfor($id) {
	$listledgerfor = array ('1' => 'Customers', '2' => 'Vendors');
	return $listledgerfor[$id];
}

// DOC TYPES
$doctype = array (
						  array('id'=>1, 'name'=>'Payments')
						, array('id'=>2, 'name'=>'Sales Invoice')
						, array('id'=>3, 'name'=>'Sales Return')
						, array('id'=>4, 'name'=>'Job Orders')
						, array('id'=>5, 'name'=>'Purchase')
						, array('id'=>6, 'name'=>'Opening Balance')
						, array('id'=>7, 'name'=>'Advance Payment')
						, array('id'=>8, 'name'=>'Purchases Return')
						, array('id'=>9, 'name'=>'Goods Received')
						, array('id'=>10, 'name'=>'Donations')
						, array('id'=>11, 'name'=>'Gifts')
						, array('id'=>12, 'name'=>'Credit Note')		
						, array('id'=>13, 'name'=>'Journal Vouchers')		
				   );

function get_doctype($id) {
	$listdoctype = array (
							  '1' => 'Payments'
							, '2' => 'Sales Invoice'
							, '3' => 'Sales Return'
							, '4' => 'Job Orders'
							, '5' => 'Purchase'
							, '6' => 'Opening Balance'
							, '7' => 'Advance Payment'
							, '8' => 'Purchases Return'
							, '9' => 'Goods Received'
							, '10' => 'Donations'
							, '11' => 'Gifts'
							, '12' => 'Credit Note'
							, '13' => 'Journal Vouchers'
						);
	return $listdoctype[$id];
}


function getdoctype($id) {
	$listdoctype = array (
							  'Payments'  		=> '1'
							, 'Sales Invoice' 	=> '2'
							, 'Sales Return'  	=> '3'
							, 'Job Orders'  	=> '4'
							, 'Purchase' 		=> '5'
							, 'Opening Balance' => '6'
							, 'Advance Payment' => '7'	
							, 'Purchases Return'=> '8'	
							, 'Goods Received' 	=> '9'	
							, 'Donations' 		=> '10'
							, 'Gifts' 			=> '11'
							, 'Credit Note' 	=> '12'	
							, 'Journal Vouchers' => '13'	
						);
	return $listdoctype[$id];
}


// STOCK TYPES
$stocktypes = array (
						array('id'=>1, 'name'=>'In'), 
						array('id'=>2, 'name'=>'Out')
				   );

function get_stocktypes($id) {
	$list = array ('1' => 'In', '2' => 'Out');
	return $list[$id];
}


// STOCK REFERENCE
$stockrefs = array (
						array('id'=>1, 'name'=>'Purchase')	, 
						array('id'=>2, 'name'=>'Sales')		,
						array('id'=>3, 'name'=>'Sales Return'), 
						array('id'=>4, 'name'=>'Opening Stock'), 
						array('id'=>5, 'name'=>'Stock Taking')
				   );

function get_stockrefs($id) {
	$list = array ('1' => 'Purchase', '2' => 'Sales', '3' => 'Sales Return', '4' => 'Opening Stock', '5' => 'Stock Taking');
	return $list[$id];
}


// CREDIT DEBIT
$creditdebit = array (
						array('id'=>1, 'name'=>'Credit'), 
						array('id'=>2, 'name'=>'Debit')
				   );

function get_creditdebit($id) {
	$listcreditdebit = array ('1' => 'Credit', '2' => 'Debit');
	return $listcreditdebit[$id];
}

// CHEQUE STATUS
$cheques = array (
						array('id'=>1, 'name'=>'Cleared')		, 
						array('id'=>2, 'name'=>'Bounced')		,
						array('id'=>3, 'name'=>'Pending')	
				   );

function get_cheques($id) {
	$listcheques = array (
							'1' => 'Cleared'		, 
							'2' => 'Bounced'		, 
							'3' => 'Pending'
						);
	return $listcheques[$id];
}

//Income For
$incomeFor = array (
	array('id'=>1, 'name'=>'MSD')						, 
	array('id'=>2, 'name'=>'MSD:BOOKS AND COPIES')		,
	array('id'=>3, 'name'=>'MSD:BOOKS AND UNIFORMS LHS'),
	array('id'=>4, 'name'=>'MSD:PAK URDU INCOME MSD')	,
	array('id'=>5, 'name'=>'MSD:SCHOOL DEPT')			,
	array('id'=>6, 'name'=>'MSD:TRAINING')				,
	array('id'=>7, 'name'=>'MSD:UNIFORMS')	
);

function get_incomeFor($id) {

	$list = array (
							  '1'  => 'MSD'
							, '2'  => 'MSD:BOOKS AND COPIES'
							, '3'  => 'MSD:BOOKS AND UNIFORMS LHS'
							, '4'  => 'MSD:PAK URDU INCOME MSD'
							, '5'  => 'MSD:SCHOOL DEPT'
							, '6'  => 'MSD:TRAINING'
							, '7'  => 'MSD:UNIFORMS'
							
						  );
	return $list[$id];

}


//CGS
$cgsArray = array (
					array('id'=>1, 'name'=>'Curriculum Department')		, 
					array('id'=>2, 'name'=>'PAK URDU')					,
					array('id'=>3, 'name'=>'School Department')			,
					array('id'=>4, 'name'=>'Training Department')		,
					array('id'=>5, 'name'=>'Minhaj Services Department'),
					array('id'=>6, 'name'=>'Laurel Home Schools')	
);

function get_cgs($id) {

	$list = array (
							  '1'  => 'Curriculum Department'
							, '2'  => 'PAK URDU'
							, '3'  => 'School Department'
							, '4'  => 'Training Department'
							, '5'  => 'Minhaj Services Department'
							, '6'  => 'Laurel Home Schools'			
							
						  );
	return $list[$id];

}

// GENDER
$gender = array('Female', 'Male');

// MARTIAL STATUS
$marital = array('Married', 'Single');

// SECTIONS
$sections = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');

//BLOOD GROUPS
$bloodgroup = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-');

/*function cleanvars($str) {
		$str = trim($str);
		$str = mysql_escape_string($str);

	return($str);
}*/

function cleanvars($str){ 
	$str = trim($str);
	return is_array($str) ? array_map('cleanvars', $str) : str_replace("\\", "\\\\", htmlspecialchars((stripslashes($str)), ENT_QUOTES)); 
}


function to_seo_url($str){
   // if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
      //  $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = trim($str, '-');
    return $str;
}

// LOG ACTIONS
function get_logfile($id) {

	$listlogfile = array (
							'1' => 'Add'		, 
							'2' => 'Update'		, 
							'3' => 'Delete'		,
							'4' => 'Login'	
						  );
	return $listlogfile[$id];

}


// ROLE TYPES
$roletypes = array (
						array('id'=>1,  'name'=>'Sales')			, 
						array('id'=>2,  'name'=>'Purchase')			,
						array('id'=>3,  'name'=>'Vendors')			,
						array('id'=>4,  'name'=>'Payments')			,
						array('id'=>5,  'name'=>'Customers')		,
						array('id'=>10, 'name'=>'Donations & Gifts'),
						array('id'=>6,  'name'=>'Items')			,
						array('id'=>7,  'name'=>'Ledgers')			,
						array('id'=>9,  'name'=>'Reporting')		,
						array('id'=>11, 'name'=>'Stocks Taking')	,
						array('id'=>8,  'name'=>'Setting')			
						
				   );

function get_roletypes($id) {

	$listroletypes = array (
							'1'  => 'Sales'			,
							'2'  => 'Purchase'		,
							'3'  => 'Vendors'		,
							'4'  => 'Payments'		,
							'5'  => 'Customers'		,
							'6'  => 'Items'			,
							'7'  => 'Ledgers'		,
							'8'  => 'Setting'		,
							'9'  => 'Reporting'		,
							'10' => 'Donations & Gifts'	,	
							'11' => 'Stocks Taking'		
							
						  );
	return $listroletypes[$id];

}

// ARRAY SEARCH
function arrayKeyValueSearch($array, $key, $value)
{
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subArray) {
            $results = array_merge($results, arrayKeyValueSearch($subArray, $key, $value));
        }
    }
    return $results;
}



function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 4).' T';
        elseif ($n > 1000000000) return round(($n/1000000000), 4).' B';
        elseif ($n > 1000000) return round(($n/1000000), 4).' M';
        elseif ($n > 1000) return round(($n/1000), 4).' K';

        return number_format($n);
    }

//RUPEES IN WORDS
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

//TIME FORMAT
function get_hours_range( $start = 0, $end = 86400, $step = 1800, $format = 'g:i a' ) {
        $times = array();
        foreach ( range( $start, $end, $step ) as $timestamp ) {
                $hour_mins = gmdate( 'H:i', $timestamp );
                if ( ! empty( $format ) )
                        $times[$hour_mins] = gmdate( $format, $timestamp );
                else $times[$hour_mins] = $hour_mins;
        }
        return $times;
}

//LEAVE TYPES
$leavetype = array (
						 array('id'=>1, 'name'=>'Paid')
						,array('id'=>2, 'name'=>'Unpaid')	
					);

function get_leavetype($id) {
	$listleavetype = array (
							'1' => 'Paid'		, 
							'2' => 'Unpaid'	
	 );
	return $listleavetype[$id];
}

// LEAVE DONATION
$leaveduration = array (
						  array('id'=>1, 'name'=>'Full Day')
						, array('id'=>2, 'name'=>'Half Day')
						, array('id'=>3, 'name'=>'Hourly')	
					);

function get_leaveduratione($id) {
	$listleaveduration = array (
									  '1' => 'Full Day'	
									, '2' => 'Half Day'	
									, '2' => 'Hourly'	
								);
	return $listleaveduration[$id];
}


function searchArrayKeyVal($sKey, $id, $array) {
	foreach ($array as $key => $val) {
		if ($val[$sKey] == $id) {
			return $key;
		}
	}
	return null;
}
// LOGIN TYPES
$logintypes = array (
						  array('id'=>1, 'name'=>'Staffs')
						, array('id'=>2, 'name'=>'Customers')
						, array('id'=>3, 'name'=>'Vendors')		
				   );

function get_logintypes($id) {
	$listlogintypes = array (
								  '1'	=> 'Staffs'			
								, '2'	=> 'Customers'		
								, '3'	=> 'Vendors'			
							);
	return $listlogintypes[$id];
}



// Payfast functions

function getAccessToken($merchant_id, $secured_key, $basket_id, $trans_amount, $tokenApiUrl)  {
	//$tokenApiUrl = 'https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken';

	$urlPostParams = sprintf(
            //'MERCHANT_ID=%s&SECURED_KEY=%s',
			 'MERCHANT_ID=%s&SECURED_KEY=%s&TXNAMT=%s&BASKET_ID=%s',
            $merchant_id,
            $secured_key,
          $trans_amount,
          $basket_id
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlPostParams);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CURL/PHP PayFast Example');
        $response = curl_exec($ch);
        curl_close($ch);
        $payload = json_decode($response);
        $token = isset($payload->ACCESS_TOKEN) ? $payload->ACCESS_TOKEN : '';
        return $token;
    }

	function get_dataHashingOnlyExp($str = '', $flag = true) {
		if (!empty($str)) {
			$e_key     = "m^@c$&d#~l";
			$e_chiper  = "AES-128-CTR";
			$e_iv      = "4327890237234803";
			$e_option  = 0;
	
			if ($flag) {
				// Encrypt and then encode to base64
				$encrypted = openssl_encrypt($str, $e_chiper, $e_key, $e_option, $e_iv);
				return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encrypted));
			} else {
				// Decode from base64 and then decrypt
				$decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $str));
				return openssl_decrypt($decoded, $e_chiper, $e_key, $e_option, $e_iv);
			}
		} else {
			return false;
		}
	}
	
	function convertPhoneNumber($number) {
	    // Remove any non-numeric characters (e.g., hyphens)
	    $number = preg_replace('/\D/', '', $number);
	
	    // Remove the leading zero
	    $number = ltrim($number, '0');
	
	    // Prefix with country code 92
	    return '92' . $number;
	}

	function get_wa_messagestatus($id) {
		$wa_messagestatus = array (
									  '1'	=> '<span class="label label-success" id="bns-status-badge">Sent</span>'
									, '3'	=> '<span class="label label-danger" id="bns-status-badge">Rejected</span>'
								);
		return $wa_messagestatus[$id];
	}