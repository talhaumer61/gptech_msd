<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) { 	
//------------------------------------------------
	
	$conditions = array ( 
								'select' 	=> ''.PURCHASE_ORDER.'.*, '.VENDORS.'.vendor_name, '.VENDORS.'.vendor_cellno, '.VENDORS.'.vendor_email',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
								'where' => array( 
													''.PURCHASE_ORDER.'.purchase_order_id' 	=> cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valuepurchase 	= $dblms->getRows(PURCHASE_ORDER, $conditions);

//------------------------------------------------
$diabledFields = '';
$diabledSelect = '';
if($valuepurchase['po_status'] != 4){
	$diabledFields = 'readonly';
	$diabledSelect = 'disabled';
}
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="purchase-order.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="id_vendor" name="id_vendor" value="'.$valuepurchase['id_vendor'].'">
<input type="hidden" name="purchase_order_id" name="purchase_order_id" value="'.$valuepurchase['purchase_order_id'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'purchase-order.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Purchase Order Detail</h4>
	</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Purchase Order #</label>
			<input type="text" class="form-control" id="po_order_no" value="'.$valuepurchase['po_order_no'].'" name="po_order_no" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Purchase Order Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.$valuepurchase['dated'].'" name="dated" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Vendor</label>
			<input type="text" class="form-control" id="vendor" name="vendor" value="'.$valuepurchase['vendor_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Vendor Name</label>
			<input type="text" class="form-control" id="vendor_cellno" name="vendor_cellno" required value="'.$valuepurchase['vendor_cellno'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Vendor Phone #</label>
			<input type="text" class="form-control" id="vendor_email" name="vendor_email" required value="'.$valuepurchase['vendor_email'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" id="vendor_openingbalance" name="vendor_openingbalance" required value="'.$valuepurchase['opening_balance'].'" readonly>
		</div> 
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Advance</label>
			<input type="text" class="form-control" id="advance" name="advance" value="'.$valuepurchase['advance'].'" min="'.$valuepurchase['total'].'" '.$diabledFields.' autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Paid Date</label>
			<input type="text" class="form-control pickdmy" id="paid_date" name="paid_date" value="'. date('d-m-Y').'" '.$diabledFields.' autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Payment Method</label>
			<select id="payment_method" class="select2" name="payment_method" onchange="get_paymethoddetail(this.value)" style="width:100%" '.$diabledSelect.' autocomplete="off">
				<option value="">Choose Method</option>';
					foreach($pay_types as $paymode) { 
						echo '<option value="'.$paymode['id'].'"';if($paymode['id'] == $valuepurchase['paid_method']){echo' selected';} echo'>'.$paymode['name'].'</option>';
					}
				echo'
			</select>
		</div> 
	</div>

	<div id="getpaymethoddetail">';
	
		if($valuepurchase['paid_method'] == 1){
			echo ' 
			<div class="col-sm-51">
				<div class="form_sep">
					<label class="req">Account #</label>
					<select id="id_account" class="select2" name="id_account" style="width:100%" '.$diabledSelect.' autocomplete="off">
						<option value="">Select Account</option>';
							foreach($bankAccounts as $account) { 
								echo '<option value="'.$account['id'].'"';if($account['id'] == $valuepurchase['id_account']){echo' selected';} echo'>'.$account['bank'].' - '.$account['acc_number'].'</option>';
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
					<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" value="'.$valuepurchase['deposit_slip'].'" '.$diabledFields.' autocomplete="off">
				</div> 
			</div>';

		}
	echo '
	</div>
	<div style="clear:both;"></div>
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" value="'.($valuepurchase['remarks']).'" autocomplete="off">
		</div>
	</div>

	<div style="clear:both; padding:5px;"></div>

<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
Item Details
</div>

<table class="footable table table-bordered table-hover invE_table footable-loaded">
<thead>
	<tr>
		<th style="text-align:center;">Sr #</th>
		<th style="text-align:left;">Items </th>
		<th style="text-align:center;">Qty</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------
	$POconditions = array ( 
								'select' 	=> '*',
								'where' => array( 
													'id_po' => cleanvars($_GET['id'])
												), 
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $POconditions);

///----------------------------------------------
$i=0;
$total = 0 ;
foreach ($podetails as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	
	// Check Stocks received 
	///----------------------------------------------
	$stockconditions = array ( 
								'select' 	=> 'SUM(qty) as TotalQTY',
								'where' => array( 
													'reference_no' 		=> cleanvars($_GET['id']),
													'id_item' 			=> cleanvars($rowsdet['id_item']),
													'reference_type' 	=> 1,
													'stock_type' 		=> 1
												), 
								'return_type' 	=> 'single' 
							); 
    $valuestock	= $dblms->getRows(STOCK, $stockconditions);

	
	$qtyreceiveable = ($rowsdet['qty'] - $valuestock['TotalQTY']);
if($qtyreceiveable == 0) {
	$readonly = 'readonly';
} else {
	$readonly = '';
}
	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" style="width:100%" autocomplete="off" onchange="getPrdPurchaseValue(this.value, '.$i.')">
				<option value=""></option>';
				foreach($Items as $arrayitem) {
					if($arrayitem['item_id'] == $rowsdet['id_item']){
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo '
					<option value="'.$arrayitem['item_id'].'" '.$selected.'>
						'.$arrayitem['item_code'].' '.$arrayitem['item_name'].'
					</option>';
				}
			echo'
			</select>
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " name="qty['.$i.']" value="'.$rowsdet['qty'].'" id="qty_'.$i.'" '.$readonly.'>
		</td>
		
		<td style="width:85px;">
			<div id="getPrdValue_'.$i.'">
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">
			</div>		
			
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
echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$valuepurchase['total'].'</span></span></b></p>
<!--p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span>'.($valuepurchase['grand_total'] + $valuepurchase['opening_balance']).'</span></span></b></p-->
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$valuepurchase['total'].'">
<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="'.$valuepurchase['grand_total'].'">
</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'purchase-order.php\'">Closed</button>
	<button type="submit" class="btn btn-warning" value="savehold" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'> Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'>Confirmed</button>
</div>
</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<!--JS_SELECT_LISTS-->

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
	$(".select2").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_ade_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             company_name_edit		: "required",
			 company_status_edit	: "required"
		},
		messages: {
			company_name_edit		: "This field is required",
			company_status_edit		: "This field is required"
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

		var item_status_edit			 = $(this).attr("data-item-status");
		var item_code_edit				 = $(this).attr("data-item-code");
		var item_name_edit				 = $(this).attr("data-item-name");
		var item_type_edit				 = $(this).attr("data-item-type");
		var item_reorder_edit			 = $(this).attr("data-item-reorder");
		var item_details_edit			 = $(this).attr("data-item-details");
		var item_pricepurchase_edit		 = $(this).attr("data-item-pricepurchase");
		var item_pricesale_edit			 = $(this).attr("data-item-pricesale");
		var id_cls_edit					 = $(this).attr("data-id-cls");
		var id_company_edit				 = $(this).attr("data-id-company");
		var item_id_edit				 = $(this).attr("data-item-id");
		var id_cat_edit				 	= $(this).attr("data-id-cat");


        //set modal input values dynamically
		$("#item_code_edit") 			.val(item_code_edit) 
		$("#item_name_edit") 			.val(item_name_edit) 
		// $("#item_type_edit") 			.val(item_type_edit) 
		$("#item_reorder_edit") 		.val(item_reorder_edit) 
		$("#item_details_edit") 		.val(item_details_edit) 
		$("#item_pricepurchase_edit") 	.val(item_pricepurchase_edit) 
		$("#item_pricesale_edit") 		.val(item_pricesale_edit) 
		$("#item_id_edit") 				.val(item_id_edit) 


       //pre-select data in pull down lists
       $("#item_type_edit")				.select2().select2("val", item_type_edit); 
       $("#item_status_edit")			.select2().select2("val", item_status_edit); 
       $("#id_cls_edit")				.select2().select2("val", id_cls_edit); 
       $("#id_company_edit")			.select2().select2("val", id_company_edit); 
       $("#id_cat_edit")			.select2().select2("val", id_cat_edit); 
  });
    
});
</script>';
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}