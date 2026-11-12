<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	include "../../functions/db_functions.php";
//--------------------------------------------
if(isset($_POST['id_user'])) { 
	$mainclass	= new main();
	$Paycats 	= $mainclass->get_paymentcategory();
	
	$Invconditions = array ( 
								'select' 	=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, '.SALES_INVOICE.'.grand_total,
												'.SALES_INVOICE.'.paid, '.SALES_INVOICE.'.balance, '.SALES_INVOICE.'.dated, '.SALES_INVOICE.'.total, 
												'.SALES_INVOICE.'.prev_balance, '.SALES_INVOICE.'.salesinvoice_status ',
								'join' 		=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' => array( 
													''.SALES_INVOICE.'.id_customer' => cleanvars($_POST['id_user'])
												), 
								'order_by' 		=> " ".SALES_INVOICE.".salesinvoice_id DESC",
								'return_type' 	=> 'all' 
							); 
    $totalInvoices 	= $dblms->getRows(SALES_INVOICE, $Invconditions);
	
	
	// get Credit & Debit Payments of Customer

	$debitcreditconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
								'where' 	=> array( 
													''.PAYMENTS.'.status' 	=> 1, 
													''.PAYMENTS.'.id_user' 	=> cleanvars($_POST['id_user']) 
												), 								
								'return_type' 	=> 'single' 
							); 
    $valuecrditdebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);	
	$openingbalance 	= ($valuecrditdebit['TotalDebit'] - $valuecrditdebit['TotalCredit']);
//--------------------------------------------
echo ' 
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Payable (Balance)</label>
			<input type="text" class="form-control" id="payable" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" name="payable" value="'.number_format($openingbalance).'" autocomplete="off" readonly>
		</div> 
	</div>
	<div style="clear:both;"></div>
	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">Payment Details</div>';
	if(empty($totalInvoices)) {
		echo '<h2 style="color:#f00; font-weight:600; text-align:center;">No invoice exists</h2>';
	} else {

	echo '
	<table class="footable table table-bordered table-hover footable-loaded">
	<thead>
		<tr>
			<th style="text-align:center;">Sr #</th>
			<th style="text-align:left;">Invoice # </th>
			<th style="text-align:center;">Amount</th>
			<th style="text-align:center;">Payment Category</th>
			<th style="text-align:center;">Remarks</th>
		</tr>
	</thead>
	<tbody>';
		$srinv = 0;
		foreach($totalInvoices as $rowInvoice) {
			$srinv++;
			echo '
				<tr>
					<td style="width:50px; text-align:center;vertical-align: middle;">'.$srinv.'</td>
					<td style="width:120px;vertical-align: middle;">
					<a class="iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Invoice Detail</b>" data-src="saleinvoicview.php?id='.$rowInvoice['salesinvoice_id'].'" href="#" style="font-weight:600; color:#00f;">
					'.$rowInvoice['salesinvoice_no'].'</a></td>
					<td style="width:150px;"><input type="text" class="form-control txtpay" id="amount[]" name="amount[]" value="" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></td>
					<td style="width:250px;">
					<select id="id_cat'.$srinv.'" name="id_cat[]" class="id_cat" style="width:100%" autocomplete="off" required >
						<option value="">Select Category</option>';
					foreach($Paycats as $listcat) {
						echo '<option value="'.$listcat['cat_id'].'">'.$listcat['cat_name'].'</option>';
					}
			echo '
					</select>
					
					</td>
					<td><input type="text" class="form-control" id="remarks[]" name="remarks[]" autocomplete="off"></td>
					<input type="hidden" id="id_invoice[]" name="id_invoice[]" value="'.$rowInvoice['salesinvoice_id'].'">
				</tr>';
		}
	echo  '
	</tbody>
	<thead>
		<tr>
			<th style="text-align:center;"></th>
			<th style="text-align:left;"></th>
			<th style="text-align:center;">
				<input type="text" class="form-control" id="grand_total" name="grand_total" autocomplete="off"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readonly></th>
			<th style="text-align:center;"></th>
			<th style="text-align:center;"></th>
		</tr>
	</thead>
	</table>
		<div style="clear:both;"></div>
		<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:10px; font-weight:600;">Payment Schedule</div>
	<div class="col-sm-81">
		<div class="form_sep">
			<label>No of Installments</label>
			<select id="installments" name="installments" style="width:100%" autocomplete="off"  onchange="get_installments(this.value)">
				<option value="">Select </option>';
				for($inum = 1; $inum<=50; $inum++) { 
					echo '<option value="'.$inum.'">'.$inum.'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both; margin-top:20px; margin-bottom:20px;"></div>
	<div id="getinstallments">
	</div>';
}
}
//--------------------------------------------
?>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script>
 $(".id_cat").select2({
        allowClear: true
    });
	$("#installments").select2({
        allowClear: true
    });
	
//--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSum();

    $(".txtpay").on("keydown keyup", function() {
        calculateSum();
    });
});

function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txtpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#grand_total").val(sum.toFixed(0));	
}
//--Deduction Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculatedeductionSum();

    $(".txtdedpay").on("keydown keyup", function() {
        calculatedeductionSum();
    });
});

function calculatedeductionSum() {
    var sum1 = 0;
    //iterate through each textboxes and add the values
    $(".txtdedpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum1 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_paids").val(sum1.toFixed(0));
}
//--Net Salary-->
$(document).ready(function() {
    //this calculates values automatically 
   
  
$(".balance").on("keydown keyup", function() {
    var gross= document.getElementById("grand_total").value; 
	var deduction= document.getElementById("total_paids").value;
	 $('#balance').val(gross - deduction);

})
    
});



//--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSumedit();

    $(".txtpay").on("keydown keyup", function() {
        calculateSumedit();
    });
});

function calculateSumedit() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txtpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_amount_edit").val(sum.toFixed(0));	
}
//--Deduction Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculatedeductionSumedit();

    $(".txtdedpay").on("keydown keyup", function() {
        calculatedeductionSumedit();
    });
});

function calculatedeductionSumedit() {
    var sum1 = 0;
    //iterate through each textboxes and add the values
    $(".txtdedpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum1 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_paids").val(sum1.toFixed(0));
}
//-Net Salary-->
$(document).ready(function() {
    //this calculates values automatically 
   
  
$(".balance").on("keydown keyup", function() {
    var gross= document.getElementById("total_amount_edit").value; 
	var deduction= document.getElementById("total_paids").value;
	 $('#balance').val(gross - deduction);

})
    
});

</script>
