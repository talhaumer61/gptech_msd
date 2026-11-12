<?php 
include_once("profilequery.php");
//----------------------------------------
echo '<title>Manage Account - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_TITLE_BAR-->
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="images/default.png" alt="'.$_SESSION['userlogininfo']['LOGINNAME'].'"/></div>
	<div class="headerbar-project-title pull-left"><h3><b>'.$_SESSION['userlogininfo']['LOGINNAME'].'</b></h3></div>
	<div class="clearfix"></div>
</div>
<!--WI_TITLE_BAR-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//----------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}
//------------------------------------------------
	$conditions = array ( 
								  'select' 		=> '*'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_loginid =  ".ADMINS.".adm_id"
								, 'where' 		=> array ( 
															''.ADMINS.'.adm_id' => $_SESSION['userlogininfo']['LOGINIDA']
														) 
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
						); 
    $rowstd = $dblms->getRows(ADMINS, $conditions);
	// get all City
	$cityconditions = array ( 
								  'select' 		=> 'city_id, city_name, city_code'
								, 'where' 		=> array( 
															'city_status' => 1 
														)
								, 'order_by' 	=> 'city_name ASC'
								, 'return_type' => 'all' 
							); 
    $Cities = $dblms->getRows(CITIES, $cityconditions);
//-----------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:80%;">
<form class="form-horizontal" action="myaccount.php" method="post" id="editInq">
<input type="hidden" name="customerid" id="customerid" value="'.$rowstd['customer_id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'dashboard.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Manage Profile</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b>Full Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_fullname" name="adm_fullname" value="'.$rowstd['adm_fullname'].'" readonly>
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req"> Login ID/ Email</label>
			<input type="text" class="form-control" id="adm_username" name="adm_username" value="'.$rowstd['adm_username'].'" readonly>
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label> Login Password</label>
			<input type="password" class="form-control" id="adm_userpass" name="adm_userpass" autocomplete="off">
		</div>
	</div>

	<div style="clear:both;"></div>

	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label>Organization Phone #</label>
			<input type="text" class="form-control" id="customer_cellno" name="customer_cellno" autocomplete="off" value="'.$rowstd['customer_cellno'].'">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="customer_email" name="customer_email" autocomplete="off" value="'.$rowstd['customer_email'].'">
		</div> 
	</div>


	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Name of Contact Person</label>
			<input type="text" class="form-control" id="customer_contactperson" name="customer_contactperson" autocomplete="off" value="'.$rowstd['customer_contactperson'].'">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="customer_personcell" name="customer_personcell" autocomplete="off" value="'.$rowstd['customer_personcell'].'">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Whatsapp #</label>
			<input type="text" class="form-control" id="customer_personwhatsapp" name="customer_personwhatsapp" autocomplete="off" value="'.$rowstd['customer_personwhatsapp'].'">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Address</label>
			<input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off" value="'.$rowstd['customer_address'].'">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>City</label>
			<select id="id_city" name="id_city" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($Cities as $listcity) { 
				if($listcity['city_id'] == $rowstd['id_city']) {
					echo '<option value="'.$listcity['city_id'].'" selected>'.$listcity['city_name'].'</option>';
				} else {
					echo '<option value="'.$listcity['city_id'].'">'.$listcity['city_name'].'</option>';
				}
				
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>	

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Update Changes" id="submit_changes" name="submit_changes">
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
<!--WI_NOTIFICATION-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>

<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->';
?>
<!--JS_SELECT_LISTS-->
<script>

	$("#deficiency_status").select2({
		allowClear: true
	});

	$("#id_city").select2({
		allowClear: true
	});
	$("#projects-list1").select2({
		allowClear: true
	});
	$("#projects-list2").select2({
		allowClear: true
	});

	
</script>
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $('.pickadate').datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>
