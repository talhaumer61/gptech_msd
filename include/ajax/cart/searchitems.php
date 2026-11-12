<?php 
	include "../../dbsetting/lms_vars_config.php";
	include "../../../api/db_functions.php";
	$api = new main();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
if(isset($_POST['search_word']) || isset($_POST['id_cls']) || isset($_POST['id_cat'])) {

    $search_word = '';
    $id_cls = '';
    $id_cat = '';
	if(isset($_POST['search_word'])){
		$search_word = $_POST['search_word'];
	}
	if(isset($_POST['id_cls'])){
		$id_cls = $_POST['id_cls'];
	}
	if(isset($_POST['id_cat'])){
		$id_cat = $_POST['id_cat'];
	}
	// GET ITEMS
	$items	  = $api->get_items($search_word, $id_cls, $id_cat);
	if($items['success'] &&  $items['items']){
		foreach($items['items'] as $item){
			echo '
			<div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 mb-sm">
				<div class="card card-file">
					<div class="card-file-thumb">
						<img src="'.$item['item_photo'].'" width="100" height="100">
					</div>
					<div class="card-body  text-center">
						<h6 class="line-clamp-1">'.$item['item_code'].'-'.$item['item_name'].'</h6>
						<b>Rs: <span>'.$item['item_pricesale'].'</span></b>
					</div>
					<div class="card-footer text-center">
						<a onclick="addtocart(\''.$item['item_id'].'\',\''.$item['item_photo'].'\',\''.$item['item_code'].'\',\''.$item['item_name'].'\',\''.$item['item_pricesale'].'\')" class="btn btn-primary btn-xs"><i class="fa fa-shopping-cart"></i> Add to cart</a>
					</div>
				</div>
			</div>
			';
		}
	}else{
		echo'<div class="panel-body"><h2 class="text text-center text-danger mt-lg">No Record Found!</h2></div>';
	}
}
?>