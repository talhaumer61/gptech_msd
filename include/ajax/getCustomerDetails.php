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
$sqllmscustomer  = $dblms->querylms("SELECT customer_name,customer_cellno,customer_email FROM ".CUSTOMERS." 
                                        WHERE customer_id = '".cleanvars($id_customer)."' ");
	$valuecustomer 	= mysqli_fetch_assoc($sqllmscustomer);
//------------------------------------------------
echo '
<div class="col-sm-61">
    <div class="form_sep">
        <label class="req">Customer Name</label>
		<input type="text" class="form-control" id="customer_name" readonly name="customer_name" value="'.$valuecustomer['customer_name'].'" autocomplete="off" required>
        
    </div> 
</div>
<div class="col-sm-61">
    <div class="form_sep">
        <label class="req">Customer Phone</label>
		<input type="text" class="form-control" id="customer_cellno" readonly name="customer_cellno" value="'.$valuecustomer['customer_cellno'].'" autocomplete="off" required>
        
    </div> 
</div>
<div class="col-sm-61">
    <div class="form_sep">
        <label class="req">Customer Email</label>
		<input type="text" class="form-control" id="customer_email" readonly name="customer_email" value="'.$valuecustomer['customer_email'].'" autocomplete="off" required>
        
    </div> 
</div>
<div class="col-sm-61">
    <div class="form_sep">
        <label class="req">Balance</label>
		<input type="text" class="form-control" id="customer_balance" readonly name="customer_balance" value="-" autocomplete="off" required>
        
    </div> 
</div>

';
//--------------------------------------------

?>
<!--JS_SELECT_LISTS-->
