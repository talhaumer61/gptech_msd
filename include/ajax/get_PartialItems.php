<?php 
// get all Items

	$itemsconditions = array ( 
								'select' 		=> 'item_id, item_name, item_code',
								'where' 		=> array( 
															'item_status' => 1 
													), 
								'order_by' 		=> 'item_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Items = $dblms->getRows(ITEMS, $itemsconditions);
echo '
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
		for ($i=1; $i <= 15; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off" onchange="get_Itemstockdetail(this.value, '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td colspan="2">
				
					<div id="getItemstockdetail_'.$i.'">	
						<div class="col-sm-61" >
							<input type="text" class="form-control col-lg-12 jQinv_system_stock" name="system_stock['.$i.']" id="system_stock'.$i.'" style="color:orangered; font-weight:600; text-align:center;" readonly>
						</div>

						<div class="col-sm-61">
							<input type="text" class="form-control col-lg-12 jQinv_system_stockamount" name="system_stockamount['.$i.']" id="system_stockamount_'.$i.'" style="color:orangered; font-weight:600; text-align:center;" readonly>
						</div>
					</div>		
					
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stock" style="color:orangered; font-weight:600; text-align:center;" name="physically_stock['.$i.']" id="physically_stock_'.$i.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
				</td>
				<td style="width:150px;">
					<input type="text" class="form-control col-lg-12 jQinv_physically_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="physically_stockamount['.$i.']" id="physically_stockamount_'.$i.'" style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stock" style="color:orangered; font-weight:600; text-align:center;" name="difference_stock['.$i.']" id="difference_stock_'.$i.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_difference_stockamount" style="color:orangered; font-weight:600; text-align:center;" name="difference_stockamount['.$i.']" id="difference_stockamount_'.$i.'"  style="text-align:right;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
				</td>
			</tr>';	
		}
echo'
<tr class="last_row">
	<td></td>
	<td></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandSystemstock" name="inV_grandSystemstock" style="color:#00f; font-weight:600; text-align:center;" readonly value="0.00"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandSystemsamts" name="inV_grandSystemsamts" style="color:#00f; font-weight:600; text-align:right;" readonly value="0.00"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandPhysicalstock" name="inV_grandPhysicalstock" style="color:darkorange; font-weight:600; text-align:center;" readonly value="0.00"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandPhysicaltotal" name="inV_grandPhysicaltotal" style="color:darkorange; font-weight:600; text-align:right;" readonly value="0.00"></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandDifferqty" name="inV_grandDifferqty" readonly value="0.00" style="color:#f00; font-weight:600; text-align:center;" ></td>
	<td><input type="text" class="form-control col-lg-12" id="inV_grandDifferamts" name="inV_grandDifferamts" readonly value="0.00" style="color:#f00; font-weight:600; text-align:center;" ></td>
</tr>
</tbody>	
</table>
<script>
    $(".select2").select2({
        allowClear: true
    });
    
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#taking_type").select2({
        allowClear: true
    });
	
</script>';