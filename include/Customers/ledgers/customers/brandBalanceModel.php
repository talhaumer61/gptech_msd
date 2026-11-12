<?php 


echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="BrandBalanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="brandledgerprint.php" method="post" id="Brandform" enctype="multipart/form-data" target="_blank">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Brand Ledger Report</h4>
</div>

<div class="modal-body">

	
	
	<div class="form-group" style="margin-bottom:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Brand Name</b></label>
		<div class="col-lg-12">
		
			<select id="idbrand" name="id_brand" style="width:100%" autocomplete="off" required >
				<option value="">Select Brand</option>';
				foreach($brandnames as $listbrand) { 
					echo '<option value="'.$listbrand['id'].'">'.$listbrand['name'].'</option>';
				}
	echo'
			</select>

		</div>
	</div>
	
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Generate Report" id="submit_brand" name="submit_brand">
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
	$("#Brandform").validate({
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
