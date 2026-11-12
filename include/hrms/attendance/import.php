<?php 
//-----------------------------------------------
if(LMS_VIEW == 'import') { 
//--------------------------------------
if(!empty($_FILES['std_photo']['name'])) { 

//------------------------------------------------
if($_FILES["std_photo"]["size"] > 0) {
 
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> Import Attendance</h3>
<form class="form-horizontal" action="#" method="post" name="importdata" id="importdata" enctype="multipart/form-data">
<input type="hidden" value="importfile" name="view" id="view">
<table class="table table-bordered">
<thead>
<tr>
	<th style="font-weight:700;"> Sr.#</th>
	<th style="font-weight:700;"> Emply # </th>
	<th style="font-weight:700;"> Emply Name </th>
	<th style="font-weight:700;"> Dated </th>
	<th style="font-weight:700;"> On duty </th>
	<th style="font-weight:700;"> Off duty </th>
	<th style="font-weight:700;"> Clock In </th>
	<th style="font-weight:700;"> Clock Out </th> 

</tr>
</thead>
<tbody>';
//--------------------------------------
	$file_name = $_FILES['std_photo']['name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    //Checking the file extension
    if($ext == "xlsx" || $ext == "csv" || $ext == "xls"){

            $file_name = $_FILES['std_photo']['tmp_name'];
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
    $rowcursData = $sheet->rangeToArray('A' . $rowcurs . ':' . $highestColumn . $rowcurs, 
                                    null, true, false);
//--------------------------------------
$srno++;
if($srno> 1) { 

//--------------------------------------------
$acno 			= $rowcursData[0][1];
$dated 			= $rowcursData[0][5];
$onduty 		= $rowcursData[0][7];
$offduty 		= $rowcursData[0][8];
$ClockIn 		= $rowcursData[0][9];
$ClockOut 		= $rowcursData[0][10];
if($ClockIn || $ClockOut) {
//--------------------------------------------
	$srno1++;
//--------------------------------------------
$dateString= $dated;
$myDateTime = DateTime::createFromFormat('m/d/Y', $dateString);
$newDateString = $myDateTime->format('Y-m-d');
//--------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT * FROM ".EMPLOYEES."	WHERE emply_no = '".$acno."' LIMIT 1");
	$valueemply 	= mysqli_fetch_array($sqllmschecker);
//--------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srno1.'</td>
	<td>'.$acno.'</td>
	<td>'.$valueemply['emply_name'].'</td>
	<td>'.$newDateString.'</td>
	<td>'.$onduty .'</td>
	<td>'.$offduty.'</td>
	<td>'.$ClockIn.'</td>
	<td>'.$ClockOut.'</td>
</tr>
<input type="hidden" name="acno['.$srno1.']" id="acno['.$srno1.']" value="'.$acno.'">
<input type="hidden" name="dated['.$srno1.']" id="dated['.$srno1.']" value="'.$newDateString.'">
<input type="hidden" name="onduty['.$srno1.']" id="onduty['.$srno1.']" value="'.$onduty.'">
<input type="hidden" name="offduty['.$srno1.']" id="offduty['.$srno1.']" value="'.$offduty.'">
<input type="hidden" name="ClockIn['.$srno1.']" id="ClockIn['.$srno1.']" value="'.$ClockIn.'">
<input type="hidden" name="ClockOut['.$srno1.']" id="ClockOut['.$srno1.']" value="'.$ClockOut.'">
<input type="hidden" name="id_dept['.$srno1.']" id="id_dept['.$srno1.']" value="'.$valueemply['id_dept'].'">
<input type="hidden" name="id_emply['.$srno1.']" id="id_emply['.$srno1.']" value="'.$valueemply['emply_id'].'">
<input type="hidden" name="id_shift['.$srno1.']" id="id_shift['.$srno1.']" value="'.$valueemply['id_shift'].'">
<input type="hidden" name="id_company['.$srno1.']" id="id_company['.$srno1.']" value="'.$valueemply['id_company'].'">';
 }
}
}
echo '<tr><td colspan="10" style="text-align:right;"><button class="btn btn-info" name="submit_import" id="submit_import" type="submit" style="padding:5px 13px; font-size:12px;"> Save Attendance </button></td></tr>';
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" value="'.$srno1.'">
</form>'; 

fclose($file);
}
}
//--------------------------------------
//} else {
//    echo 'The file is not readable';
//}
} else {
	echo '<div  class="alert-box error"><span>Oop: </span>File extension not valid, only .csv valid</div>';
}
//-----------------------------------------------
}
//------------------------------------------------
