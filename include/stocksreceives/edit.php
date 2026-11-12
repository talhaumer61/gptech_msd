<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['grn'])) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) { 
	
	$conditions = array ( 
							  'select' 		=> '*'
							, 'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id = ".STOCK.".reference_no 
												INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor"
							, 'where' 		=> array( 
														''.STOCK.'.grn_id' 	=> cleanvars($_GET['grn']) 
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $rowstdpro 	= $dblms->getRows(STOCK, $conditions);
	$orderdate 	= new DateTime($rowstdpro['grn_date']); 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="stocksreceives.php" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="grn_no"" name="grn_no"" value="'.$rowstdpro['grn_id'].'">
<input type="hidden" id="id_vendor"" name="id_vendor" value="'.$rowstdpro['vendor_id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'stocksreceives.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Edit Goods Received Note </h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">GRN</label>
			<input type="text" class="form-control" id="grn" name="grn" required value="'.$rowstdpro['grn'].'" readonly  autocomplete="off">
		</div> 
	</div>

	
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">GRN Date</label>
				<input type="text" class="form-control pickadate" id="grn_date" name="grn_date" required value="'.$rowstdpro['grn_date'].'"   autocomplete="off">
			</div> 
		</div>
	
	
	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Vendor</label>
			<input type="text" class="form-control" id="vendor_name" name="vendor_name" required value="'.$rowstdpro['vendor_name'].' - '.$rowstdpro['vendor_cellno'].'" readonly  autocomplete="off">
		</div> 
	</div>

	<div id="getVendorOrders">
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Vendor Orders</label>
				<input type="text" class="form-control" id="po_order_no" name="po_order_no" required value="'.$rowstdpro['po_order_no'].'" readonly  autocomplete="off">
			</div> 
		</div>
	</div>
	
	<div style="clear:both; padding:5px;"></div>';
//--------------------------------------------
	//--------------------------------------------
	$stockconditions = array ( 
								  'select' 		=> '*'
								, 'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCK.".id_item"
								, 'where' 		=> array( 
														  ''.STOCK.'.grn_id' 			=> cleanvars($_GET['grn'])
														, ''.STOCK.'.reference_type' 	=> 1 
														, ''.STOCK.'.stock_type' 		=> 1 
													)
								, 'order_by' 	=> ''.STOCK.'.id ASC '
								, 'return_type' => 'all' 
							); 
    $Stocks 	= $dblms->getRows(STOCK, $stockconditions);
//------------------------------------------------

	if(!empty($Stocks)) {
echo '
	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. # </th>
				<th style="text-align:center;">Item Code </th>
				<th style="text-align:left;">Item Name </th>
				<th style="text-align:center;">QTY Receive</th>
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Unit Total</th>
			</tr>
		</thead>
		<tbody>';
		$sr = 0;
		$sij = 0;
		$granTotal = 0;
		foreach($Stocks as $valueItem) {

	
		$sr++;
			echo'
			<input type="hidden" id="id_item['.$sr.']"" name="id_item['.$sr.']"" value="'.$valueItem['item_id'].'">
			
			<tr class="inv_row">
				<td style="text-align:center; width:50px;">'.$sr.'</td>
				<td style="text-align:center; width:80px;">'.$valueItem['item_code'].'</td>
				<td>'.$valueItem['item_name'].'</td>

				<td style="width:110px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_receive" id="qty['.$sr.']" name="qty['.$sr.']" min="1" autocomplete="off" value="'.cleanvars($valueItem['qty']).'" style="text-align:center; font-weight:600; font-size:14px !important; color:#00f;">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_unitprice" id="unitprice" name="unitprice" value="'.$valueItem['unitprice'].'" style="text-align:center; font-weight:600; font-size:14px !important; color:#f00;" readonly  autocomplete="off">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_unittotal" id="unittotal" name="unittotal" value="'.($valueItem['unitprice'] *$valueItem['qty']).'" style="text-align:center; font-weight:600; font-size:14px !important; color:#f00;" readonly  autocomplete="off">
				</td>
			</tr>
			<input type="hidden" id="id_edit['.$sr.']" name="id_edit['.$sr.']" value="'.cleanvars($valueItem['id']).'">';
			$granTotal = ($granTotal + ($valueItem['unitprice'] *$valueItem['qty']));
}
		
		echo'
		<tr class="last_row">
			<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
				<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$granTotal.'</span></span></b></p>
				<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$granTotal.'">
			</td>
		</tr>
		</tbody>	
	</table>

	<div style="clear:both;padding:5px;"></div>';
	}

echo '

	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'stocksreceives.php\'">Close</button>
		<input class="btn btn-primary" type="submit" value=" Save Changes " id="stock_update" name="stock_update" onClick=\'return confirmSubmit()\'>
	</button>
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

<script>


	$("#id_vendor").select2({
        allowClear: true
    });
	$("#vendor_order").select2({
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
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}