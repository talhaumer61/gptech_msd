<?php 
//------------------------------------------------
if(!isset($_GET['id']) && LMS_VIEW == 'add')  { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '1', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'salereturns.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Add Sales Return Detail</h4>
</div>

<div class="modal-body">';
//------------------------------------------------
	$sqllmslstorder  = $dblms->querylms("SELECT job_order_id FROM ".SALES_RETURNS."   
										WHERE job_order_id != '0'  
										ORDER BY job_order_id DESC LIMIT 1");
	$valuelstorder 	= mysqli_fetch_assoc($sqllmslstorder);
//------------------------------------------------
echo '
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Job Order #</label>
			<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="'.($valuelstorder['job_order_id'] + 1).'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated" name="dated" required value="'.date("Y-m-d").'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<select id="id_customer" name="id_customer" onchange="get_retruncustomerdetail(this.value)" style="width:100%" required autocomplete="off">
					<option value="">Choose Customer</option>';
			
		
				foreach($arraycustomers as $listcusts) { 
					echo '<option value="'.$listcusts['customer_id'].'">'.$listcusts['customer_name'].' - '.$listcusts['customer_cellno'].'</option>';
				}
				echo'
				</select>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>

	<div id="getretruncustomerdetail">

		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Name</label>
				<input type="text" class="form-control" id="ade_name" name="ade_name" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Phone #</label>
				<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Opening Balance</label>
				<input type="text" class="form-control" id="customer_openingbalance" name="customer_openingbalance" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Company Name</label>
				<input type="text" class="form-control" id="id_company" name="id_company" required readonly>
			</div> 
		</div>

		<div style="clear:both;padding:5px;"></div>
	
	</div>

	

</div>

<div class="modal-footer">
	<!--<button type="submit" class="btn btn-primary" value="savecomplete" id="submit_order" name="submit_order">Save &amp; Send to Sales Department</button>-->
	<button type="submit" class="btn btn-warning" value="savehold" id="submit_order" name="submit_order">Save Record</button>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'salereturns.php\'">Closed</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->
<script src="js/salesreturn.js"></script>
<script>
	$("#id_customer").select2({
        allowClear: true
    });
	
</script>

<script>
	function getReturnPrdValue(id_item, id_customer, srno) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getReturnPrdValue.php",  
			data: "id_item="+id_item+"&id_customer="+id_customer+"&srno="+srno,  
			success: function(msg){  
				$("#getReturnPrdValue_"+srno).html(msg); 
			}
		});  
	}
</script>';

}
}