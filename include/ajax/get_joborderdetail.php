<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['orderno'])) {
	$orderno = $_GET['orderno']; 
//--------------------------------------------	
	$sqllmsget  = $dblms->querylms("SELECT * FROM ".ORDERS."  WHERE order_no = '".cleanvars($orderno)."' LIMIT 1");
	$rowsqt		= mysqli_fetch_array($sqllmsget);
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 

	<div style="clear:both;"></div>	
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> Particulars</div>	
	<div style="clear:both;"></div>	
		<table class="footable table table-bordered table-hover invE_table">
			<thead>
				<tr>
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
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".ORDER_DETAILS." WHERE id_order = '".cleanvars($rowsqt['order_id'])."' ORDER BY id ASC");
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
//-----------------------------------------
echo '
<tr class="inv_row">
	<td><input type="text" class="col-lg-12" name="detail[]" id="detail[]" required value="'.$rowbills['detail'].'" /></td>
	<td>
		<select id="id_item[]" name="id_item[]" style="width:100%" required autocomplete="off">
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
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_width" name="width[]" id="width[]" value="'.$rowbills['width'].'" /></td>
	<td style="width:85px;"><input type="text" class="col-lg-12 jQinv_item_height" name="height[]" id="height[]" value="'.$rowbills['height'].'" /></td>
	<td style="width:85px;"><input type="number" class="col-lg-12 jQinv_item_qty" name="qty[]" id="qty[]" value="'.$rowbills['qty'].'" /></td>
	<td style="width:130px;"><input type="text" class="col-lg-12 jQinv_item_sqft" name="sqft[]" id="sqft[]" value="'.$rowbills['sqft'].'" readonly /></td>
	<td style="width:80px;"><input type="text" class="col-lg-12 jQinv_item_rate" name="rate[]" id="rate[]"  /></td>
	<td style="width:150px;"><input type="text" class="col-lg-12 jQinv_item_total" name="amount[]" id="amount[]" readonly /></td>
</tr>';
//-----------------------------------------
	}
//-----------------------------------------
	echo '
	<tr class="last_row">
		<td colspan="10" style="text-align:right;">
		<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="">
	</td>
</tr>
</tbody>	
</table>
<div style="clear:both;"></div>
<input type="hidden" name="id_customer" id="id_customer" value="'.cleanvars($rowsqt['id_customer']).'">';
}
//--------------------------------------------
?>