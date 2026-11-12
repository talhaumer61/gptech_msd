<?php 
//--------------------------------------------
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['class'])) {
	$vars = explode(',', $_GET['class']);
	//print_r ($_GET['class']);
//--------------------------------------------
	if($vars[1] == 2) {
		echo '<input type="number" min="'.$vars[0].'" class="form-control" id="otheramnt" name="otheramnt" value="" required>';
	} else {
		echo '<input type="hidden" id="otheramnt" name="otheramnt" value="0">';
	}
//--------------------------------------------
} 