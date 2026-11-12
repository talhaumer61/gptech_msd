<?php 
//--------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="companywiseSalesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="reportitems.php" method="post" target="_blank" id="FormcompanywiseSales" name="FormcompanywiseSales" enctype="multipart/form-data">
<input type="hidden" id="reptype" name="reptype" value="companywisesales">
<input type="hidden" id="repview" name="repview" value="summary">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;"> Company Wise Items Sale Report</h4>
</div>

<div class="modal-body"> 
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Date From</label>
			<input type="text" class="form-control pickadate" id="datefrom" value="'.date("Y-m-d").'" name="datefrom" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Date To</label>
			<input type="text" class="form-control pickadate" id="dateto" value="'.date("Y-m-d").'" name="dateto" required autocomplete="off">
		</div> 
	</div>
	
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Order By</label>
			<select class="select2" id="orderby" name="orderby" style="width:100%"  required autocomplete="off">
					<option value="DESC">Highest Sale</option>
					<option value="ASC">Lowest Sale</option>
			</select>
		</div> 
	</div>
	
	<div style="clear:both;margin:10px;"></div>
	
	<div class="form-group"  style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Items</b></label>
		<div class="col-lg-12">
			<select class="select2" id="iditem" name="iditem[]" style="width:100%" multiple  required autocomplete="off">
					<option value="all">All</option>';
				foreach($Items as $listitem) {
					echo '<option value="'.$listitem['item_id'].'">'.$listitem['item_code'].' - '.$listitem['item_name'].'</option>';
				}
		echo '
			</select>
		</div>
	</div>
	
	<div style="clear:both;margin:30px;"></div>
	
	<div class="form-group" style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Zone</b></label>
		<div class="col-lg-12">
			<select class="select2" id="idcompany" name="idcompany[]" multiple style="width:100%" onchange="get_zonecustomers(this.value)"   required autocomplete="off">
					<option value="all">All</option>';
				foreach($Company as $listcompany) {
					echo '<option value="'.$listcompany['company_id'].'">'.$listcompany['company_name'].'</option>';
				}
		echo '
			</select>
		</div>
	</div>

	<div style="clear:both;margin:10px;"></div>

	<div class="form-group" style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Customer</b></label>
		<div class="col-lg-12" id="zonecustomers">
			<select class="select2" id="idcustomer" name="idcustomer" style="width:100%" required autocomplete="off">
				<option value="">Select Customer</option>
			</select>
		</div>
	</div>

	<div style="clear:both;margin:10px;"></div>
							
	<div class="form-group" style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Brand</b></label>
		<div class="col-lg-12">
			<select class="select2" id="idbrand" name="idbrand[]" multiple style="width:100%"  required autocomplete="off">
				<option value="all">All</option>';
				foreach($brandnames as $listbrand) {
					echo '<option value="'.$listbrand['id'].'">'.$listbrand['name'].'</option>';
				}
				echo '
			</select>
		</div>
	</div>
	
	
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
<script type="text/javascript">
$().ready(function() {
	$("#FormcompanywiseSales").validate({
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
