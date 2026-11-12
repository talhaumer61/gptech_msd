<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'add' => '1'))) { 

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'stockstaking.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Stock Taking Details</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Taking #</label>
			<input type="text" class="form-control" id="st_no" name="st_no" required value="ST-'.mt_rand(100000,999999).'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="taking_date" value="'.date('Y-m-d').'" name="taking_date" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Taking Type</label>
			<select id="taking_type" name="taking_type" style="width:100%" autocomplete="off" required onchange="get_stockTakingtype(this.value)">
				<option value="">Select</option>';
				foreach($stocktaking as $listtaking) {  				
					echo '<option value="'.$listtaking['id'].'">'.$listtaking['name'].'</option>';
				
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both; padding:5px;"></div>
	
		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label class="req"> Taking By</label>
				<input type="text" class="form-control" id="taking_by" name="taking_by" required autocomplete="off">
			</div> 
		</div>

		<div style="clear:both; padding:5px;"></div>
		<div class="col-sm-100">
			<div class="form_sep">
				<label> Remarks</label>
				<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off">
			</div> 
		</div>



		<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Stocks Taking Details
	</div>
<div id="getstockTakingtype">



</div>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'stockstaking.php\'">Closed</button>
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
	
	$("#taking_type").select2({
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