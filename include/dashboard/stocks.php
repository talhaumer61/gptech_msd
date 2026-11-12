<?php 
echo '
   <div class="row mb-none-30 mt-30">
   <h2 style="margin-left:20px; font-weight:600; margin-top:0; color:#333;">Item Stock</h2>
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.number_format($resulttotalInOut['AllStockIn']).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Total Stock</span>
                    </div>
                    <a href="stockledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1  bg--cyan b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.number_format($resulttotalInOut['AllStockOUT']).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">Stock Out</span>
                    </div>
                    <a href="stockledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">'.number_format($resulttotalInOut['AllStockIn'] -$resulttotalInOut['AllStockOUT']).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">STOCK AVAIABLE</span>
                    </div>

                    <a href="stockledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->


    </div>
	<!-- row end-->';