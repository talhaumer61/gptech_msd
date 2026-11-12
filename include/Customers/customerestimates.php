<?php 
	
	include_once("estimates/query.php");
	$sql2 		= '';
	$sqlstring	= "";
	$srch		= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$vendor 	= (isset($_REQUEST['vendor']) && $_REQUEST['vendor'] != '') ? $_REQUEST['vendor'] : '';
    if(($srch)) { 
        $sql2 	.= "AND (
                           pr_no LIKE '".$srch."' OR customer_name LIKE '".$srch."'  
                        )";
        $sqlstring	.= "&srch=".$srch;
    }
	echo '<title>Manage Estimates  - '.TITLE_HEADER.'</title>
	<div class="matter">
		<div class="navbar navbar-default" role="navigation">';
			if(LMS_VIEW != 'add'){
				echo '
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<form class="navbar-form navbar-left form-small" action="" method="get">
							<div class="form-group">
								<input type="text" class="form-control" name="srch" placeholder="Name, code" style="width:350px;" >
							</div>
							
							<button type="submit" class="btn btn-primary">Search</button>
							<a href="customerestimates.php" class="btn btn-purple"><i class="icon-list"></i> All</a>  
							<a class="btn btn-success" href="customerestimates.php?view=add"><i class="icon-plus"></i> Add Record</a> 
						</form>
					</div>
				</div>';
			}
			echo '
		</div>
		<div class="container">
			<div class="row fullscreen-mode">
				<div class="col-md-12">';
					if(isset($_SESSION['msg'])) { 
						echo $_SESSION['msg']['status'];
						unset($_SESSION['msg']);
					}
					if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 
						include_once("estimates/add.php");
					}else{
						echo '
						<div class="widget">
							<div class="widget-content">';
								include_once("estimates/list.php");
								include_once("estimates/checkout.php");
								include_once("estimates/edit.php");
								include_once("estimates/convertjoborder.php");
								include_once("estimates/payments.php");
								echo '
							</div>
						</div>';
					}
					echo '
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="clearfix"></div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
				</div>
			</div>
		</div>
	</footer>

	<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';

	echo '
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
	<script>
		function get_PrdEstimateValue(id_item, srno) {  
			var idcustomer = $("#id_customer").val();
			$.ajax({  
				type: "POST",  
				url: "include/ajax/get_PrdEstimateValue.php",  
				data: "idcustomer="+idcustomer+"&id_item="+id_item+"&srno="+srno,  
				success: function(msg){  
					$("#getPrdEstimateValue_"+srno).html(msg); 
				}
			});  
		}
		$("#top-list1").select2({
			allowClear: true
		});	
		
		$("#vendor-list").select2({
			allowClear: true
		});	
		//USED BY: All date picking forms
		$(document).ready(function(){
			$(".pickadate").datepicker({
			format: "dd-mm-yyyy",
			language: "lang",
			autoclose: true,
			todayHighlight: true
			});	
		});
		$(function () {
			$(".footable").footable();
		});
	</script>
	<script type="text/javascript" src="js/custom/all-vendors.js"></script>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
</body>
</html>';
if (!empty($_SESSION['profile_incomplete']) && $_SESSION['profile_incomplete']):
  echo '
  <script>
    $(document).ready(function() {
        $("#profileIncompleteModal").modal({
            backdrop: \'static\',
            keyboard: false
        });
    });
  </script>

  <div class="modal fade" id="profileIncompleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width:600px;">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title"> ⚠️ Important: Complete Your Profile</h5>
        </div>
        <div class="modal-body">
          <p style="font-size:16px;">Dear '.$_SESSION['userlogininfo']['LOGINNAME'].',<br><br>
            To proceed further, please complete your profile.<br>
            This helps ensure smooth communication, accurate order processing, and service delivery.
          </p>
          <div class="text-center mt-3">
            <a href="myaccount.php" class="btn btn-primary">
              👉 Click here to update your profile
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>';
endif;
?>