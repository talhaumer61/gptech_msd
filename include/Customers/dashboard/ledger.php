<?php 
echo '
   <div class="row mb-none-30 mt-30">
   <h2 style="margin-left:20px; font-weight:600; margin-bottom:5px; color:orangered;">My Ledger</h2>
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--orange b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.number_format(($valuedebitcrdit['TotalDebit'])).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Payable</span>
                    </div>
                    <a href="customerledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.number_format($valuedebitcrdit['TotalCredit']).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Paid</span>
                    </div>
                    <a href="customerledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--red b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.number_format(($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit'])).'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Balance</span>
                    </div>

                    <a href="customerledger.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->


    </div>
	<!-- row end-->';