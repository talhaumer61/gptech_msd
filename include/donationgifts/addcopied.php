<?php 
if(LMS_VIEW == 'addcopied' && isset($_GET['id'])  && !isset($_GET['idestimate'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'add' => '1'))) { 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'donationgifts.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Donation / Gifts Order</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Order #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="DF-'.mt_rand(100000,999999).'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date('Y-m-d').'" name="dated" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Type</label>
			<select id="id_type" name="id_type" style="width:100%" autocomplete="off" required >
				<option value="">Select</option>';
				foreach($doctype as $listdoc) {  
					if($listdoc['id'] == 10 || $listdoc['id'] == 11) { 
						echo '<option value="'.$listdoc['id'].'">'.$listdoc['name'].'</option>';
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
        echo '<option value="'.$listcrs['crs_id'].'">'.$listcrs['crs_name'].'</option>';
    }
    echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label>Customer Name</label>
				<input type="text" class="form-control" id="customer_name" name="customer_name" required autocomplete="off">
			</div> 
		</div>
		
		<div class="col-sm-41">
			<div class="form_sep">
				<label>Mobile #</label>
				<input type="text" class="form-control" id="customer_cell" name="customer_cell" required autocomplete="off">
			</div> 
		</div>

		<div class="col-sm-41">
			<div class="form_sep">
				<label> Email Address</label>
				<input type="email" class="form-control" id="customer_email" name="customer_email" autocomplete="off">
			</div> 
		</div>

		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label> Postal Address</label>
				<input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off">
			</div> 
		</div>



		<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. #</th>
				<th style="text-align:left;">Items </th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center; width:120px;" title="Avaiable Stock" >Stock</th>
				<th style="text-align:center; width:120px;">Unit Price</th>
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';
///----------------------------------------------
	$POconditions = array ( 
								'select' 		=> '*',
								'where' 		=> array( 
															'id_pr' => cleanvars($_GET['id'])
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
			<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item"  style="width:100%" autocomplete="off" onchange="getPrdgiftValue(this.value, '.$i.')">
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
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" value="'.$rowsdet['total_qty'].'" id="total_qty_'.$i.'" '.$readonly.'>
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
	</tr>';	
}
	///----------------------------------------------
	$ijn = ($i+1);
		for ($ij=$ijn; $ij <= ($i+5); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td>
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="id_item" style="width:100%"  autocomplete="off" onchange="getPrdgiftValue(this.value, '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$ij.']" id="total_qty_'.$ij.'"  autocomplete="off"  >
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
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'donationgifts.php\'">Closed</button>
		<input class="btn btn-primary" type="submit" value=" Add Record " id="submit_purchase_order" name="submit_purchase_order" onClick=\'return confirmSubmit()\'>
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

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
    
    $(".id_item").select2({
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
             company_name		: "required",
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required"
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