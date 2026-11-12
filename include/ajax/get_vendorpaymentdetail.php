<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_vendor'])) {
//--------------------------------------------
echo ' 
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Order #</label>
			<select id="id_po" name="id_po" style="width:100%" required autocomplete="off">
				<option value="">Select Order</option>';
					$purchaseOrderArray = array();
					$sqllmsPurchaseOrder  = $dblms->querylms("SELECT i.purchase_order_id, i.po_order_no, i.advance, i.balance, i.grand_total
																	FROM ".PURCHASE_ORDER." i  
																	WHERE i.id_vendor = '".$_POST['id_vendor']."' 
																	ORDER BY i.purchase_order_id ASC");
					while($rowPurchaseOrder = mysqli_fetch_array($sqllmsPurchaseOrder)) {

						$purchaseOrderArray[] = $rowPurchaseOrder;
						echo '<option value="'.$rowPurchaseOrder['purchase_order_id'].'">'.$rowPurchaseOrder['po_order_no'].'</option>';
						
					}
				echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;padding:5px;"></div>

	<table class="footable table table-bordered table-hover footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Order # </th>
				<th style="text-align:center;">Total Payable</th>
				<th style="text-align:center;">Total Paid</th>
				<th style="text-align:center;">Total Pending</th>
			</tr>
		</thead>
		<tbody>';
		foreach ($purchaseOrderArray as $purchaseOrder) {

			$sqllmsPaid  = $dblms->querylms("SELECT SUM(i.invoice_paid) as totalPaid
												FROM ".PURCHASE_INVOICE." i 
												WHERE i.id_po = '".$purchaseOrder['purchase_order_id']."'");
			$rowPaid = mysqli_fetch_array($sqllmsPaid);

			$alreadyPaid = ($purchaseOrder['advance'] + $rowPaid['totalPaid']);
			$pendingAmount = ($purchaseOrder['grand_total'] - $alreadyPaid);
			
			if($pendingAmount > 0){
			echo'
			<tr class="inv_row">
				<td style="width:85px;">
					<input type="text" class="form-control col-lg-12" id="order" name="order" value="'.$purchaseOrder['po_order_no'].'" readonly>
				</td>
				<td style="width:85px;">
					<input type="text" class="form-control col-lg-12" id="payable" name="payable" value="'.$purchaseOrder['grand_total'].'" readonly>
				</td>
				<td style="width:85px;">
					<input type="text" class="form-control col-lg-12" id="paid" name="paid" value="'.$alreadyPaid.'" readonly>
				</td>
				<td style="width:130px;">
					<input type="number" class="form-control col-lg-12" id="pending" name="pending" value="'.$pendingAmount.'"readonly="" style="text-align:right;">
				</td>
			</tr>';	
			}
		}
		echo'
		</tbody>	
	</table>
	<div style="clear:both;padding:5px;"></div>
	<script>
		$("#id_po").select2({
			allowClear: true
		});
	</script>';
}
//--------------------------------------------
?>