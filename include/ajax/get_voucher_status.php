<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";

if(isset($_POST['challan']) ){

    $conditions = array ( 
                              'select' 		=> 'estimate_status'
                            , 'where' 		=> array( 
                                                        'voucher_no' => cleanvars($_POST['challan'])
                                                    )
                            , 'return_type' => 'single' 
                        ); 
    $estimate 	= $dblms->getRows(ESTIMATES, $conditions);
    
    $data['status']  = $estimate['estimate_status'];
    echo json_encode($data);

}

?>