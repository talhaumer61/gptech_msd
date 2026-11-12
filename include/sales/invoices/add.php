<?php 
if(LMS_VIEW == 'add') { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '3', 'add' => '1'))) { 
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="invoices.php" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Add Invoice Detail</h4>
</div>

<div class="modal-body">
	
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Invoice #</label>
			<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="'.$_POST['invoice_no'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="invoice_dated" name="invoice_dated" value="'.$_POST['invoice_dated'].'" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>Quotation #</label>
			<input type="text" class="form-control" id="invoice_quotation_no" name="invoice_quotation_no"  autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label>PO .NO</label>
			<input type="text" class="form-control" name="invoice_pono" id="invoice_pono" autocomplete="off" >
		</div> 
	</div>
	
	
	<div style="clear:both;"></div>		
	<div class="col-sm-51" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Customer</label>
			<input type="text" class="form-control" readonly name="customername" value="'.$_POST['customer_name'].' ('.$_POST['customer_cell'].')">
		</div> 
	</div>

	<div class="col-sm-62" style="margin-top:10px;">
		<div class="form_sep">
			<label>Invoice Subject</label>
			<input type="text" class="form-control" id="invoice_subject" name="invoice_subject" autocomplete="off">
		</div> 
	</div>
	
	
	<div style="clear:both;"></div>	
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> Particulars</div>	
	<div style="clear:both;"></div>	
		<table class="footable table table-bordered table-hover invE_table">
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
$srnoi =0;
$totaladvance = 0;
//------------------------------------------------
for($iod=0;$iod<count($_POST['orderno']);$iod++) { 
//------------------------------------------------
	$sqllmsadvance  = $dblms->querylms("SELECT b.order_advance 
										FROM ".ORDERS." b 
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'  
										AND b.order_id = '".$_POST['orderno'][$iod]."'");
	$valueadvance = mysqli_fetch_array($sqllmsadvance);
//------------------------------------------------
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".ORDER_DETAILS." WHERE id_order = '".$_POST['orderno'][$iod]."' ORDER BY id ASC");
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
$srnoi++;
if($srnoi == 1) { 
	$autofocus = 'autofocus';
} else { 
	$autofocus = ' ';
}
//-----------------------------------------
echo '
<tr class="inv_row">
	<td>'.$_POST['orderno'][$iod].'</td>
	<td><input type="text" class="col-lg-12" name="detail['.$srnoi.']" id="detail['.$srnoi.']" required value="'.$rowbills['detail'].'" /></td>
	<td>
		<select id="id_item['.$srnoi.']" name="id_item['.$srnoi.']" style="width:100%" required autocomplete="off">
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
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_width" name="width['.$srnoi.']" id="width['.$srnoi.']" value="'.$rowbills['width'].'" /></td>
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_height" name="height['.$srnoi.']" id="height['.$srnoi.']" value="'.$rowbills['height'].'" /></td>
	<td style="width:85px;"><input type="number" class="col-lg-12 jQinv_item_qty" name="qty['.$srnoi.']" id="qty['.$srnoi.']" value="'.$rowbills['qty'].'" /></td>
	<td style="width:130px;"><input type="text" class="col-lg-12 jQinv_item_sqft" name="sqft['.$srnoi.']" id="sqft['.$srnoi.']" value="'.$rowbills['sqft'].'" readonly /></td>
	<td style="width:80px;"><input type="text" class="col-lg-12 jQinv_item_rate" required name="rate['.$srnoi.']" id="rate[]'.$srnoi.'" tabindex="'.$srnoi.'" '.$autofocus.'  /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12 jQinv_item_total" name="amount['.$srnoi.']" id="amount['.$srnoi.']" readonly /></td>
</tr>
<input type="hidden" name="idorder['.$srnoi.']" id="idorder['.$srnoi.']" value="'.cleanvars($_POST['orderno'][$iod]).'">';
//-----------------------------------------
	}
	$totaladvance = ($totaladvance + $valueadvance['order_advance']);
	
}
$srnoj = ($srnoi + 1);
//-----------------------------------------
echo '
<tr class="last_row">
<input type="hidden" value="'.$totaladvance.'" class="invoice_advance" id="invoice_advance" name="invoice_advance">
	<td colspan="10" style="text-align:right;">
		<p class="clearfix"><b> Total: <span class="inV_total"><span>0</span></span></b></p>
		<p class="clearfix"><b> Advance: <span>'.$totaladvance.'</span></b></p>
		<p class="clearfix"><b> GST Rate: <span style="color:#555;"> <input type="text" class=" jQinv_gst_rate" name="invoice_gstrate" id="invoice_gstrate" style="width:50px; height:20px; text-align:right; padding-right:3px;" tabindex="'.$srnoj.'" /> %</span> </b></p>
		<p class="clearfix"><b> Total GST: <span class="inV_totalgsttax"><span>0</span></span></b></p>
		<p class="clearfix"><b> NTN Rate: <span style="color:#555;"> <input type="text" class="jQinv_ntn_rate" name="invoice_ntnrate" id="invoice_ntnrate" style="width:50px; height:20px; text-align:right; padding-right:3px;" tabindex="'.$srnoj.'" /> %</span> </b></p>
		<p class="clearfix"><b> Total NTN: <span class="inV_totalntntax"><span>0</span></span></b></p>
		<p class="clearfix"><b> Grand Total: <span class="inV_grandtotal"><span>0</span></span></b></p>
		<input type="hidden" id="inV_total" name="inV_total" value="">
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="">
		<input type="hidden" id="inV_totalgsttax" name="inV_totalgsttax" value="">
		<input type="hidden" id="inV_totalntntax" name="inV_totalntntax" value="">
	</td>
</tr>
</tbody>	
</table>

<div style="clear:both;"></div>

</div>
<input type="hidden" name="id_customer" id="id_customer" value="'.cleanvars($_POST['id_customer']).'">
<div class="modal-footer">
	<button type="submit" class="btn btn-primary" value="saveprint" id="submit_country" name="submit_country" tabindex="'.$srnoj.'">Save &amp; Print</button>
	<button type="submit" class="btn btn-primary" value="savechanges" id="submit_country" name="submit_country" tabindex="'.$srnoj.'">Save Invoice</button> 
	
	<button type="button" class="btn btn-default" onclick="location.href=\'invoices.php\'" tabindex="'.$srnoj.'" >Cancel</button>
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
