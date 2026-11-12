<?php
if(!isset($_GET['id']) && !isset($_GET['del']) && !$view) {

	if (!($Limit))   { $Limit = 100; }  
	if ($page == "") { $page  = 1;  }

	$queryComplaintsCount  = $dblms->querylms("SELECT COUNT(CASE WHEN c.complaint_id != '0' then 1 else null end) total,     
												COUNT(CASE WHEN c.complaint_status = '1' then 1 else null end) notStarted,
												COUNT(CASE WHEN c.complaint_status = '2' then 1 else null end) inProgress,
												COUNT(CASE WHEN c.complaint_status = '3' then 1 else null end) completed
												FROM ".COMPLAINTS." c
												WHERE c.id_customer = '".cleanvars($id_customer)."' 
												AND c.is_deleted != 1 $sql2");
	$valueComplaintsCount = mysqli_fetch_assoc($queryComplaintsCount);
	
	echo '
	<div class="row row-sm" style="margin-top:5px;">

		<a href="?status=">
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="bg-teal rounded overflow-hidden">
				<div class="pd-25 d-flex align-items-center">
					<i class="fa fa-tasks tx-40 lh-0 tx-white op-7"></i>
					<div class="mg-l-20">
					<p class="tx-12 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white mg-b-10">Total Tasks</p>
					<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueComplaintsCount['total'].'</p>
					</div>
				</div>
				</div>
			</div>
			<!-- col-3 -->
		</a>
		
		<a href="?status=1">
			<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
				<div class="bg-orange rounded overflow-hidden">
				<div class="pd-25 d-flex align-items-center">
					<i class="fa fa-file tx-40 lh-0 tx-white op-7"></i>
					<div class="mg-l-20">
					<p class="tx-12 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white mg-b-10">To Do</p>
					<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueComplaintsCount['notStarted'].'</p>
					</div>
				</div>
				</div>
			</div>
			<!-- col-3 -->
		</a>
		
		<a href="?status=2">
			<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-sm-t-0">
				<div class="bg-primary rounded overflow-hidden">
				<div class="pd-25 d-flex align-items-center">
					<i class="fa fa-undo tx-40 lh-0 tx-white op-7"></i>
					<div class="mg-l-20">
					<p class="tx-12 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white mg-b-10">In Progress</p>
					<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueComplaintsCount['inProgress'].'</p>
					</div>
				</div>
				</div>
			</div>
			<!-- col-3 -->
		</a>

		<a href="?status=3">
			<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-sm-t-0">
				<div class="bg-success rounded overflow-hidden">
				<div class="pd-25 d-flex align-items-center">
					<i class="fa fa-check tx-40 lh-0 tx-white op-7"></i>
					<div class="mg-l-20">
					<p class="tx-12 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white mg-b-10">Completed</p>
					<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueComplaintsCount['completed'].'</p>
					</div>
				</div>
				</div>
			</div>
			<!-- col-3 -->
		</a>
		
	</div>
	<!-- row -->';

	$queryTasks  = $dblms->querylms("SELECT c.complaint_id 
											FROM ".COMPLAINTS." c
											WHERE c.id_customer	= '".$id_customer."' 
											AND c.is_deleted != 1 $sql2 $sql3
											ORDER BY c.complaint_id DESC");
	$count 		   = mysqli_num_rows($queryTasks);
	$NumberOfPages = ceil($count/$Limit);
	
	$queryTasks  = $dblms->querylms("SELECT c.*
											FROM ".COMPLAINTS." c 
											WHERE c.id_customer	= '".$id_customer."' 
											AND c.is_deleted != 1 $sql2 $sql3
											ORDER BY c.complaint_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
	if(mysqli_num_rows($queryTasks) > 0) {
		
		echo '
		<div class="widget">
		<div class="widget-content">
		<div style=" float:right; text-align:right; font-weight:700; color:red; margin-right:10px;"> 
			<form class="navbar-form navbar-left form-small" action="" method="post" target="_blank">
				<span style="font-weight:600;color:blue; margin-right:20px;">Total Records ('.$count.')</span>
				<!--
				<input type="hidden" name="type" value="">
				<input type="hidden" name="print_sql" value="">
				<button type="submit" class="btn btn-primary">Export</button>
				-->
			</form>
		</div>
		<div style="clear:both;"></div>
		<table class="footable table table-bordered table-hover">
			<thead>
				<tr>
					<th style="font-weight:600;width:50px;text-align:center;">Sr. #</th>
					<th style="font-weight:600;width:300px;">Title</th>
					<th style="font-weight:600;width:100px;text-align:center;">Department</th>
					<th style="font-weight:600;width:100px;text-align:center;">Priority</th>
					<th style="font-weight:600;width:150px;text-align:center;">Time</th>
					<th style="font-weight:600;width:120px;text-align:center;">Status</th>
					<th style="font-weight:600;width:90px;text-align:center;">Actions</th>
				</tr>
			</thead>
			<tbody>';
			$srno = 0;

			while($valueTask  = mysqli_fetch_array($queryTasks)) {

				$srno++;
				
				if($valueTask['complaint_attachment'] != '') {
					$download     = '<span class="badge" style="background-color: purple;"><a href="downloads/complaints/'.$valueTask['complaint_attachment'].'" class="text-white" target="_blank"><i class="fa fa-download"></i></a></span>';
				} else {
					$download     = '';
				}


				if($valueTask['complaint_status'] == 3 && $valueTask['completion_date'] != '0000-00-00'){

					$completionDate = date('d-m-Y', strtotime($valueTask['completion_date']));

				}


				$unSeenMessages = '';
				$queryTaskMessagesViewed  = $dblms->querylms("SELECT COUNT(cm.id) as totalUnSeen
																FROM ".COMPLAINTS_MESSAGE." cm
																WHERE cm.id_complaint = '".$valueTask['complaint_id']."'
																AND (cm.id > (SELECT mv.last_read FROM ".COMPLAINTS_MESSAGE_VIEW." mv 
																				WHERE mv.id_admin = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ."'
																				AND mv.id_complaint = '".$valueTask['complaint_id']."' ORDER BY mv.id DESC LIMIT 1
																			)
																	OR 0 = (SELECT COUNT(mv.id) FROM ".COMPLAINTS_MESSAGE_VIEW." mv 
																	WHERE mv.id_admin = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ."'
																	AND mv.id_complaint = '".$valueTask['complaint_id']."' ORDER BY mv.id DESC LIMIT 1
																			)
																	)
																");
				$valueTaskMessagesViewed  = mysqli_fetch_array($queryTaskMessagesViewed);
				if($valueTaskMessagesViewed['totalUnSeen'] > 0){

					$unSeenMessages = ' <span style="font-size:10px;padding-top:-10px!important;">'.$valueTaskMessagesViewed['totalUnSeen'].'</span>';

				}


				echo '
				<tr>
					<td style="vertical-align:middle;text-align:center;">'.$srno.'</td>
					<td style="vertical-align:middle;">'.$valueTask['complaint_title'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.$departments[$valueTask['id_dept']].'</td>
					<td style="vertical-align:middle;text-align:center;">'.get_priority_level($valueTask['complaint_priority']).'</td>
					<td style="vertical-align:middle;text-align:center;"><div class="btn btn-xs btn-danger"><span id="demo'.$srno.'"></span></div></td>
					<td style="vertical-align:middle;text-align:center;">'.get_complaint_status($valueTask['complaint_status']).'</td>
					<td style="vertical-align:middle;text-align:center;">';
						if($valueTask['id_added'] == cleanvars($_SESSION['userlogininfo']['LOGINIDA']) && $valueTask['complaint_status'] == 1) {
							echo '<a href="complaints.php?id='.$valueTask['complaint_id'].'&edit" class="btn btn-xs btn-info" title="Edit Task"><i class="icon-pencil"></i></a>';
						}
						echo '
						'.$download.'
						<a href="complaints.php?id='.$valueTask['complaint_id'].'&view=messages" class="badge bg-purple" title="Task Correspondence"><i class="fa fa-comment"></i>'.$unSeenMessages.'</a>
					</td>
				</tr>';

				if($valueTask['complaint_status'] != 3){

					$addedDateTime = date('Y-m-d H:i:s', strtotime($valueTask['date_added']));

					echo '
					<script>
						var addedDate'.$srno.' = new Date("'.$addedDateTime.'".replace(" ", "T")).getTime();

						var x'.$srno.' = setInterval(function() {

							var now'.$srno.' = new Date().getTime();

							// Calculate elapsed time
							var distance'.$srno.' = now'.$srno.' - addedDate'.$srno.';

							if (distance'.$srno.' < 0) {
								document.getElementById("demo'.$srno.'").innerHTML = "Not started yet";
								return;
							}

							var days'.$srno.' = Math.floor(distance'.$srno.' / (1000 * 60 * 60 * 24));
							var hours'.$srno.' = Math.floor((distance'.$srno.' % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes'.$srno.' = Math.floor((distance'.$srno.' % (1000 * 60 * 60)) / (1000 * 60));
							var seconds'.$srno.' = Math.floor((distance'.$srno.' % (1000 * 60)) / 1000);

							var elapsed'.$srno.' = "";

							if (days'.$srno.' > 0) {
								elapsed'.$srno.' += days'.$srno.' + "d ";
							}

							elapsed'.$srno.' += hours'.$srno.' + "h " + minutes'.$srno.' + "m " + seconds'.$srno.' + "s";

							document.getElementById("demo'.$srno.'").innerHTML = elapsed'.$srno.';

						}, 1000);
					</script>';

				} else {

					echo '
					<script>

						// Display the result in the element with id="demo"
						document.getElementById("demo'.$srno.'").innerHTML = "'.$completionDate.'";
					
					</script>';

				}
				
			}
			echo '
			</tbody>
		</table><br>';

		if($count>$Limit) {

			echo '
			<div class="widget-foot">
			<!--WI_PAGINATION-->
			<ul class="pagination pull-right">';
				$Nav= ""; 
			if($page > 1) { 
				$Nav .= '<li><a href="examstudentsgraduation.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
			} 
			for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
				if($i == $page) { 
					$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
				} else { 
					$Nav .= '<li><a href="examstudentsgraduation.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
				}
			} 
			if($page < $NumberOfPages) { 
				$Nav .= '<li><a href="examstudentsgraduation.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
			} 
				echo $Nav;
			echo '
			</ul>
			<!--WI_PAGINATION-->
				<div class="clearfix"></div>
			</div>';
		}

		echo '</div>
		</div>';
	
	} else { 
	
		echo '
		<div class="widget">
			<div class="widget-content">
				<div class="col-lg-12">
					<div class="widget-tabs-notification">No Result Found</div>
				</div>
			</div>
		</div>';
	
	}

}