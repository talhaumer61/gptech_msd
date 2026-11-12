<?php 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Job Order</h4>
</div>

<div class="modal-body">	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Job #</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="order_no_edit" name="order_no_edit" readonly autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="status_edit" name="status_edit" style="width:100%" required autocomplete="off">
				<option value="">Select Status</option>';
			foreach($orders as $itemorders) {
				if($itemorders['id'] == 4 || $itemorders['id'] == 6) { 
					echo '<option value="'.$itemorders['id'].'">'.$itemorders['name'].'</option>';
				}
			}
	echo'
			</select>
		</div>
	</div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="order_id_edit" name="order_id_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_statuschanges" name="submit_statuschanges">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var status_edit 				= $(this).attr("data-com-status");
        var order_no_edit 				= $(this).attr("data-com-ordno");
		var order_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#order_no_edit")				.val(order_no_edit);
		$("#order_id_edit")				.val(order_id_edit);

       //pre-select data in pull down lists
       $("#status_edit")				.select2().select2("val", status_edit);  
  });
    
});
</script>';