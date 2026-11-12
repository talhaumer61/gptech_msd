<?php

	// Report all errors
	error_reporting(0);
	ob_start();
	ob_clean();
	
	date_default_timezone_set("Asia/Karachi");
	//	session_save_path('../tmp');
	session_start();
	
	
	define('LMS_HOSTNAME'			, 'localhost');
	define('LMS_NAME'				, 'gptech_msd');
	define('LMS_USERNAME'			, 'root');
	define('LMS_USERPASS'			, '');
	
	
	// define('LMS_HOSTNAME'			, 'localhost');
	// define('LMS_NAME'				, 'jo370xfr_msdsoftware2022');
	// define('LMS_USERNAME'			, 'jo370xfr_gptmsd');
	// define('LMS_USERPASS'			, 'pIQmzR?pynkM');

	// DB Tables
	define('ADMINS'						, 'msd_admins');
	define('ADES'						, 'msd_ades');
	define('ADMIN_ROLES'				, 'msd_admins_roles');
	define('ACCOUNTS'					, 'msd_accounts');
	define('BANKS'						, 'msd_banks');
	define('COMPANY'					, 'msd_company');
	define('CRS'					    , 'msd_representatives');
	define('CUSTOMERS'					, 'msd_customers');
	define('CUSTOMERS_LEDGER'			, 'msd_customerledger');
	define('EXPENSES'					, 'msd_expenses');
	define('EXPENSE_CATS'				, 'msd_expense_category');
	define('INVOICES'					, 'msd_invoices');
	define('INVOICE_DETAILS'			, 'msd_invoice_details');
	define('ITEMS'						, 'msd_items');
	define('ITEMS_CAT'					, 'msd_items_cat');
	define('JOB_ORDER'					, 'msd_job_order');
	define('JOB_ORDER_DETAILS'			, 'msd_joborder_details');
	define('SALES_INVOICE'				, 'msd_sale_invoice');
	define('SALES_INVOICE_DETAILS'		, 'msd_saleinvoice_details');
	define('PURCHASE_ORDER'				, 'msd_purchase_order');
	define('PURCHASE_ORDER_DETAILS'		, 'msd_purchaseorder_details');
	define('PURCHASE_INVOICE'			, 'msd_purchase_invoice');
	define('PURCHASE_INVOICE_DETAILS'	, 'msd_purchaseinvoice_details');
	define('LOGS'						, 'msd_logfile');
	define('SALES_RETURNS'				, 'msd_salesreturn');
	define('SALES_RETURNS_DETAILS'		, 'msd_salesreturn_details');
	define('PURCHASE_RETURNS'			, 'msd_purchasereturns');
	define('PURCHASE_RETURNS_DETAILS'	, 'msd_purchasereturn_details');
	define('DONATIONGIFTS'				, 'msd_donationgifts');
	define('DONATIONGIFTS_DETAILS'		, 'msd_donationgifts_details');
	
	define('PAYMENTS'					, 'msd_payments');
	define('PAYMENTS_CATEGORY'			, 'msd_payments_category');
	define('PAYMENTS_SCHEDULE'			, 'msd_payments_schedule');
	define('PAYMENTS_SCHEDULE_DETAILS'	, 'msd_payments_scheduledetail');

	define('STOCK'						, 'msd_stock');
	define('STOCK_HISTORY'				, 'msd_stock_history');
	define('STOCKS_TAKING'				, 'msd_stockstaking');
	define('STOCKS_TAKINGDETAIL'		, 'msd_stockstakingdetail');

	define('ESTIMATES'					, 'msd_customerestimates');
	define('ESTIMATES_DETAIL'			, 'msd_customerestimatesdetail');
	define('ADVANCE_PAYSETTING'			, 'msd_advancepaymentsetting');
	define('CITIES'						, 'msd_cities');
	define('DISTRICTS'					, 'msd_districts');

	define('PACKAGES'					, 'msd_packages');
	define('PACKAGES_DETAIL'			, 'msd_packagesdetail');
	define('PAYFAST_LOGS'				, 'msd_payfastlogs');
	define('PAYFAST_TRANSACTIONS'		, 'msd_payfast_transactions');
	define('PAYFAST_ORDERS'				, 'msd_payfast_orders');

	
	define('JOURANALVOUCHERS'			, 'msd_journalvouchers');
	define('JOURANALVOUCHERS_DETAIL'	, 'msd_journalvouchersdetail');

	define('MEDIA'					, 'msd_mediatypes');
	define('OFFICES'				, 'msd_offices');
	define('ORDERS'					, 'msd_orders');
	define('ORDER_DETAILS'			, 'msd_order_details');
	define('PURCHASES'				, 'msd_purchases');
	define('PURCHASE_DETAILS'		, 'msd_purchase_details');
	define('SALES'					, 'msd_sales');
	define('SALE_DETAILS'			, 'msd_sale_details');
	define('VENDORS'				, 'msd_vendors');
	define('ROLES'					, 'msd_roles');
	define('CLASSES'				, 'msd_classes');
	define('DESIGNATIONS'			, 'prs_designations');
	define('EMPLOYEES'				, 'prs_employees');
	define('EMPLY_LEAVES'			, 'prs_employee_leaves');
	define('EMPLY_ATTENDANCE'		, 'prs_employee_attendances');
	define('LEAVES'					, 'prs_leavecategory');
	define('DEPTS'					, 'prs_departments');
	define('SHIFTS'					, 'prs_working_shifts');
	define('SHIFT_DETAIL'			, 'prs_working_shiftdetail');
	define('HOLIDAYS'				, 'prs_holidays');
	define('REQUEST_PAYMENT_REMARKS', 'msd_request_payment_remarks');

	define('WHATSAPP_MESSAGES'		, 'msd_whatsappmessages');
	define('RAAST_QR_DETAILS'		, 'msd_raast_qr_details');



	define('COMPLAINTS'				, 'msd_complaints');
	define('COMPLAINTS_MESSAGE'		, 'msd_complaints_messages');
	define('COMPLAINTS_MESSAGE_VIEW', 'msd_complaints_messages_view');
	
	define('CALL_FOLLOWUPS'			, 'msd_call_followups');
	
	$ip	  	= (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '') ? $_SERVER['REMOTE_ADDR'] : '';
	$do	  	= (isset($_REQUEST['do']) && $_REQUEST['do'] != '') ? $_REQUEST['do'] : '';
	$view 	= (isset($_REQUEST['view']) && $_REQUEST['view'] != '') ? $_REQUEST['view'] : '';
	$page	= (isset($_REQUEST['page']) && $_REQUEST['page'] != '') ? $_REQUEST['page'] : '';
	$Limit	= (isset($_REQUEST['Limit']) && $_REQUEST['Limit'] != '') ? $_REQUEST['Limit'] : '';
	$zone 	= (isset($_REQUEST['zone']) && $_REQUEST['zone'] != '') ? $_REQUEST['zone'] : '';
	$control = (isset($_REQUEST['control']) && $_REQUEST['control'] != '') ? $_REQUEST['control'] : '';

	define('PAYMENT_REQUEST_PERMISSIONS'	, array('34','30','2'));

	// Pay Fast Setting
	define('PAYFAST_MERCHANTID'	, 16638);
	define('PAYFAST_SECUREDKEY'	, "vCAt3OYgmO-6hdusENuwh5");
	define('PAYFAST_TOKENURL'	, "https://ipg1.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken");
	define('PAYFAST_TRNSURL'	, "https://ipg1.apps.net.pk/Ecommerce/api/Transaction/PostTransaction");
	define('PAYFAST_CALLBACK'	, "https://msd.gptech.pk/PayFast/success.php");
	define('PAYFAST_BASICAUTH'	, "ZjdjYmVhOTAtOTBmMC0xMWVkLWIzZWEtMDA1MDU2YTRhOTc5OmExZTIyMDkxMjE4NGZkNWUzMjhiNGU0MzEzMzQyZTZkNDc1OTU2Yzc0OTA2MTc1ZjFkMDcyNjM1NjQyZGI1Mzk=");
	/*
	define('PAYFAST_MERCHANTID'	, 12755);
	define('PAYFAST_SECUREDKEY'	, "EPxDB03HcU7yzIgstwwj");
	define('PAYFAST_TOKENURL'	, "https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken");
	define('PAYFAST_TRNSURL'	, "https://ipguat.apps.net.pk/Ecommerce/api/Transaction/PostTransaction");
	*/
	
	define('LMS_IP'				, $ip);
	define('LMS_DO'				, $do);
	define('LMS_EPOCH'			, date("U"));
	define('LMS_VIEW'			, $view);
	define('BANK_CHARGES'		, '50');
	define('ONEBILL_PREFIX'		, '100282');
	define('INVOICE_NOTE'		, '<ul style="margin:0;">
										<li><b>Book Return Policy (Effective 15 Nov 2024):</b></li>
										<li>0% deduction if returned within 40 days</li>
										<li>5% deduction for returns between 41-60 days</li>
										<li>10% deduction for returns between 61-90 days</li>
										<li>15% deduction for returns between 91 days-7 months</li>
										<li>No returns accepted after 7 months</li>
									</ul>');
	define('MSD_CELLNO'			, 'Ph: 042-35112203, Mobile: 0323 411 12 13');
	define('TITLE_HEADER'		, 'Laurel Publishers');
	define("SITE_NAME"			, "Laurel Publishers");
	define("SALES_EMAIL"		, "sales@laurelpublishers.com");
	define("SALES_CELLNO"		, "03030010406");
	define("SITE_URL"			, "https://msd.gptech.pk");
	define("SITE_ADDRESS"		, "Aghosh Complex Near Civic Center, Shah Jilani Road, Township Lahore.");
	define("COPY_RIGHTS"		, "Green Professional Technologies");
	define("COPY_RIGHTS_ORG"	, "&copy; ".date("Y")." - All Rights Reserved.");
	define("COPY_RIGHTS_URL"	, "https://gptech.pk/");

	
	define('WA_URL'				, "https://whatsapp.metasquad.info/send-message");
	define('WA_MEDIA_URL'		, "https://whatsapp.metasquad.info/send-media");
	define('WA_APPKEY'			, "TYMB678P4YjZnC7yb9XssbIu3gqLEh");
	define('WA_SENDER'			, "923234111213");

	define('BANKCO_USERNAME'		, "laurelpublishers.com");
	define('BANKCO_PASSWORD'		, "lp@365_");
	define('BANKCO_CLIENTID'		, "2");
	define('BANKCO_CLIENTSECRET'	, "219b9f13cac16ff632eeade35e0caebb");
	define('BANKCO_ACCESSTOKENURL'	, "http://bankco.pk/api/get-access-token.php");
	define('BANKCO_QRCODEURL'		, "http://bankco.pk/api/get-qr-code.php");