<?php
//-------------------------------------
    error_reporting(0);
    //session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	$id_po = $_POST['id_po']; 
//-------------------------------------
    $sqllmsPO =  $dblms->querylms("SELECT * FROM ".PURCHASE_ORDER." WHERE purchase_order_id = '".cleanvars($id_po)."' ");
    $valuePO = mysqli_fetch_assoc($sqllmsPO);
//-------------------------------------
    $sqllmsctop	= $dblms->querylms("SELECT company_id, 
                                        company_name, company_code  
                                        FROM ".COMPANY." 
                                        WHERE company_id != '0' ORDER BY company_name ASC");
    $companyarray = array();
    while($valuectop 	= mysqli_fetch_array($sqllmsctop)) { 
        $companyarray[] = $valuectop;
    }
//-------------------------------------
echo'
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Company</label>
			<select id="id_company" class="id_item" name="id_company" readonly style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($companyarray as $itemcompany) {
                    if($valuePO['id_company'] == $itemcompany['company_id']){
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
					echo '<option value="'.$itemcompany['company_id'].'" '.$selected.'>'.$itemcompany['company_code'].'-'.$itemcompany['company_name'].'</option>';
				}
			echo '
			</select>
		</div> 
	</div>
	
    
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Total</label>
			<input type="text" class="form-control" id="total" readonly name="total" value="'.$valuePO['total'].'"  required autocomplete="off">

		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Order Date</label>
			<input type="text" class="form-control" id="po_dated" readonly name="po_dated" value="'.$valuePO['dated'].'"  required autocomplete="off">

		</div> 
	</div>
	<div style="clear:both; padding:5px;"></div>
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
	        $sqllmsdet  = $dblms->querylms("SELECT * FROM ".PURCHASE_ORDER_DETAILS."   
                                                WHERE id_po = '".cleanvars($id_po)."'");

        ///----------------------------------------------
        $i=0;
        $Gtotal = 0;
		///----------------------------------------------
        while ($rowsdet = mysqli_fetch_assoc($sqllmsdet)) {
            $i++;
            $Gtotal = $Gtotal + $rowsdet['total_price']; 
		echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:20px;"><span class="footable-toggle"></span>'.$i.'</td>
				<td style="width:200px;">
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"   autocomplete="off" onchange="getPrdValue(this.value, '.$i.')">
						<option value=""></option>';
						foreach($arrayitems as $arrayitem) {
							if($arrayitem['item_id'] == $rowsdet['id_item']){
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '
							<option value="'.$arrayitem['item_id'].'" '.$selected.'>
								'.$arrayitem['item_name'].'
							</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:85px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="qty['.$i.']" id="qty_'.$i.'" value="'.$rowsdet['qty'].'">
				</td>
				
				<td style="width:85px;">
					<div id="getPrdValue_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$i.']" id="unit_price_'.$i.'" value="'.$rowsdet['unit_price'].'">
					</div>		
					
				</td>
				<td style="width:130px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" value="'.$rowsdet['total_price'].'" style="text-align:right;">
				</td>
			</tr>';	
		}
	echo'
	<tr class="last_row">
		<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
			<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span>'.$Gtotal.'</span></span></b></p>
			<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$Gtotal.'">
		</td>
	</tr>
	</tbody>	
	</table>

	<div style="clear:both;"></div>

    <script>
    $(".id_item").select2({
        allowClear: true
    });
   
    </script>

';

//-------------------------------------

?>