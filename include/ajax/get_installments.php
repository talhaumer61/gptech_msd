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
if(isset($_POST['inst'])) { 

	echo '
	<div style="clear:both; margin-top:20px; margin-bottom:20px;"></div>
	<table class="footable table table-bordered table-hover footable-loaded">
	<thead>
		<tr>
			<th style="text-align:center;">Sr #</th>
			<th style="text-align:center;">Amount</th>
			<th style="text-align:center;">Dated</th>
			<th style="text-align:center;">Remarks</th>
		</tr>
	</thead>
	<tbody>';
		$srinv = 0;
		for($inum = 1; $inum<=$_POST['inst']; $inum++) { 
			$srinv++;
			echo '
				<tr>
					<td style="width:50px; text-align:center;vertical-align: middle;">'.$inum.'</td>
					<td style="width:150px;"><input type="text" class="form-control txtinstpay" id="intamount['.$inum.']" name="intamount['.$inum.']" value="" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></td>
					<td style="width:250px;">
					<input type="date" class="form-control" id="intdated['.$inum.']" name="intdated['.$inum.']" value="" autocomplete="off"></td>
					<td><input type="text" class="form-control" id="intremarks['.$inum.']" name="intremarks['.$inum.']" autocomplete="off"></td>
				</tr>';
		}
	echo  '
	</tbody>
	<thead>
		<tr>
			<th style="text-align:center;"></th>
			<th style="text-align:center;">
				<input type="text" class="form-control" id="grand_insttotal" name="grand_insttotal" autocomplete="off" readonly></th>
			<th style="text-align:center;"></th>
			<th style="text-align:center;"></th>
		</tr>
	</thead>
	</table>
		<div style="clear:both;"></div>';

}
//--------------------------------------------
?>
<script>
//--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSumint();

    $(".txtinstpay").on("keydown keyup", function() {
        calculateSumint();
    });
});

function calculateSumint() {
    var suminst = 0;
    //iterate through each textboxes and add the values
    $(".txtinstpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            suminst += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#grand_insttotal").val(suminst.toFixed(0));	
}


</script>
