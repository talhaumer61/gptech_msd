<?php 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editdispatchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="sales-invoice.php" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Dispatch Detail</h4>
</div>

<div class="modal-body">

<div class="col-sm-41">
	<div class="form_sep">
		<label class="req">Invoice #</label>
		<input type="text" class="form-control" id="salesinvoiceno_edit" name="salesinvoiceno_edit" readonly  autocomplete="off">
	</div> 
</div>

<div class="col-sm-81">
	<div class="form_sep">
		<label class="req">Customer Name</label>
		<input type="text" class="form-control" id="customername_edit" name="customername_edit" readonly autocomplete="off">
	</div> 
</div>

<div style="clear:both;"></div>



<div class="col-sm-41">
	<div class="form_sep" style="margin-top:10px;">
		<label class="req">Dispatch #</label>
		<input type="text" class="form-control" id="dispatchno_edit" name="dispatchno_edit" required  value="DP-'.mt_rand(100000,999999).'" readonly autocomplete="off">
	</div> 
</div>

<div class="col-sm-41">
	<div class="form_sep" style="margin-top:10px;">
		<label>Dispatch Date</label>
		<input type="text" class="form-control pickadate" id="dispatchdate_edit" name="dispatchdate_edit"  autocomplete="off">
	</div> 
</div>

<div class="col-sm-41">
	<div class="form_sep" style="margin-top:10px;">
		<label>Bilty #</label>
		<input type="text" class="form-control" id="biltyno_edit" name="biltyno_edit" autocomplete="off">
	</div> 
</div>

<div style="clear:both;"></div>

<div class="col-sm-61">
	<div class="form_sep" style="margin-top:10px;">
		<label class="req">Dispatch To</label>
		<input type="text" class="form-control" id="dispatchto_edit" name="dispatchto_edit" required autocomplete="off">
	</div> 
</div>

<div class="col-sm-61">
	<div class="form_sep" style="margin-top:10px;">
		<label class="req">Contact #</label>
		<input type="text" class="form-control" id="dispatchcellno_edit" name="dispatchcellno_edit" required autocomplete="off">
	</div> 
</div>


<div style="clear:both;"></div>

<div class="form-group" style="margin-bottom:5px;">
<label class="control-label col-lg-12" style="width:150px;"> <b>Dispatch Slip</b></label>
<div class="col-lg-12">
	<input id="upload_file" name="upload_file" class="btn btn-mid btn-primary clearfix" type="file" onChange="filevalidate(this.value)"> <span style="font-weight:700;">File extension must be: (<span style="color:red; font-weight:700;">pdf, jpg, png</span>)</span>
</div>
</div>

<div class="form-group" style="margin-bottom:10px;">
<label class="control-label req col-lg-12" style="width:150px;"> <b>Address</b></label>
<div class="col-lg-12">
	<input type="text" class="form-control" id="dispatchaddress_edit" name="dispatchaddress_edit" required autocomplete="off">
</div>
</div>

<div style="clear:both;"></div>

	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="idinvoice_edit" name="id_invoice" value="">
	<input type="hidden" name="id_order" id="job_orderid_edit" value="">
	<input type="hidden" name="id_customer" id="customerid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Dispatch" id="sale_dispatch" name="sale_dispatch" onclick="return confirm(\'Are you sure want to Dispatch this Order?\')" >
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
    $(".edit-dispatch-modal").click(function(){
    
        //get variables from "edit link" data attributes

		var idinvoice_edit			 = $(this).attr("data-cat-idinvoice");
		var job_orderid_edit		 = $(this).attr("data-cat-job_orderid");
		var customerid_edit			 = $(this).attr("data-cat-customerid");
		var customername_edit		 = $(this).attr("data-cat-customername");
		var dispatchto_edit			 = $(this).attr("data-cat-dispatchto");
		var dispatchcellno_edit		 = $(this).attr("data-cat-dispatchcellno");
		var dispatchaddress_edit	 = $(this).attr("data-cat-dispatchaddress");
		var salesinvoiceno_edit		 = $(this).attr("data-cat-salesinvoiceno");


        //set modal input values dynamically
		$("#salesinvoiceno_edit") 	.val(salesinvoiceno_edit) 
		$("#customername_edit") 	.val(customername_edit) 
		$("#customerid_edit") 		.val(customerid_edit) 
		$("#job_orderid_edit") 		.val(job_orderid_edit) 
		$("#dispatchto_edit") 		.val(dispatchto_edit) 
		$("#dispatchcellno_edit") 	.val(dispatchcellno_edit) 
		$("#dispatchaddress_edit") 	.val(dispatchaddress_edit) 
		$("#idinvoice_edit") 		.val(idinvoice_edit) 

  });
    
});
</script>';