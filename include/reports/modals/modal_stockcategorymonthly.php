<?php 
//--------------------------------------------

echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="stockAgingmonthModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="reportstocks.php" method="post" target="_blank" id="Formstockagingmonth" name="Formstockagingmonth" enctype="multipart/form-data">
<input type="hidden" id="reptype" name="reptype" value="stockagingcategorymonthly">
<input type="hidden" id="repview" name="repview" value="summary">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h4 class="modal-title" style="font-weight:700;">Category Wise Stock Aging (Mothly) Report</h4>
</div>

<div class="modal-body"> 

	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Month From </label>
			<input type="text" class="form-control pickamonth" id="monthfrom" value="'.date("Y-m").'" name="monthfrom" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Month To </label>
			<input type="text" class="form-control pickamonth" id="monthto" value="'.date("Y-m").'" name="monthto" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;margin:10px;"></div>
	
	<div class="form-group" style="margin-bottom:10px; margin-top:20px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Item Category</b></label>
		<div class="col-lg-12">
			<select id="mcageitemcat" name="itemcat" style="width:100%" required autocomplete="off">
					<option value="all">All</option>';
				foreach($Itemcats as $listcats) { 
					echo '<option value="'.$listcats['cat_id'].'">'.$listcats['cat_name'].'</option>';
				}
		echo'
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
<script>
    $("#mcageitemcat").select2({
        allowClear: true
    });
</script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickamonth").datepicker({
       format: "yyyy-mm",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript">
$().ready(function() {
	$("#Formstockagingmonth").validate({
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
