<?php 
//------------------------------------------------
if(!isset($_GET['id']) && LMS_VIEW == 'add')  { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '34', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Estimate Detail</h4>
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
					echo '<option value="'.$listcusts['customer_id'].'">'.$listcusts['customer_code'].' - '.$listcusts['customer_name'].'</option>';
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
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
		for ($i=1; $i <=25; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off" onchange="get_PrdEstimateValue(this.value, '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" id="total_qty_'.$i.'"  autocomplete="off" '.$required.' >
				</td>
				
				<td style="width:130px;">
					<div id="getPrdEstimateValue_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$i.']" id="unit_price_'.$i.'" readonly  autocomplete="off" '.$required.' >
					</div>		
					
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
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
	<input class="btn btn-primary" type="submit" value=" Add Record " id="submit_purchase_order" name="submit_purchase_order" onClick=\'return confirmSubmit()\'>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php\'">Closed</button>
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
	 $(".select2").select2({
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
</script>';

} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}