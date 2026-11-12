<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
//if($_SESSION['userlogininfo']['LOGINIDA'] == 2) { 	
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 	
//------------------------------------------------	
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'package_id' => cleanvars($_GET['id'])
													) 
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $valuepurchase 	= $dblms->getRows(PACKAGES, $conditions);

//------------------------------------------------
$diabledFields = '';
$diabledSelect = '';

	$editbuttn = ' <button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'>Update Changes</button>';
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="backpacks.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="package_id" name="package_id" value="'.$valuepurchase['package_id'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'backpacks.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Backpack Detail</h4>
	</div>

<div class="modal-body">

	<div class="col-sm-25">
		<div class="form_sep">
			<label class="req">Backpack #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="'.$valuepurchase['package_no'].'" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Backpack Name</label>
			<input type="text" class="form-control" id="package_name" name="package_name" required value="'.$valuepurchase['package_name'].'" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-25">
		<div class="form_sep">
			<label class="req">Class</label>
			<select id="id_class" name="id_class" class="select2" style="width:100%" autocomplete="off" required >
				<option value="">Select</option>';
				foreach($classnames as $listclass) {  
					echo ($listclass['id'] == $valuepurchase['id_class']) ? '<option value="'.$listclass['id'].'" selected>'.$listclass['name'].'</option>' : '<option value="'.$listclass['id'].'">'.$listclass['name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Brand</label>
			<select id="id_brand" name="id_brand" class="select2" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($brandnames as $listbrand) {
				echo ($listbrand['id'] == $valuepurchase['id_brand']) ? '<option value="'.$listbrand['id'].'" selected>'.$listbrand['name'].'</option>' : '<option value="'.$listbrand['id'].'">'.$listbrand['name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>

		<div class="col-sm-100">
			<div class="form_sep">
				<label> Backpack Detail</label>
				<input type="text" class="form-control" id="package_detail" name="package_detail" value="'.$valuepurchase['package_detail'].'" autocomplete="off">
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
		<th style="text-align:center;">Unit Total</th>
</thead>
<tbody>';
///----------------------------------------------
		$Odconditions = array ( 
								'select' 	=> ''.PACKAGES_DETAIL.'.*, '.ITEMS.'.item_id, 
												'.ITEMS.'.item_code, '.ITEMS.'.item_name, '.ITEMS.'.item_pricesale',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PACKAGES_DETAIL.".id_item",
								'where' => array( 
													''.PACKAGES_DETAIL.'.id_package' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.PACKAGES_DETAIL.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(PACKAGES_DETAIL, $Odconditions);

///----------------------------------------------
$i=0;
$total = 0 ;
foreach ($podetails as $rowsdet) {

	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:70px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" class="select2" style="width:100%" autocomplete="off" onchange="get_itempricee(this.value, '.$i.')">
				<option value=""></option>';
				foreach($Items as $arrayitem) { 
					echo ($arrayitem['item_id'] == $rowsdet['id_item']) ? '<option value="'.$arrayitem['item_id'].'" selected>'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>' : '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
				}
			echo'
			</select>
		</td>
		
		<td style="width:130px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " style="color:#00f; font-weight:600; text-align:center;" name="qty['.$i.']" value="'.$rowsdet['qty'].'" id="qty_'.$i.'" '.$readonly.'>
		</td>
		<td style="width:130px;">
					<div id="getitempricee_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$i.']" id="unit_price_'.$i.'" readonly  autocomplete="off" '.$required.' value="'.$rowsdet['item_pricesale'].'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;">
					</div>
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly=""   value="'.($rowsdet['qty'] * $rowsdet['item_pricesale']).'">
				</td>
		
	</tr>
	<script>
		$("#id_item_'.$i.'").select2({
			allowClear: true
		});
	</script>';	
	$total = ($total + ($rowsdet['qty'] * $rowsdet['item_pricesale']));
}
	///----------------------------------------------
	$ijn = ($i+1);
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td>
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="select2" style="width:100%"  autocomplete="off" onchange="get_itempricee(this.value, '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="qty['.$ij.']" id="qty_'.$ij.'"  autocomplete="off"  >
				</td>
				<td style="width:130px;">
					<div id="getitempricee_'.$ij.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$ij.']" id="unit_price_'.$ij.'" readonly  autocomplete="off" >
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
		<p class="clearfix"><b> Estimated Package Amount: <span class="inV_grandtotal">Rs.<span>'.$total.'</span></span></b></p>
	</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'backpacks.php\'">Closed</button>
	'.$editbuttn.'
</div>
</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<!--JS_SELECT_LISTS-->


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