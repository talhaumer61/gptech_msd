<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;">Add Sales Order</h4>
</div>

<div class="modal-body">


	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Invoice #</label>
			<input type="text" class="form-control" id="salesinvoice_no" name="salesinvoice_no" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Order Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date('Y-m-d').'" name="dated" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Company</label>
			<select id="id_company" name="id_company" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($companyarray as $itemcompany) {
					echo '<option value="'.$itemcompany['company_id'].'">'.$itemcompany['company_code'].'-'.$itemcompany['company_name'].'</option>';
				}
			echo '
			</select>
		</div> 
	</div>

	
	
	<div style="clear:both; padding:5px;"></div>
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="salesinvoice_status" class="select2" name="salesinvoice_status" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($payments as $payment) {
					echo '<option value="'.$payment['id'].'">'.$payment['name'].'</option>';
				}
			echo '
			</select>
		</div> 
	</div>
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Paid Amount</label>
			<input type="text" class="form-control" id="paid"   name="paid"  required autocomplete="off">

		</div> 
	</div>
	<div style="clear:both; padding:5px;"></div>
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Ade</label>
			<select id="id_ade" name="id_ade" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				$sqllmsade  = $dblms->querylms("SELECT ade_id , ade_name FROM ".ADES."   
												WHERE  ade_status = 1 
												ORDER BY ade_id DESC");
				
				while($valueade 	= mysqli_fetch_assoc($sqllmsade)) {
					echo '<option value="'.$valueade['ade_id'].'">'.$valueade['ade_name'].'</option>';
				}
			echo '
			</select>
		</div> 
	</div>
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Customer</label>
			<select id="id_customer" name="id_customer" style="width:100%" autocomplete="off" required
				onchange="getCustomerDetails(this.value)" >
				<option value="">Select</option>';
				$sqllmscustomer  = $dblms->querylms("SELECT customer_id , customer_name FROM ".CUSTOMERS."   
												WHERE  customer_status = 1 
												ORDER BY customer_id DESC");
				
				while($valuecustomer 	= mysqli_fetch_assoc($sqllmscustomer)) {
					echo '
						<option value="'.$valuecustomer['customer_id'].'">
							'.$valuecustomer['customer_name'].'
						</option>';
				}
			echo '
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>
			<div id="getCustomerDetails"></div>
	<div style="clear:both;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th style="text-align:center;">Items </th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Unit Price</th>
				
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
			$sqllmsitem  = $dblms->querylms("SELECT item_id , item_name FROM ".ITEMS."   
												WHERE  item_status = 1 
												ORDER BY item_id DESC");
			while($valueitem 	= mysqli_fetch_assoc($sqllmsitem)) {
				$arrayitems[] = $valueitem;
			}
		///----------------------------------------------
		for ($i=1; $i <= 10; $i++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:20px;"><span class="footable-toggle"></span>'.$i.'</td>
				<td style="width:200px;">
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"   autocomplete="off" onchange="getPrdValue(this.value, '.$i.')">
						<option value=""></option>';
						foreach($arrayitems as $arrayitem) {
							echo '
							<option value="'.$arrayitem['item_id'].'">
								'.$arrayitem['item_name'].'
							</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:85px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="qty['.$i.']" id="qty_'.$i.'">
				</td>
				
				<td style="width:85px;">
					<div id="getPrdValue_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$i.']" id="unit_price_'.$i.'">
					</div>		
					
				</td>
				<td style="width:130px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
				</td>
			</tr>';	
		}
echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Sales Invoice" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->
<script src="js/sales.js"></script>


<script>
    $("#item_status").select2({
        allowClear: true
    });
    $(".select2").select2({
        allowClear: true
    });
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#id_company").select2({
        allowClear: true
    });

	$("#id_customer").select2({
        allowClear: true
    });
	
	$("#item_type").select2({
        allowClear: true
    });
	$("#id_cat").select2({
        allowClear: true
    });
	$("#id_cls").select2({
        allowClear: true
    });
	$("#id_ade").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
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
}