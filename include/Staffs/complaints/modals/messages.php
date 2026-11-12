<?php

if(isset($_GET['id']) && isset($_GET['messages'])) {

    $queryAssignToAssignBy = $dblms->querylms("SELECT * FROM ".TASKS." WHERE id = ".$_GET['id']."");
    $value = mysqli_fetch_array($queryAssignToAssignBy);
    $queryAssignTo = $dblms->querylms("SELECT adm_fullname FROM ".ADMINS." WHERE adm_id = ".$value['assigned_to']."");
    $valueAssignTo = mysqli_fetch_array($queryAssignTo);
    $queryAssignBy = $dblms->querylms("SELECT adm_fullname FROM ".ADMINS." WHERE adm_id = ".$value['id_added']."");
    $valueAssignBy = mysqli_fetch_array($queryAssignBy);
    
    echo '
    <script type="text/javascript" src="./js/select2/jquery.select2.js"></script>
    <div class="container" style="display: flex; justify-content: space-between; align-items: start; padding-top: 30px;">
    
        <div style="width: 40%; height: ; background-color: white; border: 1px solid lightblue; border-radius: 6px; box-shadow: 0 0 15px lightblue;">
            <div class="" style="padding: ; margin: ; width: 100%;">
                <div class="" style="width: 100%;">';
                    if(($_SESSION['LOGINIDA_SSS'] == $value['assigned_to']) || ($_SESSION['LOGINIDA_SSS'] == $value['id_added'])) {
                        echo '
                        <div style="padding: 7.4px 10px; border-bottom: 1px solid lightblue; background-color: white;"><h4 class="modal-title" style="font-weight:700; background-color: white;"> Task Detail </h4></div>
                        <div class="" style="padding-bottom: 20px; padding: 10px;">
                            <div class="container">
                                <div class="row" style="">
                                    <div class="col-12 container">';
                                        $today = date('Y-m-d');
                                        $futureDate = $value['due_date'];
                                        $difference = strtotime($futureDate) - strtotime($today);
                                        $days = $difference/(60 * 60)/24;
                                        if($days >= 0) {
                                            echo '
                                            <h4 class="alert alert-danger text-center" style="margin-top: ;"><span class=""><b>'.$days.' Day (s) Remaining For You to complete the task</b></span></h4>';
                                        } else {
                                            echo '
                                            <h4 class="alert alert-danger text-center" style="margin-top: ;"><span class=""><b>TIme out for you to complete the task</b></span></h4>';
                                        }
                                        echo '
                                    </div>
                                    <div class="col-12 container" style="padding-bottom: 10px;">
                                        <form action="" method = "post">
                                            <label for="">Change Task Status</label><br>
                                            <select name="changestatus" id="status" style="width: 50%;">
                                                <option value=""></option>';
                                                foreach($status as $key => $status) {
                                                    echo '
                                                    <option value="'.$key.'">'.$status.'</option>';
                                                }
                                                echo '
                                            </select>
                                            <button name="chnge_status" type="submit" class="btn btn-primary" style="padding: 5px;">Change</button>
                                            <input type="hidden" name="taskid" value="'.$_GET['id'].'">
                                        </form>
                                    </div>

                                    <div class="col-12 container">
                                        <h4><b>Task Title</b></h4>
                                        <h4><span class="">'.$value['task_title'].'</span></h4>
                                    </div>
                                    
                                    <div class="col-12 container">
                                        <h4><b>Priority</b></h4>
                                        <h4><span class="">This Task is of <span style="color: red;"><b>'.$priorityLevels[$value['priority_level']].'</b></span> Priority</span></h4>
                                    </div> 
                                    <div class="col-12 container">
                                        <h4><b>Description</b></h4>
                                        <h5><span class="">'.$value['task_description'].'</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    } else {
                        echo "<center style='padding-top: 30px; padding-bottom: 30px;'>You cannot send messages</center>";
                    }
                    echo '
                </div>
            </div>
        </div>

        <div class="modal-dialog" style="width: 57%; padding: 0; margin: 0;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content" style="width: 100%;">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="location.href=\'tasks.php\'"><span>close</span></button>
                        <h4 class="modal-title" style="font-weight:700;"> Messages </h4>
                    </div>';
                    if(($_SESSION['LOGINIDA_SSS'] == $value['assigned_to']) || ($_SESSION['LOGINIDA_SSS'] == $value['id_added'])) {
                        echo '
                        <div class="modal-body" style="padding-bottom: 20px;">
                            <div class="container">
                                <div class="row" style="">
                                    <div class="col-12 container" style="display: flex; justify-content: space-between;">
                                        <div style="display: flex; align-items: center;">
                                            <img src="include/tasks/img/user.png" alt="" style="object-fit: contain; width: 40px; height: 40px; border-radius: 50%; border: 1px solid lightblue; margin-right: 5px;">
                                            <div>
                                                <h4><b>Assigned To</b></h4>
                                                <h5>'.$valueAssignTo['adm_fullname'].'</h5>
                                            </div>
                                        </div>

                                        <div style="display: flex; align-items: center;">
                                            <img src="include/tasks/img/profile.png" alt="" style="object-fit: contain; width: 40px; height: 40px; border-radius: 50%; border: 1px solid lightblue; margin-right: 5px;">
                                            <div>
                                                <h4><b>Assigned By</b></h4>
                                                <h5>'.$valueAssignBy['adm_fullname'].'</h5>
                                            </div>
                                        </div>
                                        <div style="">
                                                <h4><b>Due Date</b></h4>
                                                <h5>'.$value['due_date'].'</h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 container" id="msgbox" style="height: 350px; overflow: auto;">';
                                        $queryMessages = $dblms->querylms("SELECT * FROM ".TMESSAGES." WHERE id_task = ".$_GET['id']." AND id_added = ".$value['id_added']." OR id_added = ".$value['assigned_to']."");
                                        if(mysqli_num_rows($queryMessages) > 0) {
                                            while($valueMessage = mysqli_fetch_array($queryMessages)) {
                                                if($valueMessage['id_added'] == $_SESSION['LOGINIDA_SSS']){
                                                    $style = 'style="text-align: end; "';
                                                } else {
                                                    $style = 'style="text-align: start;"';
                                                }
                                                echo '
                                                <div '.$style.'>
                                                    <span class="" style="font-size: 9px;">'.$valueMessage['date_added'].'</span>
                                                    <br>';
                                                    if(empty($valueMessage['message']) && !empty($valueMessage['file'])) {

                                                        $pathinfo = pathinfo($valueMessage['file']);
                                                        $ext = $pathinfo['extension'];
                                                        if(in_array($ext , array('png','jpg','jpeg'))) {
                                                            echo '
                                                            <span class="btn btn-xs btn-purple" style="font-size: 12px;">'.$valueMessage['file'].'</span>
                                                            <a style="display: block;" href="include/tasks/files/'.$valueMessage['file'].'" target="_blank"><img src="include/tasks/files/'.$valueMessage['file'].'" style="border: 2px solid lightblue; object-fit: contain; border-radius: 5px; margin-top: 6px;" height="150px" width="220px" alt=""></a>';
                                                        } else if(in_array($ext , array('pdf','docx','ppt','pptx'))) {
                                                            echo '
                                                            <a style="display: inline-block; border: 2px solid darkblue; border-radius: 7px; width: 250px; padding: 10px;" href="include/tasks/files/'.$valueMessage['file'].'" target="_blank">
                                                                <span class="" style="display: flex; align-items: center;">
                                                                    <img src="include/tasks/img/folder.png" alt="">
                                                                    <span class="btn text-white" style="margin-left: 10px; background-color: darkblue; font-size: 12px;">'.$valueMessage['file'].'</span>
                                                                </span>
                                                                <div style="text-align: end;">'.$ext.' file</div>
                                                            </a>';
                                                        }

                                                    } else {
                                                        echo '
                                                        <span class="" style="font-size: 13px;"><b>'.$valueMessage['message'].'</b></span>';
                                                    }
                                                    echo '
                                                </div>
                                                <hr>
                                                <input type="hidden" id="idadded" value="'.$value['id_added'].'">
                                                <input type="hidden" id="asignto" value="'.$value['assigned_to'].'">';
                                            }
                                        } else {
                                            echo '
                                            <div class="col-12 container">
                                                <center style="margin-top: 30px;"><h4><b>No Result found of any communication</b></h4></center>
                                            </div>';
                                        }
                                        echo '
                                    </div>
                                    <div class="col-12 container" style="padding-top: 5px;">
                                        <div style="display: flex; align-items: center; border: 1px solid lightblue; background-color: white; padding: 5px;">
                                            <input type="text" class="form-control" name="message" id="message" style="border: none; width: 100%;" autofocus placeholder="Write your message here" value="">
                                            <input type="file" name="file" id="file" value="">
                                            <button type="submit" style="" class="btn btn-primary" name="send_message" id="send_text" onclick=>Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    } else {
                        echo "<center style='padding-top: 30px; padding-bottom: 30px;'>You cannot send messages</center>";
                    }
                    echo '
                </div>
                <input type="hidden" name="tid" id="tid" value="'.$_GET['id'].'">
            </form>
        </div>
    </div>
    
    <script>
        $("#status").select2({
            allowClear: true
        });
    </script>';
}

?>

<script>

    function submitMessage() {

        var message     = document.getElementById("message").value;        
        var id          = document.getElementById("tid").value;
        var idAdded     = document.getElementById("idadded").value;
        var idAsignto   = document.getElementById("asignto").value;


        if(message.length === 0) {
            
            var filedata   = $('#file').prop('files')[0];
            var formdata   = new FormData();
            formdata.append('file', filedata);
            $.ajax({
                type        : "POST"                                                                            ,
                url         : "include/tasks/insert_message.php"                                                ,
                data        : "formdata="+formdata+"&id="+id+"&idadded="+idAdded+"&idasignto="+idAsignto        ,
                // dataType    : "json"    ,
                // contentType : false     ,
                // cache       : false     ,
                // processData : false     ,
                success     : function(data) {
                    document.getElementById('msgbox').innerHTML = data;
                    // var message     = document.getElementById("message").value;
                    // document.getElementById('message').value = '';
                }
            });

        }

        if(message.length !== 0) {
            $.ajax({
                type    : "POST"                                                                            ,
                url     : "include/tasks/insert_message.php"                                                ,
                data    : "msg="+message+"&id="+id+"&idadded="+idAdded+"&idasignto="+idAsignto              ,
                success : function(data) {
                    document.getElementById('msgbox').innerHTML = data;
                    var message     = document.getElementById("message").value;
                    document.getElementById('message').value = '';
                }
            });
        }

    }

</script>
