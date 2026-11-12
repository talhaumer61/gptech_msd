<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	include "functions/db_functions.php";
	include "functions/pagination.php";
	$mainclass	= new main();
	$Pagination	= new Pagination();
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '28')) { 
	
	include_once("include/donationgifts/query.php");
	include_once("include/header.php");
//----------------------------------------
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$vendor 	= (isset($_REQUEST['vendor']) && $_REQUEST['vendor'] != '') ? $_REQUEST['vendor'] : '';
	$printid	= (isset($_GET['printid']) && $_GET['printid'] != '') ? $_GET['printid'] : '';
	$estprintid	= (isset($_GET['estprintid']) && $_GET['estprintid'] != '') ? $_GET['estprintid'] : '';
//----------------------------------------
    if(($srch)) { 
        $sql2 	.= "AND (
                           d.pr_no LIKE '".$srch."' OR d.customer_name LIKE '".$srch."'  
                        )";
        $sqlstring	.= "&srch=".$srch;
    }

// get all Items
	$Items		= $mainclass->get_items();
	$crs		= $mainclass->get_allcrs();
//----------------------------------------
echo '<title>Manage Donations / Gifts  - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_CLIENTS_SEARCH-->
<div class="navbar navbar-default" role="navigation">
<!-- .container-fluid -->
<div class="container-fluid">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
</div>
<!-- .navbar-collapse -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<form class="navbar-form navbar-left form-small" action="" method="get">
	<div class="form-group">
		<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:350px;" >
	</div>
	
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="donationgifts.php" class="btn btn-purple"><i class="icon-list"></i> All</a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'add' => '1'))) { 	
	echo '<a class="btn btn-success" href="donationgifts.php?view=add"><i class="icon-plus"></i> Add Record</a> 
			<a class="btn btn-purple" href="donationgifts.php?view=estimates"><i class="icon-list"></i> Estimates</a> 
			<a class="btn btn-info" href="donationgifts.php?view=addestimate"><i class="icon-plus"></i> Add Estimate</a> ';
}
echo '
</form>
</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//----------------------------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
	if($printid) {
		echo "<script language=\"javascript\">window.open(\"donationgiftsprint.php?id=$printid\",\"_blank\");</script>";
	} else  {
		echo "<script language=\"javascript\">window.open(\"donationgiftsestimateprint.php?id=$estprintid\",\"_blank\");</script>";
	}
}
//----------------------------------------------------------
	include_once("include/donationgifts/list.php");
	include_once("include/donationgifts/listestimates.php");
    include_once("include/donationgifts/add.php");
    include_once("include/donationgifts/addestimate.php");
	include_once("include/donationgifts/addcopied.php");
    include_once("include/donationgifts/edit.php");
    include_once("include/donationgifts/editestimate.php");
    
//----------------------------------------------------------
echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->   
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
	include_once("include/donationgifts/dispatch-modal.php");
echo '

<!--WI_IFRAME_MODAL-->
<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
				<h4 class="modal-title" style="font-weight:700;"> Confirmation Alert!</h4>
			</div>
            <form action="" method="POST">
				<div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-information" data-dismiss="modal" aria-hidden="true">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script src="js/donationgifts.js"></script>
<script src="js/stockin.js"></script>
 <script>
        (function($) {
            "use strict";
            $(document).on(\'click\', \'.confirmationBtn\', function() {
                var modal = $(\'#confirmationModal\');
                let data = $(this).data();
                modal.find(\'.question\').text(`${data.question}`);
                modal.find(\'form\').attr(\'action\', `${data.action}`);
                modal.modal(\'show\');
            });
        })(jQuery);
    </script>
<script>

	function getPrdgiftValue(id_item, srno) {  
		$.ajax({  
			type: "POST",  
			url: "include/ajax/getPrdgiftValue.php",  
			data: "id_item="+id_item+"&srno="+srno,  
			success: function(msg){  
				$("#getPrdValue_"+srno).html(msg); 
			}
		});  
	}
	
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
    $("#top-list1").select2({
        allowClear: true
    });	
	
	$("#vendor-list").select2({
        allowClear: true
    });	
	
	
</script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
} else { 
	header('location: index.php');
}
?>