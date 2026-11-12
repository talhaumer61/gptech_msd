<?php 
echo '
                          
    <div class="row mb-none-30  mt-10">
	<h2 style="margin-left:20px; font-weight:600; margin-top:0; color:cornflowerblue;">Job Orders</h2>
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.$valueorders['Totalorders'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Total Orders</span>
                    </div>
                    <a href="sale-orders.php?sts=all" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.$valueorders['totalDispatched'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Total Dispatched</span>
                    </div>
                    <a href="sale-orders.php?sts=4" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
      
		<!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--5 b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.$valueorders['totalSaveHold'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Total Save & Hold</span>
                    </div>

                    <a href="sale-orders.php?sts=1" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		
		 <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--orange b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.$valueorders['totalPending'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Total Pending</span>
                    </div>

                    <a href="sale-orders.php?sts=2" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->


    </div>
	<!-- row end-->';