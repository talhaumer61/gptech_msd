<?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'edit' => '1'))) { 
//------------------------------------------------
	
	$conditions = array ( 
								'select' 		=> ''.PURCHASE_RETURNS.'.*, '.VENDORS.'.vendor_id, '.VENDORS.'.vendor_name, 
													'.VENDORS.'.vendor_openingbalance',
								'join' 			=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_RETURNS.".id_vendor",
								'where' 		=> array ( 
															''.PURCHASE_RETURNS.'.pr_id' 	=> cleanvars($_GET['id'])
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(PURCHASE_RETURNS, $conditions);
	
// get all Items

	$itemsconditions = array ( 
								'select' 		=> 'item_id, item_name, item_code',
								'order_by' 		=> 'item_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Items = $dblms->getRows(ITEMS, $itemsconditions);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="purchasereturns.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_vendor" name="id_vendor" value="'.$rowstd['id_vendor'].'">
<input type="hidden" id="vendor_openingbalance" name="vendor_openingbalance" value="'.$rowstd['opening_balance'].'">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" onclick="location.href=\'purchasereturns.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Edit Purchase Return Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">PR #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" value="'.($rowstd['pr_no']).'" readonly>
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
			<label class="req">Vendor Name</label>
			<input type="text" class="form-control" id="vendor_name" name="vendor_name" value="'.($rowstd['vendor_name']).'" readonly>
		</div> 
	</div>

	<div style="clear:both;padding:5px;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($rowstd['opening_balance']).'" readonly>
		
		</div> 
	</div>

	<div class="col-sm-81">
		<div class="form_sep">
			<label>Remarks</label>
			<input type="text" class="form-control" id="remarks" name="remarks" value="'.($rowstd['remarks']).'" autocomplete="off">
		</div> 
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
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Qty</th>
		
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';

///----------------------------------------------
	$Odconditions = array ( 
								'select' 		=> ''.PURCHASE_RETURNS_DETAILS.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PURCHASE_RETURNS_DETAILS.".id_item",
								'where' 		=> array ( 
															''.PURCHASE_RETURNS_DETAILS.'.id_pr' => cleanvars($_GET['id'])
														 ), 
								'order_by' 		=> ''.PURCHASE_RETURNS_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(PURCHASE_RETURNS_DETAILS, $Odconditions);
	
///----------------------------------------------
$i     = 0;
$total = 0 ;
foreach($Orderdetail as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
		<input type="text" class="form-control col-lg-12" name="item_name" value="'. $rowsdet['item_code'].' - '. $rowsdet['item_name'].'" readonly>
		</td>
		
		<td style="width:100px;">
			<div id="getPrdValue_'.$i.'">
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;" autocomplete="off">
			</div>		
			
		</td>
		<td style="width:100px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'"  style="text-align:center; color:#00f; font-weight:600; font-size:16px !important;" autocomplete="off">
		</td>
		
		<td style="width:130px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;font-weight:600; font-size:14px !important;">
		</td>
	</tr>
	<input type="hidden" name="id_item['.$i.']" id="id_item_'.$i.'" value="'.$rowsdet['id_item'].'">
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
				<td class="inv_clone_row" style="width:40px;text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td style="width:400px;">
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="select2" style="width:100% !important;"   autocomplete="off" onchange="get_returnPurchaseValue(this.value,'.$rowstd['id_vendor'].', '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '
							<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
					
				
				<td style="width:70px;">
				<div id="getreturnPurchaseValue_'.$ij.'">
			
					<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$ij.']" id="unit_price_'.$ij.'" autocomplete="off">
					
				</div>
						
				</td>
				
				
					<td  style="width:70px;">
						<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$ij.']" id="total_qty_'.$ij.'" style="text-align:center; color:#00f; font-weight:600; font-size:16px !important;" autocomplete="off">
					</td>
				
				<td style="width:120px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$ij.']" id="total_price_'.$ij.'" readonly="" style="text-align:right;">
				</td>
			</tr>
			';	
			
			
		}
echo '

<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_invoicetotal">Rs.<span>'.$total.'</span></span></b></p>
		<p class="clearfix"><b>Deducation % </b><input type="number" class="jQinv_deducation" id="deducation_per" name="deducation_per" value="'.$rowstd['deducation_per'].'" style="font-weight:600;color: chocolate;text-align:center; width:100px;" min="0" max="70"></p>
		<p class="clearfix"><b>Deducation Amount <span class="inV_deducation">Rs.<span>'.$rowstd['deducation_amount'].'</span></span></b></p>
		<p class="clearfix"><b> Grand Total: <span class="inV_grandtotal">Rs.<span>'.($total -$rowstd['deducation_amount']).'</span></span></b></p>

		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.($total -$rowstd['deducation_amount']).'">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="'.($total -$rowstd['deducation_amount']).'">
		<input type="hidden" id="inV_deducation" name="inV_deducation" value="'.$rowstd['deducation_amount'].'">
		<input type="hidden" id="inV_invoicetotal" name="inV_invoicetotal" value="'.$total.'">
	</td>
</tr>
</tbody>	
</table>
		

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="submit" class="btn btn-warning" value="savehold" id="bill_changes" name="bill_changes"  onClick=\'return confirmSubmit()\'> Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="bill_changes" name="bill_changes"  onClick=\'return confirmSubmit()\'>Confirmed</button>
	<button type="button" class="btn btn-default" onclick="location.href=\'purchasereturns.php\'" >Cancel</button>
</div>

</div>
</form>


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
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}