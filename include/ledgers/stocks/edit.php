<?php 
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '9', 'edit' => '1'))) {
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Opening Stock Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Item Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="item_name_edit" name="item_name_edit" readonly value="" autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated_edit" name="dated_edit" readonly required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Opening Stock</label>
			<input type="text" class="form-control" id="qty_edit" name="qty_edit" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Unit Price</label>
			<input type="text" class="form-control" id="unitprice_edit" name="unitprice_edit"  required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="stock_id_edit" name="stock_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_openingchanges" name="submit_openingchanges">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<!--JS_SELECT_LISTS-->
<script>
	$("#customer_status_edit").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_ade_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             company_name_edit		: "required",
			 company_status_edit	: "required"
		},
		messages: {
			company_name_edit		: "This field is required",
			company_status_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var stock_id_edit 		= $(this).attr("data-stock-id");
		var item_name_edit 		= $(this).attr("data-item-name");
		var unitprice_edit 		= $(this).attr("data-stock-unitprice");
		var qty_edit 			= $(this).attr("data-stock-qty");
		var dated_edit 			= $(this).attr("data-stock-dated");

        //set modal input values dynamically
		$("#item_name_edit") 		.val(item_name_edit) 
		$("#unitprice_edit") 		.val(unitprice_edit) 
		$("#qty_edit") 				.val(qty_edit) 
		$("#dated_edit") 			.val(dated_edit) 
		$("#stock_id_edit") 		.val(stock_id_edit) 

       //pre-select data in pull down lists
       $("#cat_status_edit")				.select2().select2("val", cat_status_edit);
  });
    
});
</script>';
}