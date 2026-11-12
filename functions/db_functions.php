<?php
class main { 
	
	
	// get max systemslip value
	function get_systemslipno($id, $dc) { 
		if($id == 1) {
			$prefix = 'CP';
		} else if($id == 2) {
			$prefix = 'VP';
		}
		
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'MAX(systemslip_no) as slipno'
								 , 'where' 		=> array( 
															  'ledgerfor' 		=> $id 
															, 'debit_credit' 	=> $dc 
														)
								, 'search_by' 	=> " AND systemslip_no != '' AND date_added LIKE '".date("Y")."-%'"
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$result = $dblms->getRows(PAYMENTS, $conditions);
		if(!$result['slipno']) {
			$systemslip = $prefix.'-'.date('y').'00001';
		} else {
			$slipno 	= substr($result['slipno'], 3);
			$systemslip = substr($result['slipno'], 0, 3).($slipno + 1);
		}
		return $systemslip;
	}

	// get Item last 3 Price
	function get_itemreturnprices($id, $iduser) { 
		$dblms = new dblms();
		$Odconditions = array ( 
								'select' 		=> 'DISTINCT('.JOB_ORDER_DETAILS.'.unit_price) as Itemprice',
								'join' 			=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id = ".JOB_ORDER_DETAILS.".id_job_order 
													INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".JOB_ORDER_DETAILS.".id_item",
								'where' 		=> array( 
															   ''.ITEMS.'.item_id' 			=> cleanvars($id)
															 , ''.JOB_ORDER.'.id_customer' 	=> cleanvars($iduser)
														), 
								'order_by' 		=> ''.JOB_ORDER_DETAILS.'.unit_price DESC',
								'limit' 		=> 3,
								'return_type' 	=> 'all' 
							); 
    	$result = $dblms->getRows(JOB_ORDER_DETAILS, $Odconditions);
	
		return $result;
	}
	
	// get Item Price
	function get_itemprice($id) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'item_pricesale, item_pricedealership, item_pricepurchase, item_priceretail'
								, 'where' 		=> array ( 
															  'item_id' => cleanvars($id)
														 )
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$result = $dblms->getRows(ITEMS, $conditions);
		return $result;
	}
	
	// get Item avaiable Stock
	function get_itemstock($id) { 
		$dblms = new dblms();
		$conditions 	= array ( 
								'select' 		=> "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
													SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY",
								'where' 		=> array ( 
															''.STOCK.'.id_item' 	=> cleanvars($id) 
														 ),
								'return_type' 	=> 'single' 
							); 
    	$result 	= $dblms->getRows(STOCK, $conditions);
		
		return $result;
	}
	
	// get all Item
	function get_items($status = 1, $catid = 0) { 
		$dblms = new dblms();
		$sqlserch = '';
		if(!empty($catid)) {
			$sqlserch .= " AND id_cat = '".$catid."'";
		}
		$conditions = array ( 
								  'select' 		=> 'item_id, item_name, item_code'
								, 'where' 		=> array ( 
															  'item_status' => cleanvars($status)
														 )
								, 'search_by' 	=> $sqlserch 
								, 'order_by' 	=> 'item_code ASC, item_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(ITEMS, $conditions);
		return $result;
	}
	
	// get all Item Categories
	function get_itemcategories($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'cat_id, cat_name'
								, 'where' 		=> array ( 
															  'cat_status' => cleanvars($status)
														 )
								, 'order_by' 	=> 'cat_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(ITEMS_CAT, $conditions);
		return $result;
	}

	// get all CRS
	function get_allcrs($status = 1) {
		$dblms = new dblms();
		$conditions = array (
								  'select' 		=> 'crs_id, crs_name, crs_mobile, crs_email'
								, 'where' 		=> array (
															    'crs_status'    => cleanvars($status)
															  , 'is_deleted'     => 0
														 )
								, 'order_by' 	=> 'crs_name ASC'
								, 'return_type' => 'all'
							);
		$result = $dblms->getRows(CRS, $conditions);
		return $result;
	}

	// get Customer Type
	function get_customertype($id) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'id_type'
								, 'where' 		=> array ( 
															  'customer_id' => cleanvars($id)
														 )
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$result = $dblms->getRows(CUSTOMERS, $conditions);
		return $result;
	}

	// get all Customers
	function get_customers($status = 1, $idzone =0, $idcompany=0) { 
		$dblms = new dblms();
		$sqlserch = '';
		if(!empty($idzone)) {
			$sqlserch .= " AND id_zone = '".$idzone."'";
		}
		if(!empty($idcompany)) {
			$sqlserch .= " AND id_company = '".$idcompany."'";
		}
		$conditions = array ( 
								  'select' 		=> ''.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_code, 
								  					'.CUSTOMERS.'.id_brand, '.COMPANY.'.company_name'
								, 'join' 		=> "LEFT JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company"
								, 'where' 		=> array ( 
															  ''.CUSTOMERS.'.customer_status' => cleanvars($status)
														 )
								, 'search_by' 	=> $sqlserch 
								, 'order_by' 	=> ''.CUSTOMERS.'.customer_code ASC, '.CUSTOMERS.'.customer_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(CUSTOMERS, $conditions);
		return $result;
	}

	// get all Vendors
	function get_vendors($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'vendor_id, vendor_name, vendor_cellno'
								, 'where' 		=> array ( 
															  'vendor_status' => cleanvars($status)
														 )
								, 'order_by' 	=> 'vendor_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(VENDORS, $conditions);
		return $result;
	}
	
	// get all Cities
	function get_cities($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'city_id, city_name, city_code'
								, 'where' 		=> array ( 
															  'city_status'  => cleanvars($status) 
														 )
								, 'order_by' 	=> 'city_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(CITIES, $conditions);
		return $result;
	}

	// get all Companies
	function get_companies($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'company_id, company_name, company_code'
								, 'where' 		=> array ( 
															  'company_status'  => cleanvars($status) 
														 )
								, 'order_by' 	=> 'company_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(COMPANY, $conditions);
		return $result;
	}

	// get all Ades
	function get_ades($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'ade_id, ade_name, ade_cellno'
								, 'where' 		=> array ( 
															  ''
														 )
								, 'order_by' 	=> 'ade_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(ADES, $conditions);
		return $result;
	}

	// get all Payment Category
	function get_paymentcategory($status = 1) { 
		$dblms = new dblms();
		$conditions = array ( 
								  'select' 		=> 'cat_id, cat_name'
								, 'where' 		=> array ( 
															'cat_status'  => cleanvars($status) 
														 )
								, 'order_by' 	=> 'cat_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(PAYMENTS_CATEGORY, $conditions);
		return $result;
	}

	// get all PACKAGES
	function get_packages($status = 1, $brandid = 0) { 
		$dblms = new dblms();
		$sqlserch = '';
		if(!empty($brandid)) {
			$sqlserch .= " AND id_brand = '".$brandid."'";
		}
		$conditions = array ( 
								'select' 		=> 'package_id, package_name, package_no'
								, 'where' 		=> array ( 
															'package_status' => cleanvars($status)
														)
								, 'search_by' 	=> $sqlserch 
								, 'order_by' 	=> 'package_no ASC, package_name ASC'
								, 'return_type' => 'all' 
							); 
		$result = $dblms->getRows(PACKAGES, $conditions);
		return $result;
	}

	// get PACKAGE Price
	function get_packageprice($id) { 
		$dblms = new dblms();
		
		$conditions = array ( 
								  'select' 		=> 'SUM('.PACKAGES_DETAIL.'.qty * '.ITEMS.'.item_pricesale) as PackageTotal, GROUP_CONCAT('.ITEMS.'.item_id) as ItemIDs'
								, 'join' 		=> "INNER JOIN ".PACKAGES." ON ".PACKAGES.".package_id = ".PACKAGES_DETAIL.".id_package 
													INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PACKAGES_DETAIL.".id_item"
								, 'where' 		=> array( 
															 ''.PACKAGES.'.is_deleted' => 0 
															,''.PACKAGES.'.package_id' => cleanvars($id)
														)
								, 'group_by' 	=> ''.PACKAGES_DETAIL.'.id_package'
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
						); 
    	$result 	= $dblms->getRows(PACKAGES_DETAIL, $conditions);
		return $result;
	}

	// get PACKAGE Stock
	function get_packagestock($ids) { 
		 $dblms = new dblms();

		// convert comma-separated string into array
		$itemArray = array_map('trim', explode(',', $ids));

		$lowestStock = null;

		foreach($itemArray as $id) {

			$conditions = array ( 
									'select' => "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY",
									'where' => array(''.STOCK.'.id_item' => cleanvars($id)),
									'return_type' => 'single'
								);

			$result = $dblms->getRows(STOCK, $conditions);

			// calculate available stock for this item
			$available = ($result['TotalInQTY'] ?? 0) - ($result['TotalOutQTY'] ?? 0);

			// find the lowest stock
			if ($lowestStock === null || $available < $lowestStock) {
				$lowestStock = $available;
			}
		}

		return $lowestStock; // the lowest available stock among all items
	}

	// delete older Job Orders(7 days)
	function deleteolderjoborders($status = 1) { 

		$dblms = new dblms();

		$dataJoborder 	= array( 
									'is_deleted'	=>	1
								);
		$qryUpdate 		= $dblms->Update(JOB_ORDER, $dataJoborder, "WHERE date_added 			< DATE_SUB(NOW(), INTERVAL 1 WEEK) 
																		AND job_order_status 	= '".$status."' 
																		AND is_placebycustomer 	= '0' 
																		AND is_deleted = 0");
		return true;
	}

	// get single QR COde
    function get_qrchallan($consumerNumber, $consumerName, $amount, $currency, $expiryDateTime) {
        $dblms = new dblms();
        $conditions = array (
                                      'select' 		=> 'id, qrcode, orderid, expirydatetime, status'
                                    , 'where' 		=> array (
                                                                      'consumerno'      => cleanvars($consumerNumber)
                                                                    , 'amount'          => cleanvars($amount)
                                                                    , 'currency'        => cleanvars($currency)
                                                                    , 'expirydatetime'  => $expiryDateTime
                                                             )
                                    , 'search_by'   => " AND consumername LIKE '".($consumerName)."'"
                                    , 'limit' 	    => 1
                                    , 'return_type' => 'single'
                            );
        $result = $dblms->getRows("cms_qrchallans", $conditions);
        return $result;
    }

	
}