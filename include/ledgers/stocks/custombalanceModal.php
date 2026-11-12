<?php 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '9', 'add' => '1'))) {

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="CustomBalanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="stockreportprint.php" method="post" id="BalanceModelform" enctype="multipart/form-data" target="_blank">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Stock Balance Report</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Date</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="fromdate" name="fromdate" autocomplete="off" required>
		</div>
	</div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Balance Report" id="submit_report" name="submit_report">
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
	$("#BalanceModelform").validate({
		rules: {
             id_vendor			: "required",
			 balance_opening	: "required"
		},
		messages: {
			id_vendor		: "This field is required",
			balance_opening	: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}