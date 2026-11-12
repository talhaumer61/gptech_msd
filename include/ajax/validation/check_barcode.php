<?php 
// error_reporting(0);
// session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
if(isset($_POST['book_barcode'])) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT book_barcode 
											  FROM ".LRC_BOOKS_DETAIL." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND book_barcode 	= '".cleanvars($_POST['book_barcode'])."' 
												AND is_deleted != '1' 
											  LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}

if(isset($_POST['book_barcode_edit'])) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT book_barcode 
											  FROM ".LRC_BOOKS_DETAIL." 
											  WHERE id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND book_barcode 		= '".cleanvars($_POST['book_barcode_edit'])."'
											  AND id 		 		!= '".cleanvars($_POST['id_book_detail'])."'
											  AND is_deleted != '1'
											  LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "true";  //good to register
    } else {
        echo "false"; //already registered
    }
}
?>