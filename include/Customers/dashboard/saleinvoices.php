<?php 
echo '
                          
    <div class="row mb-none-30  mt-10">
	<h2 style="margin-left:20px; font-weight:600; margin-bottom:5px; color:blue;">Sale Invoices</h2>
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.$valueinvoices['totalInvoices'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Invoices</span>
                    </div>
                    <a href="sales-invoice.php?sts=all" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.$valueinvoices['totalCompleted'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Completed</span>
                    </div>
                    <a href="sales-invoice.php?sts=5" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.$valueinvoices['totalConfirmed'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Confirmed</span>
                    </div>

                    <a href="sales-invoice.php?sts=3" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--orange b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" style="font-size:30px;">'.$valueinvoices['totalPending'].'</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="font-size:20px;">Total Pending</span>
                    </div>

                    <a href="sales-invoice.php?sts=1" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                </div>
            </div>
        </div>
		<!-- dashboard-w1 end -->


    </div>
	<!-- row end-->';