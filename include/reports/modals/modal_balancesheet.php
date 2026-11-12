<?php 
//--------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="balancesheetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customerbalanceprint.php" method="post" target="_blank" id="FormBalancesheet" name="FormBalancesheet" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;"> Brand wise Balance Sheet Detail Report</h4>
</div>

<div class="modal-body"> 
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Dated</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="fromdate" value="'.date("Y-m-d").'" name="fromdate" required autocomplete="off">
		</div>
	</div>
	
	
	<div style="clear:both;margin:10px;"></div>

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

<script type="text/javascript">
$().ready(function() {
	$("#FormBalancesheet").validate({
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
