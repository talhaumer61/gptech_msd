<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '36', 'add' => '1'))) { 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="vendorsjv.php" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'vendorsjv.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Journal Vouchers</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Order #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="JV-'.mt_rand(100000,999999).'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.date('Y-m-d').'" name="dated" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-100">
		<div class="form_sep">
			<label> Detail</label>
			<input type="text" class="form-control" id="jv_details" name="jv_details" autocomplete="off">
		</div> 
	</div>

<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. #</th>
				<th style="text-align:left;">Vendor </th>
				<th style="text-align:center;">Credit</th>
				<th style="text-align:center; width:120px;">Debit</th>
				<th style="text-align:left; width:120px;">Remarks</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
		for ($i=1; $i <= 10; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_customer['.$i.']" id="id_customer_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off">
						<option value=""></option>';
						foreach($Customers as $arrayitem) {
							echo '<option value="'.$arrayitem['vendor_id'].'"> '.$arrayitem['vendor_name'].' ('.$arrayitem['vendor_cellno'].')</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_credit" style="color:#00f; font-weight:600; text-align:center;" name="amout_credit['.$i.']" id="amout_credit_'.$i.'"  autocomplete="off" >
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_debit" style="color:#00f; font-weight:600; text-align:center;" name="amout_debit['.$i.']" id="amout_debit_'.$i.'"  autocomplete="off" >
				</td>
				<td style="width:250px;">
					<input type="text" class="form-control col-lg-12" name="detail['.$i.']" id="detail_'.$i.'"  autocomplete="off" >
				</td>
				
			</tr>';	
		}
echo '
</tbody>
	<thead>
			<tr class="last_row">
				<th style="text-align:center;"></th>
				<th style="text-align:left;"> </th>
				<th style="text-align:center;"><input type="text" class="form-control" id="inV_grandcreditTotal" name="inV_grandcreditTotal" value="0.00" readonly></th>
				<th style="text-align:center; width:120px;"><input type="text" class="form-control"  id="inV_granddebitTotal" name="inV_granddebitTotal" value="0.00" readonly></th>
				<th style="text-align:left; width:120px;"></th>
			</tr>
		</thead>
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'vendorsjv.php\'">Closed</button>
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
	
	$("#id_type").select2({
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