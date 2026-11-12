<?php 
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '9', 'add' => '1'))) {

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addStockModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="stockledger.php" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Stock Details</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Item Name</label>
			<select id="id_item" name="id_item" style="width:100%" autocomplete="off" required >
				<option value="">Select Item</option>';
				foreach($Items as $listitem) {  
					echo '<option value="'.$listitem['item_id'].'">'.$listitem['item_code'].' - '.$listitem['item_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Opening Stock</label>
			<input type="number" class="form-control" id="stock_opening" name="stock_opening" autocomplete="off" required>
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Stock" id="submit_stock" name="submit_stock">
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
	$("#addNewCountry").validate({
		rules: {
             id_item	: "required",
			 stock_opening		: "required"
		},
		messages: {
			id_item		: "This field is required",
			stock_opening		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}