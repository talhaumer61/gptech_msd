<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['idcat'])) { 

// get all Items

	$itemsconditions = array ( 
								'select' 		=> 'item_id, item_name, item_code',
								'where' 		=> array( 
															  'item_status' => 1 
															, 'id_cat' 		=> $_POST['idcat']
													), 
								'order_by' 		=> 'item_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Items = $dblms->getRows(ITEMS, $itemsconditions);
echo '
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Items</b></label>
		<div class="col-lg-12">
			<select id="puriditem" name="iditem" style="width:100%" required autocomplete="off">
				<option value="all">All</option>';
				foreach($Items as $listcat) {
					echo '<option value="'.$listcat['item_id'].'">'.$listcat['item_code'].' - '.$listcat['item_name'].'</option>';
				}
		echo '
			</select>
		</div>
	</div>
<script>
    $("#puriditem").select2({
        allowClear: true
    });
</script>';
}
if(isset($_POST['idcatgrn'])) { 
// get all Items
	$itemsconditions = array ( 
								'select' 		=> 'item_id, item_name, item_code',
								'where' 		=> array( 
															  'item_status' => 1 
															, 'id_cat' 		=> $_POST['idcatgrn']
													), 
								'order_by' 		=> 'item_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Items = $dblms->getRows(ITEMS, $itemsconditions);
echo '
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Items</b></label>
		<div class="col-lg-12">
			<select id="puriditemgrn" name="iditem" style="width:100%" required autocomplete="off">
				<option value="all">All</option>';
				foreach($Items as $listcat) {
					echo '<option value="'.$listcat['item_id'].'">'.$listcat['item_code'].' - '.$listcat['item_name'].'</option>';
				}
		echo '
			</select>
		</div>
	</div>
<script>
    $("#puriditemgrn").select2({
        allowClear: true
    });
</script>';
}