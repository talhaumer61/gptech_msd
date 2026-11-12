<?php

if(isset($_GET['add']) && !isset($_GET['messages'])) {
    
    echo '
    <script type="text/javascript" src="./js/select2/jquery.select2.js"></script>
    <div class="container">
        <div class="modal-dialog" style="width:90%;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="location.href=\'tasks.php\'"><span>close</span></button>
                        <h4 class="modal-title" style="font-weight:700;"> Add Task </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 container">
                                    <label for="" class="req">Title of the Task</label>
                                    <input type="text" name="title" class="form-control" >
                                </div>
                                <div class="col-12 container">
                                    <label for="" class="req">Write Description</label>
                                    <textarea name="description" id="" style="height: 200px;" cols="30" rows="20" ></textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label for="" class="req">Priority Level</label>
                                    <select name="prioritylevel" id="priority" style="width: 100%;" >
                                        <option value=""></option>';
                                        foreach($priorityLevels as $key => $level) {
                                            echo '
                                            <option value="'.$key.'">'.$level.'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>';
                                if($_SESSION['LOGINTYPE_SSS'] == 1 || $_SESSION['LOGINTYPE_SSS'] == 5) {
                                    echo '
                                    <div class="col-sm-4">
                                        <label for="" class="req">Select Campus</label>
                                        <select name="campus" id="campus" style="width: 100%;" onchange="get_departments(this.value)">
                                            <option value=""></option>';
                                            $queryCampuses = $dblms->querylms("SELECT campus_id , campus_name FROM ".CAMPUSES."");
                                            while($valueCampus = mysqli_fetch_array($queryCampuses)) {
                                                echo '<option value="'.$valueCampus['campus_id'].'">'.$valueCampus['campus_name'].'</option>';
                                            }
                                            echo '
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="req">Select Department</label>
                                        <select name="dept" id="dept" style="width: 100%;" onchange="get_employees(this.value)">
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <label for="" class="req">Select Employees</label>
                                        <select name="asignto" id="asignto" style="width: 100%;" onchange=addEmployee()>
                                        </select>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="col-sm-4">
                                        <label for="" class="req">Assigning To</label>
                                        <select name="asignto" id="asignto" style="width: 100%;" onchange=addEmployee()>
                                            <option value=""></option>';
                                            $queryAdmins = $dblms->querylms("SELECT adm_id , adm_fullname FROM ".ADMINS." WHERE adm_status = 1 AND id_dept = ".$_SESSION['LOGINDEPT_SSS']." AND id_campus = ".$_SESSION['LOGINIDCOM_SSS']." LIMIT 50");
                                            while($valueAdmin = mysqli_fetch_array($queryAdmins)) {
                                                echo '
                                                <option value="'.$valueAdmin['adm_id'].'">'.$valueAdmin['adm_fullname'].'</option>';
                                            }
                                            echo '
                                        </select>
                                    </div>';
                                }
                                echo '
                                <input type="hidden" name="emplyid" id="emplyid" value="">
                                

                                <div class="col-sm-4">
                                    <label for="" class="">Emplys</label>
                                    <textarea name="emplys" id="emply" cols="30" rows="10" value="" style="height: 130px;"></textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label for="" class="req">Due Date</label>
                                    <input type="date" name="duedate" class="form-control">
                                </div>
                                
                                
                                <div class="col-sm-4">
                                    <label for="" class="req">Status</label>
                                    <input type="text" name="status" class="form-control" value="'.$status[0].'" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Attachment</label>
                                    <input type="file" name="attachment" class="form-control">
                                </div>
                                
                                <div class="col-sm-4 container" style="text-align: end;">
                                    <button type="submit" name="add_task" class="btn btn-xs btn-primary text-white" style="padding: 10px; margin-top: 10px;"> Add Task </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </div>
    <script>
        $("#campus").select2({
            allowClear: true
        });
        $("#dept").select2({
            allowClear: true
        });
        $("#asignto").select2({
            allowClear: true
        });
        $("#priority").select2({
            allowClear: true
        });
        $("#status").select2({
            allowClear: true
        });
    </script>';
}

?>
<script>


    function get_departments(campus) {
        $.ajax({
            type    :    "post"                                     ,
            url     :    "include/tasks/get_departments.php"        ,
            data    :    "campus_id="+campus                        ,
            success :    function(data) {
                document.getElementById("dept").innerHTML = data;
            }
        });
    }

    function get_employees(dept) {
        $.ajax({
            type    :    "post"                                     ,
            url     :    "include/tasks/get_employees.php"          ,
            data    :    "dept_id="+dept                            ,
            success :    function(data) {
                document.getElementById("asignto").innerHTML = data;
            }
        });
    }

    var emplys = '';
    var id = '';
    function addEmployee() {

        var select          = document.getElementById('asignto').value;
        var input           = document.getElementById('emply');
        var inputhidden     = document.getElementById('emplyid');
        id += select+',';
        inputhidden.value  = id;
        
        $.ajax({
            type : "POST"                                   ,
            url  : "include/tasks/get_emplyname.php"        ,
            data : "id="+select                             ,
            // dataType : 'json'                               ,
            success : function(data) {
                emplys     += data+' , ';
                input.value = emplys;
            }
        });

    }

</script>