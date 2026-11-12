<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'add' => '1'))) { 
	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
		<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
							<h4 class="modal-title" style="font-weight:700;"> Add Item Detail</h4>
						</div>

						<div class="modal-body">

							<div class="col-sm-61">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Brand</label>
									<select id="id_brand" name="id_brand[]" multiple style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
										foreach($brandnames as $listbrand) {
											echo '<option value="'.$listbrand['id'].'">'.$listbrand['name'].' ('.$listbrand['code'].')</option>';
										}
										echo '
									</select>
								</div> 
							</div>
							<div class="col-sm-61">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Publisher</label>
									<select id="id_publisher" name="id_publisher" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach(get_publishers() as $key => $publish) {
										echo '<option value="'.$key.'">'.$publish.'</option>';
									}
									echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;margin-bottom:10px;"></div>
							
							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Item Code</label>
									<input type="text" class="form-control" id="item_code" name="item_code" required autocomplete="off" value="B'.mt_rand(1000,9999).'" readonly>
								</div> 
							</div>
							<div class="col-sm-51">
								<div class="form_sep">
									<label class="req">Item Name</label>
									<input type="text" class="form-control" id="item_name" name="item_name" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-51">
								<div class="form_sep">
									<label class="req">Item Category</label>
									<select id="id_cat" name="id_cat" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
										
										foreach($Itemcats as $listcats) { 
											echo '<option value="'.$listcats['cat_id'].'">'.$listcats['cat_name'].'</option>';
										}
										echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;margin-bottom:10px;"></div>

							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Weight <span style="font-weight:normal;"> (Kg)</span></label>
									<input type="number" class="form-control" id="item_weight" name="item_weight" value="" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Reorder Point</label>
									<input type="number" class="form-control" id="item_reorder" name="item_reorder" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Max Quantity<span style="font-weight:normal;"> (upper limit)</span></label>
									<input type="number" class="form-control" id="item_maxquantity" name="item_maxquantity" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Purchase Price</label>
									<input type="number" class="form-control" id="item_pricepurchase" name="item_pricepurchase" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Sale Price</label>
									<input type="number" class="form-control" id="item_pricesale" name="item_pricesale" autocomplete="off">
								</div> 
							</div>
							
							<div style="clear:both; margin-bottom:10px;"></div>

							<div class="col-sm-32">
								<div class="form_sep">
									<label>Dealership Rate </label>
									<input type="number" class="form-control" id="item_pricedealership" name="item_pricedealership" value="" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>Retail Rate</label>
									<input type="number" class="form-control" id="item_priceretail" name="item_priceretail" value="" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-61">
								<div class="form_sep">
									<label>Classes</label>
									<select id="item_classes" name="item_classes[]" multiple style="width:100%;">
											<option value="">Choose</option>';
											foreach($classnames as $listclass) {  
												echo '<option value="'.$listclass['id'].'">'.$listclass['name'].'</option>';
											}

											echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;"></div>
							
							<div class="col-sm-81">
								<div class="form_sep" style="margin-top:20px;">
									<label>Detail</label>
									<input type="text" class="form-control" id="item_details" name="item_details" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep" style="margin-top:20px;">
									<label>Photo</label>
									<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file" accept="image/*"> 
									<span style="color:#f00;">size should be less then 100KB</span>
								</div> 
							</div>
							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">CGS</label>
									<select id="cgs" name="cgs" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach($cgsArray as $cgs) {
										echo '<option value="'.$cgs['id'].'">'.$cgs['name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>
							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Income for Department</label>
									<select id="income_department" name="income_department" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach($incomeFor as $income) {
										echo '<option value="'.$income['id'].'">'.$income['name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>
							
							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Status</label>
									<select id="item_status" name="item_status" style="width:100%" autocomplete="off" required>
										<option value="">Select Status</option>';
									foreach($admstatus as $itemadm_status) {
										echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>
							
							<div style="clear:both;"></div>

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
								<input class="btn btn-primary" type="submit" value="Add Record" id="submit_add" name="submit_add">
							</button>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
	<!--WI_ADD_NEW_TASK_MODAL-->

	<!--JS_SELECT_LISTS-->
	<script>

		$("#id_brand").select2({
			allowClear: true
		});

		$("#id_publisher").select2({
			allowClear: true
		});

		$("#item_status").select2({
			allowClear: true
		});
		
		$("#cgs").select2({
			allowClear: true
		});
		
		$("#item_type").select2({
			allowClear: true
		});
		$("#id_cat").select2({
			allowClear: true
		});
		$("#income_department").select2({
			allowClear: true
		});
		$("#item_classes").select2({
			allowClear: true
		});
		
	</script>
	<script type="text/javascript">
		$().ready(function() {
			$("#addNewCountry").validate({
				rules: {
					company_name		: "required",
					company_status		: "required"
				},
				messages: {
					company_name		: "This field is required",
					company_status		: "This field is required"
				},
				submitHandler: function(form) {
				form.submit();
				}
			});
		});
	</script>';
}