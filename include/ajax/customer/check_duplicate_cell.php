<?php
include "../../../dbsetting/lms_vars_config.php";
include "../../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../../functions/login_func.php";
include "../../../functions/functions.php";

if(isset($_POST['cell'])){
    $cell = trim($_POST['cell']);

    $conditions = array ( 
								'select' 	=> 'customer_id',							
								'where' 	=> array ( 
														  'customer_personcell' => cleanvars(trim($_POST['cell'])) 
													 ), 
								'return_type' 	=> 'count' 
							); 
    $sqllmscheck = $dblms->getRows(CUSTOMERS, $conditions);

    if(($sqllmscheck)>0) { 
        echo "exists";
    } else {
        echo "ok";
    }
}
?>
