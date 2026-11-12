<?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
	
	if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '12', 'edit' => '1'))) { 
		
		$conditions = array ( 
								'select' 		=> '*',
								'where' 		=> array ( 
															'item_id' => cleanvars($_GET['id'])
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
		$rowstd 	= $dblms->getRows(ITEMS, $conditions);
		if(isset($_GET['refs'])) {
			$hrefredirect1 =  str_replace('_','&',$_GET['refs']);;
			$hrefredirect =  'items.php?'.str_replace('|','=',$hrefredirect1);;
		} else {
			$hrefredirect = "items.php";
		}
		echo '

		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="items.php?id='.cleanvars($_GET['id']).'" method="post" id="editCountry" enctype="multipart/form-data">
					<input type="hidden" name="hrefredirect" id="hrefredirect" value="'.$hrefredirect.'">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\''.$hrefredirect.'\'"><span>close</span></button> 
							<h4 class="modal-title" style="font-weight:700;"> Edit Item Detail</h4>
						</div>

						<div class="modal-body">

							<div class="col-sm-61">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Brand</label>
									<select id="id_brand_edit" name="id_brand_edit[]" multiple style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
										foreach($brandnames as $listbrand) {
											echo '<option value="'.$listbrand['id'].'" '.(in_array($listbrand['id'], explode(',', $rowstd['id_brand'])) ? 'selected' : '').'>'.$listbrand['name'].' ('.$listbrand['code'].')</option>';
										}
										echo '
									</select>
								</div> 
							</div>
							<div class="col-sm-61">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Publisher</label>
									<select id="id_publisher_edit" name="id_publisher_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach(get_publishers() as $key => $publish) {
										echo '<option value="'.$key.'" '.($key == $rowstd['id_publisher'] ? 'selected' : '').'>'.$publish.'</option>';
									}
									echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;margin-bottom:10px;"></div>

							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Item Code</label>
									<input type="text" class="form-control" id="item_code_edit" name="item_code_edit" value="'.$rowstd['item_code'].'" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-51">
								<div class="form_sep">
									<label class="req">Item Name</label>
									<input type="text" class="form-control" id="item_name_edit" name="item_name_edit" value="'.$rowstd['item_name'].'" required autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-51">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Item Category</label>
									<select id="id_cat_edit" name="id_cat_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
										foreach($Itemcats as $listcats) { 
											echo ($listcats['cat_id'] == $rowstd['id_cat']) ? '<option value="'.$listcats['cat_id'].'" selected>'.$listcats['cat_name'].'</option>' : '<option value="'.$listcats['cat_id'].'">'.$listcats['cat_name'].'</option>';
										}
										echo '
									</select>
								</div> 
							</div>

							<div style="clear:both; margin-bottom:10px;"></div>

							<div class="col-sm-31">
								<div class="form_sep">
									<label class="req">Weight <span style="font-weight:normal;"> (Kg)</span></label>
									<input type="number" class="form-control" id="item_weight_edit" name="item_weight_edit" required value="'.$rowstd['item_weight'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Reorder Point</label>
									<input type="number" class="form-control" id="item_reorder_edit" name="item_reorder_edit" value="'.$rowstd['item_reorder'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Max Quantity<span style="font-weight:normal;"> (upper limit)</span></label>
									<input type="number" class="form-control" id="item_maxquantity_edit" name="item_maxquantity_edit" value="'.$rowstd['item_maxquantity'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Purchase Price</label>
									<input type="number" class="form-control" id="item_pricepurchase_edit" name="item_pricepurchase_edit" value="'.$rowstd['item_pricepurchase'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep">
									<label>Sale Price</label>
									<input type="number" class="form-control" id="item_pricesale_edit" name="item_pricesale_edit" value="'.$rowstd['item_pricesale'].'" autocomplete="off">
								</div> 
							</div>
							
							<div style="clear:both; margin-bottom:10px;"></div>

							<div class="col-sm-32">
								<div class="form_sep">
									<label>Dealership Rate</label>
									<input type="number" class="form-control" id="item_pricedealership_edit" name="item_pricedealership_edit" value="'.$rowstd['item_pricedealership'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-32">
								<div class="form_sep">
									<label>Retail Rate</label>
									<input type="number" class="form-control" id="item_priceretail_edit" name="item_priceretail_edit" value="'.$rowstd['item_priceretail'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-61">
								<div class="form_sep">
									<label>Classes</label>
									<select id="item_classes_edit" name="item_classes_edit[]" multiple style="width:100%;">
											<option value="">Choose</option>';
											foreach($classnames as $listclass) {  
												echo '<option value="'.$listclass['id'].'"'; if(in_array($listclass['id'], explode(',', $rowstd['item_classes']))){echo ' selected';} echo '>'.$listclass['name'].'</option>';
											}

											echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;"></div>

							<div class="col-sm-81">
								<div class="form_sep" style="margin-top:20px;">
									<label>Detail</label>
									<input type="text" class="form-control" id="item_details_edit" name="item_details_edit" value="'.$rowstd['item_details'].'" autocomplete="off">
								</div> 
							</div>
							<div class="col-sm-31">
								<div class="form_sep" style="margin-top:20px;">
									<label>Photo</label>
									<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file" accept="image/*"> 
									<span style="color:#f00;">size should be less then 100KB</span>
								</div> 
							</div>
							

							<div style="clear:both;"></div>

							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">CGS</label>
									<select id="cgs_edit" name="cgs_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach($cgsArray as $cgs) { 
										echo ($cgs['id'] == $rowstd['cgs']) ? '<option value="'.$cgs['id'].'" selected>'.$cgs['name'].'</option>' : '<option value="'.$cgs['id'].'">'.$cgs['name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>
							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Income for Department</label>
									<select id="income_edit" name="income_department_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select</option>';
									foreach($incomeFor as $income) { 
										echo ($income['id'] == $rowstd['income_department']) ? '<option value="'.$income['id'].'" selected>'.$income['name'].'</option>' : '<option value="'.$income['id'].'">'.$income['name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>
							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label class="req">Status</label>
									<select id="item_status_edit" name="item_status_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select Status</option>';
									foreach($admstatus as $itemadm_status) { 
										echo ($itemadm_status['status_id'] == $rowstd['item_status']) ? '<option value="'.$itemadm_status['status_id'].'" selected>'.$itemadm_status['status_name'].'</option>' : '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
									}
									echo '
									</select>
								</div> 
							</div>

							<div style="clear:both;"></div>
							

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\''.$hrefredirect.'\'" >Cancel</button>
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--WI_EDIT_TASK_MODAL-->
		<!--JS_SELECT_LISTS-->
		<script>
			$("#id_brand_edit").select2({
				allowClear: true
			});
			$("#id_publisher_edit").select2({
				allowClear: true
			});
			$("#item_status_edit").select2({
				allowClear: true
			});
			$("#income_edit").select2({
				allowClear: true
			});
			$("#cgs_edit").select2({
				allowClear: true
			});
			
			$("#id_cat_edit").select2({
				allowClear: true
			});
			$("#item_classes_edit").select2({
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
		</script>';
	}
}