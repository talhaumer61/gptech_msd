<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'edit' => '1'))) { 	
//------------------------------------------------
	
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'id' 	=> cleanvars($_GET['id'])
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $valuepurchase 	= $dblms->getRows(STOCKS_TAKING, $conditions);

//------------------------------------------------
$diabledFields = '';
$diabledSelect = '';
if($valuepurchase['status'] != 4){
	$diabledFields = 'readonly';
	$diabledSelect = 'disabled';
}
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="stockstaking.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="id" name="id" value="'.$valuepurchase['id'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'stockstaking.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Stock Taking Detail</h4>
	</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Taking #</label>
			<input type="text" class="form-control" id="st_no" name="st_no" required value="'.$valuepurchase['taking_no'].'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="taking_date" value="'.$valuepurchase['taking_date'].'" name="taking_date" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Taking Type</label>
			<select id="taking_type" name="taking_type" style="width:100%" class="select2" autocomplete="off" required >
				<option value="">Select</option>';
				foreach($stocktaking as $listtaking) {  				
					echo ($listtaking['id'] == $valuepurchase['taking_type']) ? '<option value="'.$listtaking['id'].'" selected>'.$listtaking['name'].'</option>' : '<option value="'.$listtaking['id'].'">'.$listtaking['name'].'</option>';
				
				}
				echo '
			</select>
		</div> 
	</div>
	
	
	<div style="clear:both; padding:5px;"></div>
	
		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label class="req"> Taking By</label>
				<input type="text" class="form-control" id="taking_by" name="taking_by" value="'.$valuepurchase['taking_by'].'" required autocomplete="off">
			</div> 
		</div>

		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label> Remarks</label>
				<input type="text" class="form-control" id="remarks" name="remarks" value="'.$valuepurchase['remarks'].'" autocomplete="off">
			</div> 
		</div>


	<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Stocks Taking Details
	</div>

<table class="footable table table-bordered table-hover invE_table footable-loaded">
	<thead>
		<tr>
			<th style="text-align:center;vertical-align: middle;" rowspan="2">Sr. #</th>
			<th style="text-align:left;vertical-align: middle;" rowspan="2">Items </th>
			<th style="text-align:center;" colspan="2">System Stock</th>
			<th style="text-align:center;" colspan="2">Physically stock</th>
			<th style="text-align:center;" colspan="2">Difference</th>
		</tr>
			
		<tr>
			<th style="text-align:center;width:120px;">QTY</th>
			<th style="text-align:center;width:150px;">Amount</th>
			<th style="text-align:center;width:120px;">QTY</th>
			<th style="text-align:center;width:150px;">Amount</th>
			<th style="text-align:center;width:100px;">QTY</th>
			<th style="text-align:center;width:100px;">Amount</th>
		</tr>
	</thead>
<tbody>';
///----------------------------------------------
	$POconditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'id_taking' => cleanvars($_GET['id'])
													) 
							, 'return_type' => 'all' 
						 ); 
    $podetails 	= $dblms->getRows(STOCKS_TAKINGDETAIL, $POconditions);

///----------------------------------------------
$i=0;
foreach ($podetails as $rowsdet) {
	
	$readonly = '';

	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" style="width:100%" class="select2" autocomplete="off" onchange="get_Itemstockdetail(this.value, '.$i.')">
				<option value=""></option>';
				foreach($Items as $arrayitem) {
					echo ($arrayitem['item_id'] == $rowsdet['id_item']) ? '<option value="'.$arrayitem['item_id'].'" selected>'.$arrayitem['item_code'].' '.$arrayitem['item_name'].'</option>' : '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' '.$arrayitem['item_name'].'</option>';
				}
			echo'
			</select>
		</td>
		<td colspan="2">
				
					<div id="getItemstockdetail_'.$i.'">	
					<input type="hidden" class="jQinv_sale_price" name="sale_price['.$i.']" id="sale_price_'.$i.'" value="'.$rowsdet['sale_price'].'">
						<div class="col-sm-61" >
							<input type="text" class="form-control col-lg-12 jQinv_system_stock" name="system_stock['.$i.']" id="system_stock'.$i.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.$rowsdet['system_stock'].'">
						</div>

						<div class="col-sm-61">
							<input type="text" class="form-control col-lg-12 jQinv_system_stockamount" name="system_stockamount['.$i.']" id="system_stockamount_'.$i.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.$rowsdet['system_stockamount'].'">
						</div>
					</div>		
					
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stock" style="color:orangered; font-weight:600; text-align:center;" name="physically_stock['.$i.']" id="physically_stock_'.$i.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="'.$rowsdet['physically_stock'].'">
				</td>
				<td style="width:150px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="physically_stockamount['.$i.']" id="physically_stockamount_'.$i.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly value="'.$rowsdet['physically_stockamount'].'">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stock" style="color:orangered; font-weight:600; text-align:center;" name="difference_stock['.$i.']" id="difference_stock_'.$i.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly value="'.($rowsdet['system_stock'] -$rowsdet['physically_stock']).'">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="difference_stockamount['.$i.']" id="difference_stockamount_'.$i.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly value="'.($rowsdet['system_stockamount'] - $rowsdet['physically_stockamount']).'">
				</td>
			</tr>';	
}
	///----------------------------------------------
	$ijn = ($i+1);
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td>
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'"  class="select2" style="width:100%"  autocomplete="off" onchange="get_Itemstockdetail(this.value, '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td colspan="2">
				
					<div id="getItemstockdetail_'.$ij.'">	
						<div class="col-sm-61" >
							<input type="text" class="form-control col-lg-12 jQinv_system_stock" name="system_stock['.$ij.']" id="system_stock'.$ij.'" style="color:#00f; font-weight:600; text-align:center;" readonly>
						</div>

						<div class="col-sm-61">
							<input type="text" class="form-control col-lg-12 jQinv_system_stockamount" name="system_stockamount['.$ij.']" id="system_stockamount_'.$ij.'" style="color:#00f; font-weight:600; text-align:center;" readonly>
						</div>
					</div>		
					
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stock" style="color:orangered; font-weight:600; text-align:center;" name="physically_stock['.$ij.']" id="physically_stock_'.$ij.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
				</td>
				<td style="width:150px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="physically_stockamount['.$ij.']" id="physically_stockamount_'.$ij.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stock" style="color:orangered; font-weight:600; text-align:center;" name="difference_stock['.$ij.']" id="difference_stock_'.$ij.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="difference_stockamount['.$ij.']" id="difference_stockamount_'.$ij.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
			</tr>';	
		}
echo'
<tr class="last_row">
	<td></td>
	<td></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandSystemstock" name="inV_grandSystemstock" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.$valuepurchase['total_systemstock'].'"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandSystemsamts" name="inV_grandSystemsamts" style="color:#00f; font-weight:600; text-align:right;" readonly value="'.$valuepurchase['total_systemstockamount'].'"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandPhysicalstock" name="inV_grandPhysicalstock" style="color:darkorange; font-weight:600; text-align:center;" readonly value="'.$valuepurchase['total_physicallystock'].'"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandPhysicaltotal" name="inV_grandPhysicaltotal" style="color:darkorange; font-weight:600; text-align:right;" readonly value="'.$valuepurchase['total_physicallyamount'].'"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandDifferqty" name="inV_grandDifferqty" readonly value="'.($valuepurchase['total_systemstock'] -$valuepurchase['total_physicallystock']).'" style="color:#f00; font-weight:600; text-align:center;" ></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandDifferamts" name="inV_grandDifferamts" readonly value="'.($valuepurchase['total_systemstockamount'] - $valuepurchase['total_physicallyamount']).'" style="color:#f00; font-weight:600; text-align:center;" ></td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'stockstaking.php\'">Closed</button>
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
	$("#id_type").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#inv_form").validate({
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
</script>';
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}