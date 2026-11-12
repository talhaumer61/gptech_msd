<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])  && isset($_GET['idestimate']) ) { 
//if($_SESSION['userlogininfo']['LOGINIDA'] == 2) { 	
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 	
//------------------------------------------------	
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'pr_id' => cleanvars($_GET['idestimate'])
													) 
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $valuepurchase 	= $dblms->getRows(DONATIONGIFTS, $conditions);

//------------------------------------------------
$diabledFields = '';
$diabledSelect = '';
if(!$valuepurchase['pr_no']) {
	$editbuttn = '<button type="submit" class="btn btn-warning" value="savehold" id="submit_estimatechanges" name="submit_estimatechanges" onClick=\'return confirmSubmit()\'> Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_estimatechanges" name="submit_estimatechanges" onClick=\'return confirmSubmit()\'>Confirmed</button>';
} else {
	$editbuttn = '';
}
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="donationgifts.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="pr_id" name="pr_id" value="'.$valuepurchase['pr_id'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'donationgifts.php?view=estimates\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Donations / Gifts Estimated Detail</h4>
	</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Estimate #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="'.$valuepurchase['estimate_no'].'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.$valuepurchase['dated'].'" name="dated" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Type</label>
			<select id="id_type" name="id_type" style="width:100%" autocomplete="off" required >
				<option value="">Select</option>';
				foreach($doctype as $listdoc) {  
					if($listdoc['id'] == 10 || $listdoc['id'] == 11) { 
						echo ($listdoc['id'] == $valuepurchase['id_type']) ? '<option value="'.$listdoc['id'].'" selected>'.$listdoc['name'].'</option>' : '<option value="'.$listdoc['id'].'">'.$listdoc['name'].'</option>';
					}
				}
				echo '
			</select>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer Representative</label>
			<select class="select2" id="id_crs" name="id_crs" style="width:100%" autocomplete="off" required >
				<option value="">Select</option>';
    foreach($crs as $listcrs) {
        echo (($listcrs['crs_id'] == $valuepurchase['id_crs']) ? '<option value="'.$listcrs['crs_id'].'" selected>'.$listcrs['crs_name'].'</option>' : '<option value="'.$listcrs['crs_id'].'">'.$listcrs['crs_name'].'</option>');
    }
    echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label>Customer Name</label>
				<input type="text" class="form-control" id="customer_name" name="customer_name" value="'.$valuepurchase['customer_name'].'" required autocomplete="off">
			</div> 
		</div>
		
		<div class="col-sm-41">
			<div class="form_sep">
				<label>Mobile #</label>
				<input type="text" class="form-control" id="customer_cell" name="customer_cell" required autocomplete="off"  value="'.$valuepurchase['customer_cell'].'" >
			</div> 
		</div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label> Email Address</label>
				<input type="email" class="form-control" id="customer_email" name="customer_email" autocomplete="off"  value="'.$valuepurchase['customer_email'].'" >
			</div> 
		</div>

		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label> Postal Address</label>
				<input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off" value="'.$valuepurchase['customer_address'].'" >
			</div> 
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
		<th style="text-align:center;" title="Avaiable Stock">Stock</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------
	$POconditions = array ( 
								'select' 		=> '*',
								'where' 		=> array( 
															'id_pr' => cleanvars($_GET['idestimate'])
														), 
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(DONATIONGIFTS_DETAILS, $POconditions);

///----------------------------------------------
$i=0;
$total = 0 ;
foreach ($podetails as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	

	$readonly = '';
	// get item stock
	$resulttotalInOut = $mainclass->get_itemstock($rowsdet['id_item']);
	
	$avaiablestock = ($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']);

	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" style="width:100%" autocomplete="off" onchange="getPrdgiftValue(this.value, '.$i.')" tabindex="'.($i).'">
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
		
		<td style="width:120px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'" '.$readonly.' tabindex="'.($i+1).'">
		</td>
		<td style="width:100px;">
			<input type="text" class="form-control col-lg-12" name="stock_qty['.$i.']" id="stock_qty'.$i.'" value="'.$avaiablestock.'" style="text-align:center; color:#00f; font-size:14px !important;  font-weight:600;" readonly>
		</td>
		<td style="width:120px;">
			<div id="getPrdValue_'.$i.'">
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">
			</div>		
			
		</td>
		<td style="width:130px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>
	<script>
		$("#id_item_'.$i.'").select2({
			allowClear: true
		});
	</script>';	
}
	///----------------------------------------------
	$ijn = ($i+1);
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td>
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="id_item" style="width:100%"  autocomplete="off" onchange="getPrdgiftValue(this.value, '.$ij.')" tabindex="'.($ij).'">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$ij.']" id="total_qty_'.$ij.'"  autocomplete="off" tabindex="'.($ij + 1).'" >
				</td>
				
				<td colspan="2">
					<div id="getPrdValue_'.$ij.'">
						
						<div class="col-sm-61" >
							<input type="text" class="form-control col-lg-12" name="stock_qty['.$ij.']" id="stock_qty'.$ij.'" readonly>
						</div>
				
						<div class="col-sm-61">
							<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$ij.']" id="unit_price_'.$ij.'" readonly  autocomplete="off" >
						</div>
					</div>		
					
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$ij.']" id="total_price_'.$ij.'" readonly="" style="text-align:right;">
				</td>
			</tr>
			<script>
				$("#id_item_'.$ij.'").select2({
					allowClear: true
				});
			</script>';	
		}
echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$valuepurchase['total'].'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$valuepurchase['total'].'">
</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'donationgifts.php?view=estimates\'">Closed</button>
	'.$editbuttn.'
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