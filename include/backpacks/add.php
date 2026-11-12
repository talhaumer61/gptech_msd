<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'add' => '1'))) { 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="backpacks.php" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'backpacks.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Sale Backpack</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-25">
		<div class="form_sep">
			<label class="req">Backpack #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="BPK-'.mt_rand(100000,999999).'" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Backpack Name</label>
			<input type="text" class="form-control" id="package_name" name="package_name" required value="" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-25">
		<div class="form_sep">
			<label class="req">Class</label>
			<select id="id_class" name="id_class" class="select2" style="width:100%" autocomplete="off" required >
				<option value="">Select</option>';
				foreach($classnames as $listclass) {  
					echo '<option value="'.$listclass['id'].'">'.$listclass['name'].'</option>';
					
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Brand</label>
			<select id="id_brand" name="id_brand" class="select2" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($brandnames as $listbrand) {
				echo '<option value="'.$listbrand['id'].'">'.$listbrand['name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	
	<div style="clear:both; padding:5px;"></div>

		<div class="col-sm-100">
			<div class="form_sep">
				<label> Backpack Detail</label>
				<input type="text" class="form-control" id="package_detail" name="package_detail" autocomplete="off">
			</div> 
		</div>

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
				<th style="text-align:center;">Unit Total</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
		for ($i=1; $i <= 20; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:60px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off" onchange="get_itempricee(this.value, '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:150px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="qty['.$i.']" id="qty_'.$i.'"  autocomplete="off" '.$required.' >
				</td>
				<td style="width:130px;">
					<div id="getitempricee_'.$i.'">
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
		<p class="clearfix"><b> Estimated Package Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'backpacks.php\'">Closed</button>
		<input class="btn btn-primary" type="submit" value=" Add Record " id="submit_purchase_order" name="submit_purchase_order" onClick=\'return confirmSubmit()\'>
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->

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
    $(".select2").select2({
        allowClear: true
    });
    
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#idclass").select2({
        allowClear: true
    });

	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#inv_form").validate({
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
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}