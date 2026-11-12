<?php 
include_once("dashboard/query.php");
echo '<title>'.TITLE_HEADER.' Dashboard</title>

<!-- Matter -->

<div class="matter">
<!--WI_HEADING_BAR-->
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="images/default.png" alt=""/></div>
	<div class="headerbar-project-title pull-left">
		<h3>'.$_SESSION['userlogininfo']['LOGINNAME'].' - Welcome Back</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINNAME'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<!--WI_HEADING_BAR-->
<div class="container">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
//if($_SESSION['userlogininfo']['LOGINIDA'] == 2 ||  $_SESSION['userlogininfo']['LOGINTYPE'] == 1 || $_SESSION['userlogininfo']['LOGINTYPE'] == 2) {
// include files
	include_once("dashboard/joborders.php");
	include_once("dashboard/stocks.php");
	include_once("dashboard/saleinvoices.php");
	include_once("dashboard/latest_joborders-invoices.php");
 	include_once("dashboard/graph_last-30-days.php");
 	
echo '

	<div style="clear:both;"></div>';
//-------------------------------------------


//-------------------------------------------
echo '      

</div>
<!--WI_TASKS_AND_PINNED_PROJECTS-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
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
<!----------------------COMMON FOOTER--------------------------------->
<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
<!--WI_IFRAME_MODAL-->
<div class="row">
  <div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <!--full screen icon - custom.js-->
          <button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
          <!--full screen icon - custom.js-->
          <h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <iframe frameborder="0" class="slimScrollBarModal----"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--WI_IFRAME_MODAL-->

    <!--------------------COMMON FOOTER JAVASCRIPT---------------------------->
    <!-- REQUIRED - ALL VENDORS -->
    <script type="text/javascript" src="js/custom/all-vendors.js"></script>
    <!-- REQUIRED - ALL VENDORS -->

    <!--REQUIRED - footable.js (included in all-vendors.js)-->
    <script type="text/javascript">
        $(function () {
            $(".footable").footable();
            
        });
    </script>
    <!--REQUIRED - footable.js -->

    <!-- CUSTOM -->
    <script type="text/javascript" src="js/custom/custom.js"></script>
    <!-- CUSTOM -->

    <!-- CUSTOM GENERAL -->
    <script type="text/javascript" src="js/custom/custom.general.js"></script>
    <!-- CUSTOM GENERAL -->

    <!--------------------COMMON FOOTER JAVASCRIPT---------------------------->

</body>
</html>';