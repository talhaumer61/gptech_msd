<?php 
// get all Items

		$stockconditions = array ( 
								'select' 	=> "".ITEMS.".item_id, ".ITEMS.".item_name, ".ITEMS.".item_code, ".ITEMS.".item_pricepurchase, ".ITEMS.".item_classes, 
												SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as totalStockIn, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as totalStockOUT ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'where' 	=> array( 
													''.ITEMS.'.item_status' 	=> '1',
												),
								'not_equal' => array( 
													''.STOCK.'.id' 	=> 0 
												), 
								'group_by' 		=> ''.STOCK.'.id_item',
								'order_by' => "CASE
													WHEN ".ITEMS.".item_classes IS NULL
														OR TRIM(".ITEMS.".item_classes) = ''
													THEN 1
													ELSE 0
												END ASC,
												CAST(SUBSTRING_INDEX(TRIM(".ITEMS.".item_classes), ',', 1) AS UNSIGNED) ASC,
												".ITEMS.".item_code ASC",
								'return_type' 	=> 'all' 
							); 
		$Stock 	= $dblms->getRows(STOCK, $stockconditions);	


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
			$i = 0;
		foreach($Stock as $arrayitem) {
			$i++;
			

			$avaiablestock 		= ($arrayitem['totalStockIn'] - $arrayitem['totalStockOUT']);
			
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].' </td>
				<td colspan="2">
					<div class="col-sm-61" >
						<input type="text" class="form-control col-lg-12 jQinv_system_stock" name="system_stock['.$i.']" id="stock_qty'.$i.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.$avaiablestock.'">
					</div>
					<div class="col-sm-61">
						<input type="text" class="form-control col-lg-12 jQinv_system_stockamount" name="system_stockamount['.$i.']" id="system_stockamount_'.$i.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.($avaiablestock * $arrayitem['item_pricepurchase']).'">
					</div>	
					<input type="hidden" name="id_item['.$i.']" id="id_item_'.$i.'" value="'.$arrayitem['item_id'].'">
					<input type="hidden" class="jQinv_sale_price" name="sale_price['.$i.']" id="sale_price_'.$i.'" value="'.$arrayitem['item_pricepurchase'].'">
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