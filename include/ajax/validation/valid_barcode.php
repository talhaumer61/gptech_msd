<?php 
// error_reporting(0);
// session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
if(isset($_POST['accession_no'])) {
//--------------------------------------------
    // echo $_POST['accession_no'][0];

//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT book_barcode 
											  FROM ".LRC_BOOKS_DETAIL." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND book_barcode 	= '".cleanvars($_POST['accession_no'][0])."' LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "false";  //good to register
    } else {
        echo "true"; //already registered
    }
}

if(isset($_POST['book_barcode_edit'])) {
//--------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT book_barcode 
											  FROM ".LRC_BOOKS_DETAIL." 
											  WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											  AND book_barcode 		= '".cleanvars($_POST['book_barcode_edit'])."' LIMIT 1");
//--------------------------------------------
	$countbks = mysqli_num_rows($sqllmsselect);
    if($countbks == 0)  {
        echo "false";  //good to register
    } else {
        echo "true"; //already registered
    }
}
?>