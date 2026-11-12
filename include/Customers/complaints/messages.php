<?php
if(isset($_GET['id']) && $view == 'messages') {

    $queryTask = $dblms->querylms("SELECT c.*, cus.customer_name
                                        FROM ".COMPLAINTS." c 
                                        INNER JOIN ".CUSTOMERS." cus ON cus.customer_id = c.id_customer
                                        WHERE c.complaint_id = ".cleanvars($_GET['id'])."
                                        AND c.id_customer = ".cleanvars($id_customer)."");
    $valueTask = mysqli_fetch_array($queryTask);

    $addeddDate = '';
    if($valueTask['date_added'] != '0000-00-00'){
        $addeddDate = date('d-m-Y h:i A',strtotime($valueTask['date_added']));
    }
    
    echo '
    <script type="text/javascript" src="./js/select2/jquery.select2.js"></script>
    <div class="container" style="display: flex; justify-content: space-between; align-items: start; padding-top: 30px; padding-bottom: 30px;">
    
        <div style="width: 40%; background-color: white; border: 1px solid lightblue; border-radius: 6px; box-shadow: 0 0 15px lightblue;">
            <div class="" style="width: 100%;">
                <div class="" style="width: 100%;">';
                        echo '
                        <div style="padding: 7.4px 10px; border-bottom: 1px solid lightblue; background-color: white;"><h4 class="modal-title" style="font-weight:700; background-color: white;"> Complaint Details</h4></div>
                        <div class="" style="padding-bottom: 20px; padding: 10px;">
                            <div class="container">
                                <div class="row" style="height: 590px!important; overflow: auto;">
                                    <!--
                                    <div class="col-12 container">';
                                        $today = date('Y-m-d');
                                        $futureDate = $valueTask['due_date'];
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
                                    -->';
                                    echo '
                                    <div class="col-12 container">
                                        <h4><b>Task Title: </b> <span style="font-size:14px; font-weight:normal;">'.$valueTask['complaint_title'].'</span></h4>
                                        <h4><span class=""></span></h4>
                                    </div>
                                    <div class="col-12 container">
                                        <h4><b>Department: </b> '.$departments[$valueTask['id_dept']].'</h4>
                                    </div>
                                    <div class="col-12 container">
                                        <h4><b>Priority: </b> '.get_priority_level($valueTask['complaint_priority']).'</h4>
                                    </div>
                                    <div class="col-12 container" style="margin-top:5px;">
                                        <h4><b>Date: </b> '.$addeddDate.'</h4>
                                    </div> 
                                    <div class="col-12 container" style="margin-top:5px;">
                                        <h4><b>Description:</b> <span style="font-size:14px; font-weight:normal;">'.$valueTask['complaint_description'].'</span></h4>
                                    </div>
                                    <div class="col-12 container" style="margin-top:5px;">
                                        <h4><b>Assigned By: </b> '.$valueTask['customer_name'].'</h4>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    echo '
                </div>
            </div>
        </div>

        <div class="modal-dialog" style="width: 57%; padding: 0; margin: 0;">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-content" style="width: 100%;">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="location.href=\'complaints.php\'"><span>Close</span></button>
                        <h4 class="modal-title" style="font-weight:700;"> Correspondence </h4>
                    </div>
                        <div class="modal-body" style="padding-bottom: 20px;">
                            <div class="container">
                                <div class="row" style="">
                                    <div class="col-12 container" id="msgbox" style="height: 484px; overflow: auto;">';
                                        $queryMessages = $dblms->querylms("SELECT tm.*, adm.adm_fullname
                                                                                FROM ".COMPLAINTS_MESSAGE." tm
                                                                                INNER JOIN ".ADMINS." adm ON adm.adm_id = tm.id_added
                                                                                WHERE tm.id_complaint = ".cleanvars($_GET['id'])."
                                                                                ORDER BY tm.id ASC");
                                        if(mysqli_num_rows($queryMessages) > 0) {

                                            $messageSrNo = 0; 
                                            while($valueMessage = mysqli_fetch_array($queryMessages)) {

                                                $messageSrNo++;

                                                if($valueMessage['id_added'] == cleanvars($_SESSION['userlogininfo']['LOGINIDA'])){
                                                    $style = 'style="text-align: end; "';
                                                } else {
                                                    $style = 'style="text-align: start;"';
                                                }

                                                echo '
                                                <div '.$style.'>';

                                                    if(!empty($valueMessage['attachment'])) {

                                                        $pathinfo = pathinfo($valueMessage['attachment']);
                                                        $ext = $pathinfo['extension'];

                                                        if(in_array($ext, array('png','jpg','jpeg','gif'))) {

                                                            echo '
                                                            <span class="" style="font-size: 13px;"><b>'.$valueMessage['message'].'</b></span><br>
                                                            <span class="btn btn-xs btn-purple" style="font-size: 12px;">'.$valueMessage['attachment'].'</span>
                                                            <a style="display: block;" href="downloads/tasks/'.$valueMessage['attachment'].'" target="_blank"><img src="downloads/tasks/'.$valueMessage['attachment'].'" style="border: 2px solid lightblue; object-fit: contain; border-radius: 5px; margin-top: 6px;" height="150px" width="220px" alt=""></a>';

                                                        } else if(in_array($ext , array('pdf','docx','ppt','pptx','xls','xlsx'))) {

                                                            echo '
                                                            <span class="" style="font-size: 13px;"><b>'.$valueMessage['message'].'</b></span><br>
                                                            <a style="display: inline-block; border: 2px solid darkblue; border-radius: 7px; width: 250px; padding: 10px;" href="downloads/tasks/'.$valueMessage['attachment'].'" target="_blank">
                                                                <span class="" style="display: flex; align-items: center;">
                                                                    <img src="images/folder.png" alt="">
                                                                    <span class="btn text-white" style="margin-left: 10px; background-color: darkblue; font-size: 12px;">'.$valueMessage['attachment'].'</span>
                                                                </span>
                                                                <div style="text-align: end;">'.$ext.' file</div>
                                                            </a>';
                                                        }

                                                    } else {
                                                        echo '
                                                        <span class="" style="font-size: 13px;"><b>'.$valueMessage['message'].'</b></span>';
                                                    }

                                                    echo '
                                                    <br>
                                                    <span class="" style="font-size: 12px;">'.$valueMessage['adm_fullname'].'</span>
                                                    <br>
                                                    <span class="" style="font-size: 9px;">'.$valueMessage['date_added'].'</span>
                                                </div>
                                                <hr>';

                                                //Check and Insert Last Message Seen
                                                if(mysqli_num_rows($queryMessages) == $messageSrNo){

                                                    $queryTaskMessageCheck  = $dblms->querylms("SELECT mv.id
                                                                                                    FROM ".COMPLAINTS_MESSAGE_VIEW." mv
                                                                                                    WHERE mv.id_admin = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ."'
                                                                                                    AND mv.id_complaint = '".cleanvars($_GET['id'])."'
                                                                                                    AND mv.last_read = '".$valueMessage['id']."'");
                                                    if(mysqli_num_rows($queryTaskMessageCheck) == 0) {
                                                        
                                                        $data = array(
                                                            'id_admin'     =>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 	,
                                                            'id_complaint' =>        cleanvars($_GET['id'])       						,
                                                            'last_read'    =>        $valueMessage['id']               		            ,
                                                            'date_added'   =>        date('Y-m-d H:i:s')          						,	
                                                        );
                                                        $sqllmsInsert = $dblms->Insert(COMPLAINTS_MESSAGE_VIEW , $data);
                                                    }
                                                }
                                            }
                                        } else {
                                            echo '
                                            <div class="col-12 container">
                                                <center style="margin-top: 30px;"><h4><b>No Result found of any correspondence!</b></h4></center>
                                            </div>';
                                        }
                                        echo '
                                    </div>';

                                    if((cleanvars($_SESSION['userlogininfo']['LOGINIDA']) == $valueTask['id_added']) && ($valueTask['complaint_status'] != 3)) {
                                        echo '
                                        <div class="col-12 container" style="padding-top: 5px;">
                                            <div style="display: flex; align-items: center; border: 1px solid lightblue; background-color: white; padding: 5px;">
                                                <input type="text" class="form-control" name="message" id="message" style="border: none; width: 100%; height:70px!important;" autofocus placeholder="Write your message here" value="">
                                                <input type="file" name="attachment" id="attachment">
                                                <button type="submit" style="" class="btn btn-lg btn-primary" name="send_message" id="send_text" onClick=>Send</button>
                                            </div>
                                        </div>';
                                    }
                                echo '
                                </div>
                            </div>
                        </div>';
                    echo '
                </div>
                <input type="hidden" name="tid" id="tid" value="'.$_GET['id'].'">
            </form>
        </div>
    </div>
    <script>
        // To scroll to the bottom of a div
        const theElement = document.getElementById(\'msgbox\');
        
        const scrollToBottom = (node) => {
            node.scrollTop = node.scrollHeight;
        }
        
        scrollToBottom(theElement);
    </script>
    <script>
        $("#status").select2({
            allowClear: true
        });
    </script>';
}
?>