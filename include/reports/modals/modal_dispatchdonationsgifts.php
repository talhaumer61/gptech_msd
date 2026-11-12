<?php 
//--------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="dispatchDonGiftsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="reportdispatches.php" method="post" target="_blank" id="FormDonGiftsDetail" name="FormDonGiftsDetail" enctype="multipart/form-data">
<input type="hidden" id="reptype" name="reptype" value="donationsgifts">
<input type="hidden" id="repview" name="repview" value="detail">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;">Donations / Gifts Dispatched Report</h4>
</div>

<div class="modal-body"> 
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Date From</label>
			<input type="text" class="form-control pickadate" id="datefrom" value="'.date("Y-m-d").'" name="datefrom" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Date To</label>
			<input type="text" class="form-control pickadate" id="dateto" value="'.date("Y-m-d").'" name="dateto" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;margin:10px;"></div>
	
<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Generate Report" id="submit_orders" name="submit_orders">
	</button>
</div>

</div>
</form>

</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
    $("#cgsdidbrand").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#FormDonGiftsDetail").validate({
		rules: {
             itemcat	: "required"	,
			 datefrom	: "required"	,
			 dateto		: "required"
		},
		messages: {
			itemcat		: "This field is required"	,
			datefrom	: "This field is required"	,
			dateto		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
