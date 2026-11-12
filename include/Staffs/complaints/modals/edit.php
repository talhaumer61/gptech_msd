<?php

if(isset($_GET['id']) && isset($_GET['edit'])) {
    $queryTask = $dblms->querylms("SELECT * FROM ".TASKS." WHERE id = ".$_GET['id']."");
    $value     = mysqli_fetch_array($queryTask);
    echo '
    <script type="text/javascript" src="./js/select2/jquery.select2.js"></script>
    <div class="container">
        <div class="modal-dialog" style="width:90%;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="location.href=\'tasks.php\'"><span>close</span></button>
                        <h4 class="modal-title" style="font-weight:700;"> Edit Task </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row" style="padding-bottom: 30px;">

                                <div class="col-12 container">
                                    <label for="">Title of the Task</label>
                                    <input type="text" name="title" class="form-control" value="'.$value['task_title'].'">
                                </div>

                                <div class="col-12 container">
                                    <label for="">Write Description</label>
                                    <textarea name="description" id="" style="height: 200px;" cols="30" rows="20">'.$value['task_description'].'</textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Priority Level</label>
                                    <select name="prioritylevel" id="priority" style="width: 100%;">
                                        <option value="'.$value['priority_level'].'">'.$priorityLevels[$value['priority_level']].'</option>';
                                        foreach($priorityLevels as $key => $level) {
                                            echo '
                                            <option value="'.$key.'">'.$level.'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>

                                <div class="col-sm-4">';
                                    $queryAsignto = $dblms->querylms("SELECT adm_fullname FROM ".ADMINS." WHERE adm_id = ".$value['assigned_to']."");
                                    $valueAsignto = mysqli_fetch_array($queryAsignto);
                                    echo '
                                    <label for="">Assigned To</label>
                                    <input type="text" name="asignto" class="form-control" value="'.$valueAsignto['adm_fullname'].'" readonly>
                                </div>

                                 <div class="col-sm-4">
                                    <label for="">Due Date</label>
                                    <input type="date" name="duedate" class="form-control" value="'.$value['due_date'].'">
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Status</label>
                                    <select name="status" id="status" style="width: 100%;">
                                        <option value="'.$value['status'].'">'.$status[$value['status']].'</option>';
                                        foreach($status as $key => $status) {
                                            echo '
                                            <option value="'.$key.'">'.$status.'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>
                                
                                <div class="col-sm-4">
                                    <label for="">Attachment</label>
                                    <input type="file" name="attachment" class="form-control"><div style="text-align: end;"><span class="btn btn-xs btn-purple">'.$value['task_attachment'].'</span></div>
                                </div>

                                <div class="col-sm-4 container" style="text-align: end;">
                                    <button type="submit" name="edit_task" class="btn btn-xs btn-primary text-white" style="padding: 10px; margin-top: ;"> Edit Task </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tid" value="'.$_GET['id'].'">
            </form>
        </div> 
    </div>
    <script>
        $("#asignto").select2({
            allowClear: true
        });
        $("#priority").select2({
            allowClear: true
        });
        $("#status").select2({
            allowClear: true
        });
        $("#hidden").select2({
            allowClear: true
        });
    </script>';
}

?>