<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	$id_customer = $_POST['id_customer']; 
//--------------------------------------------
	$sqllmslstorder  = $dblms->querylms("SELECT dated FROM ".SALES_INVOICE."   
										WHERE id_customer =  '".cleanvars($id_customer)."' ORDER BY dated ASC LIMIT 1");
	$valuelstorder 	= mysqli_fetch_assoc($sqllmslstorder);
//------------------------------------------------
echo '
<div class="form-group" style="margin-bottom:10px;">
	<label class="control-label req col-lg-12" style="width:150px;"> <b>From Date</b></label>
	<div class="col-lg-12">
		<input type="text" class="form-control pickadate" id="fromdate" name="fromdate" value="'.$valuelstorder['dated'].'1245" autocomplete="off" required>
	</div>
</div>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>';
//--------------------------------------------