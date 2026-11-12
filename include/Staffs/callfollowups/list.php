<?php
if(!isset($_GET['id']) && !isset($_GET['del']) && !$view) {

	if (!($Limit))   { $Limit = 100; }  
	if ($page == "") { $page  = 1;  }

	// $queryComplaintsCount  = $dblms->querylms("SELECT COUNT(CASE WHEN c.call_id  != '0' then 1 else null end) total,     
	// 											COUNT(CASE WHEN c.complaint_status = '1' then 1 else null end) notStarted,
	// 											COUNT(CASE WHEN c.complaint_status = '2' then 1 else null end) inProgress,
	// 											COUNT(CASE WHEN c.complaint_status = '3' then 1 else null end) completed
	// 											FROM ".COMPLAINTS." c
	// 											WHERE  c.is_deleted != 1 $sql2");
	// $valueComplaintsCount = mysqli_fetch_assoc($queryComplaintsCount);
	
	echo '
	<!-- div class="row row-sm" style="margin-top:5px;">

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
		</a>
		
		<a href="?status=2">
			<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-sm-t-0">
				<div class="bg-primary rounded overflow-hidden">
				<div class="pd-25 d-flex align-items-center">
					<i class="fa fa-undo tx-40 lh-0 tx-white op-7"></i>
					<div class="mg-l-20">
					<p class="tx-12 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white mg-b-10">Today\'s Calls</p>
					<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueComplaintsCount['inProgress'].'</p>
					</div>
				</div>
				</div>
			</div>
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
		</a>
		
	</div -->
	<!-- row -->';

	$queryTasks  = $dblms->querylms("SELECT c.call_id  
											FROM ".CALL_FOLLOWUPS." c
											INNER JOIN ".CUSTOMERS." cu ON c.id_customer = cu.customer_id
											WHERE c.is_deleted != 1 $sql2 $sql3
											ORDER BY c.call_id  DESC");
	$count 		   = mysqli_num_rows($queryTasks);
	$NumberOfPages = ceil($count/$Limit);
	$queryTasks  = $dblms->querylms("SELECT c.*, cu.customer_name, cu.customer_code
											FROM ".CALL_FOLLOWUPS." c 
											INNER JOIN ".CUSTOMERS." cu ON c.id_customer = cu.customer_id
											WHERE c.is_deleted != 1 $sql2 $sql3
											ORDER BY c.call_id  DESC LIMIT ".($page-1)*$Limit .",$Limit");
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
					<th style="font-weight:600;width:300px;">Customer</th>
					<th style="font-weight:600;width:100px;text-align:center;">Contact Person</th>
					<th style="font-weight:600;width:100px;text-align:center;">Phone</th>
					<th style="font-weight:600;width:150px;text-align:center;">Purpose</th>
					<th style="font-weight:600;width:150px;text-align:center;">Next Follow-up</th>
					<th style="font-weight:600;width:150px;text-align:center;">Remarks</th>
					<th style="font-weight:600;width:120px;text-align:center;">Status</th>
					<th style="font-weight:600;width:90px;text-align:center;">Actions</th>
				</tr>
			</thead>
			<tbody>';
			$srno = 0;

			while($valuecalllog  = mysqli_fetch_array($queryTasks)) {

				$srno++;
				echo '
				<tr>
					<td style="vertical-align:middle;text-align:center;">'.$srno.'</td>
					<td style="vertical-align:middle;">'.$valuecalllog['customer_code'].'-'.$valuecalllog['customer_name'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.$valuecalllog['contact_person'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.$valuecalllog['phone'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.$valuecalllog['purpose'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.($valuecalllog['next_followup'] == '0000-00-00' ? '_' : $valuecalllog['next_followup']).'</td>
					<td style="vertical-align:middle;text-align:center;">'.$valuecalllog['remarks'].'</td>
					<td style="vertical-align:middle;text-align:center;">'.get_call_status($valuecalllog['call_status']).'</td>
					<td style="vertical-align:middle;text-align:center;">
						<a href="callfollowups.php?id='.$valuecalllog['call_id'].'&edit" class="btn btn-xs btn-info" title="Edit Task"><i class="icon-pencil"></i></a>
						<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a> 
					</td>
				</tr>';
				
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
				$Nav .= '<li><a href="callfollowups.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
			} 
			for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
				if($i == $page) { 
					$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
				} else { 
					$Nav .= '<li><a href="callfollowups.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
				}
			} 
			if($page < $NumberOfPages) { 
				$Nav .= '<li><a href="callfollowups.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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