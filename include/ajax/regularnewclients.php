<?php 
error_reporting(0);
//--------------------------------------------
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['job_for'])) {
	$clienttype = $_GET['job_for']; 
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
if($clienttype == 1) { 

//--------------------------------------------
echo ' 
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<select id="id_customer" name="id_customer" style="width:100%" required autocomplete="off">
				<option value="">Choose Customer</option>';
			  $sqllmsloc	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
														FROM ".CUSTOMERS." 
														WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
														AND customer_status = '1' ORDER BY customer_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) { 
					echo '<option value="'.$valueloc['customer_id'].'">'.$valueloc['customer_name'].' - '.$valueloc['customer_cellno'].'</option>';
				}
			echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px; ">
			<label class="req">Designer</label><br>
			<input type="text" class="form-control" id="designer" name="designer" value="'.$_SESSION['userlogininfo']['LOGINNAME'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px; ">
			<label>Advance Payment</label>
			<input type="number" class="form-control" id="order_advance" name="order_advance" autocomplete="off">
		</div> 
	</div>';
//--------------------------------------------
} else if($clienttype == 2) { 
//--------------------------------------------
echo '<div style="clear:both;"></div>	

		<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px; margin-bottom:5px;">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customer_name" name="customer_name" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label class="req">Cell #</label>
			<input type="text" class="form-control" id="customer_cellno" name="customer_cellno" required autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label>TRN #</label>
			<input type="text" class="form-control" id="customer_trn" name="customer_trn" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="customer_email" name="customer_email" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Address</label>
			<input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px; ">
			<label class="req">Designer</label><br>
			<input type="text" class="form-control" id="designer" name="designer" value="'.$_SESSION['userlogininfo']['LOGINNAME'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-32" style="margin-top:5px; ">
		<div class="form_sep">
			<label>Advance Payment</label>
			<input type="number" class="form-control" id="order_advance" name="order_advance" autocomplete="off">
		</div> 
	</div>


	<div style="clear:both;"></div>';
//--------------------------------------------
}
//--------------------------------------------
}
//--------------------------------------------
?>
<!--JS_SELECT_LISTS-->
<script>
	$("#id_customer").select2({
		allowClear: true
	});

</script>

<script type="text/javascript" src="../../js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
      $("#customer_cnic").mask("99999-9999999-9");
	  $("#customer_cellno").mask("0399-9999999");

        });
</script>