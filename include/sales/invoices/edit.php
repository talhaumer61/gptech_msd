<?php 
//------------------------------------------------
if(isset($_GET['id']) && !LMS_VIEW) { 
//--------------------------------------
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '3', 'edit' => '1'))) { 
//------------------------------------------------
	$sqllms  	= $dblms->querylms("SELECT * 
											FROM ".INVOICES." i 
											INNER JOIN ".CUSTOMERS." c ON c.customer_id = i.id_customer 
											WHERE i.invoice_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="invoices.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Invoice Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Invoice #</label>
			<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="'.$rowstd['invoice_no'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="invoice_dated" name="invoice_dated" value="'.$rowstd['invoice_dated'].'" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>Quotation #</label>
			<input type="text" class="form-control" id="invoice_quotation_no" name="invoice_quotation_no" value="'.$rowstd['invoice_quotation_no'].'"  autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label>PO .NO</label>
			<input type="text" class="form-control" name="invoice_pono" id="invoice_pono" value="'.$rowstd['invoice_pono'].'">
		</div> 
	</div>
	
	
	<div style="clear:both;"></div>		
	<div class="col-sm-51" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Customer</label>
			<input type="text" class="form-control" readonly name="customer" value="'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)">
		</div> 
	</div>

	<div class="col-sm-62" style="margin-top:10px;">
		<div class="form_sep">
			<label>Invoice Subject</label>
			<input type="text" class="form-control" id="invoice_subject" name="invoice_subject" value="'.$rowstd['invoice_subject'].'" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>	
	<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;"> Particulars</div>	
	<div style="clear:both;"></div>	
		<table class="footable table table-bordered invE_table">
			<thead>
				<tr>
					<th>Job #</th>
					<th>Detail</th>
					<th>Media</th>
					<th style="text-align:center;">Width</th>
					<th style="text-align:center;">Height</th>
					<th style="text-align:center;">Qty</th>
					<th style="text-align:center;">Sqft</th>
					<th style="text-align:center;">Rate</th>
					<th style="text-align:center;">Total</th>
				</tr>
				</thead>
				<tbody>';
//------------------------------------------------
$srnoe = 0;
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".INVOICE_DETAILS." WHERE id_invoice = '".cleanvars($_GET['id'])."' ORDER BY id ASC");
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
$srnoe++;
if($srnoe == 1) { 
	$autofocus = 'autofocus';
} else { 
	$autofocus = ' ';
}
if($rowbills['rate']) { 
	$ratevalue = $rowbills['rate'];
} else { 
	$ratevalue = '';
}

//-----------------------------------------
echo '
<tr class="inv_row">
	<td>'.$rowbills['id_order'].'</td>
	<td><input type="text" class="col-lg-12" name="detail['.$srnoe.']" id="detail['.$srnoe.']" required value="'.$rowbills['item'].'" /></td>
	<td>
		<select id="id_item['.$srnoe.']" name="id_item['.$srnoe.']" style="width:100%" required autocomplete="off">
			<option value="">Choose Media</option>';
		  $sqllmsmedia	= $dblms->querylms("SELECT item_id, item_status, item_name  
													FROM ".ITEMS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													ORDER BY item_name ASC");
			while($valuemedia 	= mysqli_fetch_array($sqllmsmedia)) { 
				if($valuemedia['item_id'] == $rowbills['id_item']) { 
					echo '<option value="'.$valuemedia['item_id'].'" selected>'.$valuemedia['item_name'].'</option>';
				} else  { 
					echo '<option value="'.$valuemedia['item_id'].'">'.$valuemedia['item_name'].'</option>';
				}
			}
	echo'
		</select>
	</td>
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_width" name="width['.$srnoe.']" id="width['.$srnoe.']" value="'.$rowbills['width'].'" /></td>
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_height" name="height['.$srnoe.']" id="height['.$srnoe.']" value="'.$rowbills['height'].'" /></td>
	<td style="width:85px;"><input type="number" class="col-lg-12 jQinv_item_qty" name="qty['.$srnoe.']" id="qty['.$srnoe.']" value="'.$rowbills['qty'].'" /></td>
	<td style="width:130px;"><input type="text" class="col-lg-12 jQinv_item_sqft" name="sqft['.$srnoe.']" id="sqft['.$srnoe.']" value="'.$rowbills['sqft'].'" readonly /></td>
	<td style="width:80px;"><input type="text" class="col-lg-12 jQinv_item_rate" required name="rate['.$srnoe.']" id="rate['.$srnoe.']" value="'.$ratevalue.'" tabindex="'.$srnoe.'" '.$autofocus.' /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12 jQinv_item_total" name="amount['.$srnoe.']" id="amount['.$srnoe.']" value="'.$rowbills['amount'].'" readonly /></td>
</tr>
<input type="hidden" name="idorder['.$srnoe.']" id="idorder['.$srnoe.']" value="'.cleanvars($rowbills['id_order']).'">';
//-----------------------------------------
	}
	
$srnotb = ($srnoe+1);	
//-----------------------------------------
	echo '
	<tr class="last_row">
	<input type="hidden" value="'.$rowstd['invoice_advance'].'" class="invoice_advance" id="invoice_advance" name="invoice_advance">
		<td colspan="10" style="text-align:right;">
		<p class="clearfix"><b> Total: <span class="inV_total"><span>'.$rowstd['invoice_total'].'</span></span></b></p>
		<p class="clearfix"><b> Advance: <span>'.$rowstd['invoice_advance'].'</span></b></p>
		<p class="clearfix"><b> GST Rate: <span style="color:#555;"> <input type="text" class=" jQinv_gst_rate" name="invoice_gstrate" id="invoice_gstrate" value="'.$rowstd['invoice_gstrate'].'" style="width:50px; height:20px; text-align:right; padding-right:3px;" tabindex="'.$srnotb.'" /> %</span> </b></p>
		<p class="clearfix"><b> Total GST: <span class="inV_totalgsttax"><span>'.$rowstd['invoice_gsttotal'].'</span></span></b></p>
		<p class="clearfix"><b> NTN Rate: <span style="color:#555;"> <input type="text" class=" jQinv_ntn_rate" name="invoice_ntnrate" id="invoice_ntnrate" value="'.$rowstd['invoice_ntnrate'].'" style="width:50px; height:20px; text-align:right; padding-right:3px;" tabindex="'.$srnotb.'"   /> %</span> </b></p>
		<p class="clearfix"><b> Total NTN: <span class="inV_totalntntax"><span>'.$rowstd['invoice_ntntotal'].'</span></span></b></p>
		<p class="clearfix"><b> Grand Total: <span class="inV_grandtotal"><span>'.$rowstd['invoice_grand'].'</span></span></b></p>
		<input type="hidden" id="inV_total" name="inV_total" value="'.$rowstd['invoice_total'].'">
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$rowstd['invoice_grand'].'">
		<input type="hidden" id="inV_totalgsttax" name="inV_totalgsttax" value="'.$rowstd['invoice_gsttotal'].'">
		<input type="hidden" id="inV_totalntntax" name="inV_totalntntax" value="'.$rowstd['invoice_ntntotal'].'">
	</td>
</tr>
</tbody>	
</table>

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="submit" class="btn btn-primary" value="saveprint" id="bill_changes" name="bill_changes" tabindex="'.$srnotb.'" >Save &amp; Print</button>
	<button type="submit" class="btn btn-primary" value="savechanges" id="bill_changes" name="bill_changes" tabindex="'.$srnotb.'" >Save Changes</button> 
	<button type="button" class="btn btn-default" onclick="location.href=\'invoices.php\'" tabindex="'.$srnotb.'"  >Cancel</button>
</div>

</div>
</form>
<script>
    $("#invoicestatus").select2({
        allowClear: true
    });
	
	$("#orderdesign").select2({
        allowClear: true
    });
	
	$("#idcustomer").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
}
}