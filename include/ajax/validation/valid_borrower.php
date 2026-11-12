<?php

include "../../../dbsetting/lms_vars_config.php";
include "../../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../../functions/login_func.php";
include "../../../functions/functions.php";


if (isset($_POST['borrower_id'])){

    $borrower_id =  $_POST['borrower_id'];
    if($_POST['borrower_type'] == 1){

        $sqllmsvalidate  = $dblms->querylms("SELECT e.emply_id
                                                FROM ".EMPLYS." e  
                                                INNER JOIN ".DEPTS." dep ON dep.dept_id = e.id_dept
                                                INNER JOIN ".DESIGNATIONS." d ON d.designation_id = e.id_designation
                                                WHERE ( e.emply_regno = '".$borrower_id."'
                                                        OR e.emply_cnic = '".$borrower_id."'
                                                        OR e.emply_name LIKE '%".$borrower_id."%'
                                                )  ORDER BY e.emply_id ASC LIMIT 1");


    } else {

        $sqllmsvalidate  = $dblms->querylms("SELECT std.std_id, std.std_regno, std.std_name, std.std_rollno, std.id_dept, 
                                                std.std_mobile, std.std_email, std.std_photo,std.std_semester,std.std_session, std.std_timing, std.std_fathername, prg.prg_name, prg.prg_code, prg.prg_semesters, fc.faculty_name, dp.dept_name, 
                                                prgcat.cat_name
                                                FROM ".STUDENTS." std 
                                                INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
                                                INNER JOIN ".PROGRAMSCATS." prgcat ON prg.id_cat = prgcat.cat_id 
                                                INNER JOIN ".DEPTS." dp ON std.id_dept = dp.dept_id 
                                                INNER JOIN ".FACULTIES." fc ON std.id_faculty = fc.faculty_id 
                                                WHERE std.std_regno LIKE '".cleanvars($borrower_id)."' 
                                                AND (std.std_status = '2' OR std.std_status = '7' OR std.std_status = '6')
                                                AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                ORDER BY std_id DESC LIMIT 1");
                                                

    }

    if(mysqli_num_rows($sqllmsvalidate) > 0){
        echo "true";
    } else {
        echo "false";
    }
}
?>