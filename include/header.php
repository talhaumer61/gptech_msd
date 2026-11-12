<?php 
echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/line-awesome.min.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- PNOTIFY NOTIFICATIONS CSS -->
<link href="style/pnotify.custom.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
	.col-sm-100 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-100 {float:left}
	.col-sm-100 {width:100%}
	
	.col-sm-81 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-81 {float:left}
	.col-sm-81{width:67%;}
	
	.col-sm-61 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-61 {float:left}
	.col-sm-61{width:50%;}
	
	.col-sm-62 { position:relative;min-height:1px;padding-right:20px;padding-left:1px; }
	.col-sm-62 { float:left; }
	.col-sm-62 { width:60%; }
	
	.col-sm-51 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-51 {float:left}
	.col-sm-51 {width:40%}
	
	.col-sm-41 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-41 {float:left}
	.col-sm-41{width:33%}
	
	.col-sm-32 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-32 {float:left}
	.col-sm-32 {width:25%}
	
	.col-sm-31 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-31 {float:left}
	.col-sm-31{width:20%}
	
	.col-sm-25 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-25 {float:left}
	.col-sm-25{width:15%}

    .col-sm-15 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-15 {float:left}
	.col-sm-15{width:9%}
	
	.req:after {content:"*";font-size:14px;color:#cc0000;padding-left:4px}
	.form_sep + .form_sep {margin-top:5px;padding-top:5px;border-top:1px dashed #e3e3e3}
	.form_sep:before,.form_sep:after {content:"";display:table;}
	.form_sep:after {clear:both;}
	
	.alert-box {
		color:#555;	border-radius:10px;	font-family:Tahoma,Geneva,Arial,sans-serif;font-size:13px; padding:10px 36px; margin:20px 100px 20px 100px;
	}
	.alert-box span { font-weight:bold; text-transform:uppercase; }
	.error { background:#ffecec url("images/error.png") no-repeat 10px 50%; border:1px solid #f5aca6; }
	.success { background:#e9ffd9 url("images/success.png") no-repeat 10px 50%;	border:1px solid #a6ca8a; }
	.warning { background:#fff8c4 url("images/warning.png") no-repeat 10px 50%;	border:1px solid #f2c779; }
	.notice { background:#e3f7fc url("images/notice.png") no-repeat 10px 50%; border:1px solid #8ed9f6; }
	.inv_clone_btn {cursor:pointer; }
	.inv_remove_btn {cursor:pointer; }
	input::-webkit-calendar-picker-indicator {
  display: none;
}

.my-5 { margin: 5px 0; } .my-10 { margin: 10px 0; } .my-15 {margin: 15px 0;} .my-20 {margin: 20px 0;} .my-25 {margin: 25px 0;} .my-30 {margin: 30px 0; } .my-35 { margin: 35px 0; }
.my-40 { margin: 40px 0; } .my-45 { margin: 45px 0; } .my-50 { margin: 50px 0; } .my-55 { margin: 55px 0; } .my-60 { margin: 60px 0; } .my-65 { margin: 65px 0; } .my-70 { margin: 70px 0;}
.my-75 { margin: 75px 0; } .my-80 { margin: 80px 0; } .my-85 { margin: 85px 0; } .my-90 { margin: 90px 0; } .my-95 { margin: 95px 0; } .my-100 { margin: 100px 0; } .mx-5 { margin: 0 5px; }
.mx-10 { margin: 0 10px; } .mx-15 { margin: 0 15px; } .mx-20 { margin: 0 20px; } .mx-25 { margin: 0 25px; } .mx-30 { margin: 0 30px; } .mx-35 {  margin: 0 35px; } .mx-40 { margin: 0 40px; }
.mx-45 { margin: 0 45px; } .mx-50 { margin: 0 50px; } .mx-55 { margin: 0 55px; } .mx-60 { margin: 0 60px; } .mx-65 { margin: 0 65px; } .mx-70 { margin: 0 70px; } .mx-75 { margin: 0 75px; }
.mx-80 { margin: 0 80px; } .mx-85 { margin: 0 85px; } .mx-90 { margin: 0 90px; } .mx-95 { margin: 0 95px; } .mx-100 { margin: 0 100px; } .mt-3 { margin-top: 3px; }.mt-5 { margin-top: 5px; } .mt-10 { margin-top: 10px; }
.mt-15 { margin-top: 15px; }  .mt-20 { margin-top: 20px; }  .mt-25 { margin-top: 25px; }  .mt-30 { margin-top: 30px; }  .mt-35 { margin-top: 35px; }  .mt-40 { margin-top: 40px; }  .mt-45 { margin-top: 45px; }  .mt-50 { margin-top: 50px; }  .mt-55 { margin-top: 55px; }  .mt-60 { margin-top: 60px; }  .mt-65 { margin-top: 65px; }  .mt-70 { margin-top: 70px; }  .mt-75 { margin-top: 75px; }  .mt-80 { margin-top: 80px; }  .mt-85 { margin-top: 85px; }  .mt-90 { margin-top: 90px; }  .mt-95 { margin-top: 95px; }  .mt-100 { margin-top: 100px; }  .mb-5 { margin-bottom: 5px; }  .mb-10 { margin-bottom: 10px; }  .mb-15 { margin-bottom: 15px; }  .mb-20 { margin-bottom: 20px; }  .mb-25 { margin-bottom: 25px; }  .mb-30 { margin-bottom: 30px; }  .mb-35 { margin-bottom: 35px; }  .mb-40 { margin-bottom: 40px; }  .mb-45 { margin-bottom: 45px; }  .mb-50 { margin-bottom: 50px; }  .mb-55 { margin-bottom: 55px; }  .mb-60 { margin-bottom: 60px; }  .mb-65 { margin-bottom: 65px; }  .mb-70 { margin-bottom: 70px; }  .mb-75 { margin-bottom: 75px; }  .mb-80 { margin-bottom: 80px; }  .mb-85 { margin-bottom: 85px; }  .mb-90 { margin-bottom: 90px; }  .mb-95 { margin-bottom: 95px; }  .mb-100 { margin-bottom: 100px; }  .ml-5 { margin-left: 5px; }  .ml-10 { margin-left: 10px; }  .ml-15 { margin-left: 15px; }  .ml-20 { margin-left: 20px; }  .ml-25 { margin-left: 25px; }  .ml-30 { margin-left: 30px; }  .ml-35 { margin-left: 35px; }  .ml-40 { margin-left: 40px; }  .ml-45 { margin-left: 45px; }  .ml-50 { margin-left: 50px; }  .ml-55 { margin-left: 55px; }  .ml-60 { margin-left: 60px; }  .ml-65 { margin-left: 65px; }  .ml-70 { margin-left: 70px; }  .ml-75 { margin-left: 75px; }  .ml-80 { margin-left: 80px; }  .ml-85 { margin-left: 85px; }  .ml-90 { margin-left: 90px; }  .ml-95 { margin-left: 95px; }  .ml-100 { margin-left: 100px; }  .mr-5 { margin-right: 5px; }  .mr-10 { margin-right: 10px; }  .mr-15 { margin-right: 15px; }  .mr-20 { margin-right: 20px; }  .mr-25 { margin-right: 25px; }  .mr-30 { margin-right: 30px; }  .mr-35 { margin-right: 35px; }  .mr-40 { margin-right: 40px; }  .mr-45 { margin-right: 45px; }  .mr-50 { margin-right: 50px; }  .mr-55 { margin-right: 55px; }  .mr-60 { margin-right: 60px; }  .mr-65 { margin-right: 65px; }  .mr-70 { margin-right: 70px; }  .mr-75 { margin-right: 75px; }  .mr-80 { margin-right: 80px; }  .mr-85 { margin-right: 85px; }  .mr-90 { margin-right: 90px; }  .mr-95 { margin-right: 95px; }  .mr-100 { margin-right: 100px; }  .my-none-5 { margin: -5px 0; }  .my-none-10 { margin: -10px 0; }  .my-none-15 { margin: -15px 0; }  .my-none-20 { margin: -20px 0; }  .my-none-25 { margin: -25px 0; }  .my-none-30 { margin: -30px 0; }  .my-none-35 { margin: -35px 0; }  .my-none-40 { margin: -40px 0; }  .my-none-45 { margin: -45px 0; }  .my-none-50 { margin: -50px 0; }  .mx-none-5 { margin: 0 -5px; }  .mx-none-10 { margin: 0 -10px; }  .mx-none-15 { margin: 0 -15px; }  .mx-none-20 { margin: 0 -20px; }  .mx-none-25 { margin: 0 -25px; }  .mx-none-30 { margin: 0 -30px; }  .mx-none-35 { margin: 0 -35px; }  .mx-none-40 { margin: 0 -40px; }  .mx-none-45 { margin: 0 -45px; }  .mx-none-50 { margin: 0 -50px; }  .mt-none-5 { margin-top: -5px; }  .mt-none-10 { margin-top: -10px; }  .mt-none-15 { margin-top: -15px; }  .mt-none-20 { margin-top: -20px; }  .mt-none-25 { margin-top: -25px; }  .mt-none-30 { margin-top: -30px; }  .mt-none-35 { margin-top: -35px; }  .mt-none-40 { margin-top: -40px; }  .mt-none-45 { margin-top: -45px; }  .mt-none-50 { margin-top: -50px; }  .mb-none-5 { margin-bottom: -5px; }  .mb-none-10 { margin-bottom: -10px; }  .mb-none-15 { margin-bottom: -15px; }  .mb-none-20 { margin-bottom: -20px; }  .mb-none-25 { margin-bottom: -25px; }  .mb-none-30 { margin-bottom: -30px; }  .mb-none-35 { margin-bottom: -35px; }  .mb-none-40 { margin-bottom: -40px; }  .mb-none-45 { margin-bottom: -45px; }  .mb-none-50 { margin-bottom: -50px; }



	
.dashboard-w1 {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    min-height: 130px;
    justify-content: flex-end;
    overflow: hidden;
    transition: all 0.3s;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -ms-transition: all 0.3s;
    -o-transition: all 0.3s;
    position: relative;
    align-items: center;
    padding: 30px 20px;
}

.dashboard-w1:hover {
    transform: translateY(-3px);
    -webkit-transform: translateY(-3px);
    -moz-transform: translateY(-3px);
    -ms-transform: translateY(-3px);
    -o-transform: translateY(-3px);
}

.dashboard-w1 .icon {
    position: absolute;
    bottom: 0;
    left: 0;
}

.dashboard-w1 .icon i {
    font-size: 75px;
    color: rgba(255, 255, 255, 0.15);
    margin-left: -15px;
    margin-bottom: -4px;
}

.dashboard-w1 .details {
    text-align: right;
}

.dashboard-w1 .details .status,
.dashboard-w1 .details .amount,
.dashboard-w1 .details .currency-sign {
    color: #ffffff;
    font-size: 24px;
    font-weight: 500;
    line-height: 1;
}

.dashboard-w1 .details .desciption span {
    color: #ffffff;
    font-size: 14px;
    font-weight: 300;
    display: inline-block;
    margin-top: 5px;
}

.text--primary {
    color: #7367f0 !important;
}

.text--secondary {
    color: #868e96 !important;
}

.text--success {
    color: #28c76f !important;
}

.text--danger {
    color: #ea5455 !important;
}

.text--warning {
    color: #ff9f43 !important;
}

.text--info {
    color: #1e9ff2 !important;
}

.text--dark {
    color: #10163A !important;
}

.text--white {
    color: #ffffff !important;
}

.text--black {
    color: #000000 !important;
}

.text--gray {
    color: #9E9E9E !important;
}

.text--blue-gray {
    color: #607D8B !important;
}

.text--red {
    color: #F44336 !important;
}

.text--pink {
    color: #E91E63 !important;
}

.text--purple {
    color: #9C27B0 !important;
}

.text--deep-purple {
    color: #673AB7 !important;
}

.text--indigo {
    color: #3F51B5 !important;
}

.text--blue {
    color: #2196F3 !important;
}

.text--light-blue {
    color: #45c5ff !important;
}

.text--cyan {
    color: #00BCD4 !important;
}

.text--teal {
    color: #009688 !important;
}

.text--green {
    color: #4CAF50 !important;
}

.text--light-green {
    color: #8BC34A !important;
}

.text--lime {
    color: #CDDC39 !important;
}

.text--yellow {
    color: #FFEB3B !important;
}

.text--amber {
    color: #FFC107 !important;
}

.text--orange {
    color: #FF9800 !important;
}

.text--brown {
    color: #795548 !important;
}

.text-color--1 {
    color: #127681 !important;
}

.text-color--2 {
    color: #ea907a !important;
}

.text-color--3 {
    color: #10375c !important;
}

.text-color--4 {
    color: #4f8a8b !important;
}

.text-color--5 {
    color: #d92027 !important;
}

.text-color--6 {
    color: #ff9234 !important;
}

.text-color--7 {
    color: #4cd3c2 !important;
}

.text-color--8 {
    color: #35d0ba !important;
}

.text-color--9 {
    color: #e84a5f !important;
}

.text-color--10 {
    color: #00005c !important;
}

.text-color--11 {
    color: #45046a !important;
}

.text-color--12 {
    color: #5c2a9d !important;
}

.text-color--13 {
    color: #6a097d !important;
}

.text-color--14 {
    color: #ff5200 !important;
}

.text-color--15 {
    color: #162447 !important;
}

.text-color--16 {
    color: #e43f5a !important;
}

.text-color--17 {
    color: #035aa6 !important;
}

.text-color--18 {
    color: #0779e4 !important;
}

.text-color--19 {
    color: #342ead !important;
}

.text-color--20 {
    color: #d7385e !important;
}

/* color css end */
/* background-color css start */
*[class*="bg"] {
    color: #ffffff;
}

.bg--white, .bg--gray {
    color: inherit;
}

.bg--primary {
    background-color: #7367f0 !important;
}

.bg--secondary {
    background-color: #868e96 !important;
}

.bg--success {
    background-color: #28c76f !important;
}

.bg--danger {
    background-color: #ea5455 !important;
}

.bg--warning {
    background-color: #ff9f43 !important;
}

.bg--info {
    background-color: #1e9ff2 !important;
}

.bg--dark {
    background-color: #10163A !important;
}

.bg--white {
    background-color: #ffffff !important;
}

.bg--black {
    background-color: #000000 !important;
}

.bg--gray {
    background-color: #9E9E9E !important;
}

.bg--blue-gray {
    background-color: #607D8B !important;
}

.bg--red {
    background-color: #F44336 !important;
}

.bg--pink {
    background-color: #E91E63 !important;
}

.bg--purple {
    background-color: #9C27B0 !important;
}

.bg--deep-purple {
    background-color: #673AB7 !important;
}

.bg--indigo {
    background-color: #3F51B5 !important;
}

.bg--blue {
    background-color: #2196F3 !important;
}

.bg--light-blue {
    background-color: #45c5ff !important;
}

.bg--cyan {
    background-color: #00BCD4 !important;
}

.bg--teal {
    background-color: #009688 !important;
}

.bg--green {
    background-color: #4CAF50 !important;
}

.bg--light-green {
    background-color: #8BC34A !important;
}

.bg--lime {
    background-color: #CDDC39 !important;
}

.bg--yellow {
    background-color: #FFEB3B !important;
}

.bg--amber {
    background-color: #FFC107 !important;
}

.bg--orange {
    background-color: #FF9800 !important;
}

.bg--brown {
    background-color: #795548 !important;
}

.bg--transparent {
    background-color: transparent;
    color: #5b6e88;
}

.bg--1 {
    background-color: #127681 !important;
}

.bg--2 {
    background-color: #ea907a !important;
}

.bg--3 {
    background-color: #10375c !important;
}

.bg--4 {
    background-color: #4f8a8b !important;
}

.bg--5 {
    background-color: #d92027 !important;
}

.bg--6 {
    background-color: #ff9234 !important;
}

.bg--7 {
    background-color: #4cd3c2 !important;
}

.bg--8 {
    background-color: #35d0ba !important;
}

.bg--9 {
    background-color: #e84a5f !important;
}

.bg--10 {
    background-color: #00005c !important;
}

.bg--11 {
    background-color: #45046a !important;
}

.bg--12 {
    background-color: #5c2a9d !important;
}

.bg--13 {
    background-color: #6a097d !important;
}

.bg--14 {
    background-color: #ff5200 !important;
}

.bg--15 {
    background-color: #162447 !important;
}

.bg--16 {
    background-color: #e43f5a !important;
}

.bg--17 {
    background-color: #035aa6 !important;
}

.bg--18 {
    background-color: #0779e4 !important;
}

.bg--19 {
    background-color: #342ead !important;
}

.bg--20 {
    background-color: #d7385e !important;
}

.box--shadow1 {
    box-shadow: 0px 5px 26px -5px #cdd4e7 !important;
}

.box--shadow2 {
    box-shadow: 0 0.5rem 1rem rgba(18, 38, 63, 0.1) !important;
}

.box--shadow3 {
    box-shadow: 0 3px 5px 0 rgba(18, 38, 63, 0.2) !important;
}


.widget-two {
    padding: 15px 15px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

.widget-two:hover {
    -webkit-transform: scale(1.05, 1.05);
    -ms-transform: scale(1.05, 1.05);
    transform: scale(1.05, 1.05);
}

.widget-two .overlay-icon {
    position: absolute;
    top: 0;
    right: -15px;
    font-size: 120px;
    -webkit-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
    opacity: 0.15;
}

.widget-two__icon {
    width: 65px;
    height: 65px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.widget-two__icon i {
    font-size: 42px;
}

.widget-two__content {
    width: calc(100% - 65px);
    padding-left: 30px;
}

.widget-three {
    padding: 30px 30px;
    text-align: center;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

.widget-three:hover {
    -webkit-transform: scale(1.05, 1.05);
    -ms-transform: scale(1.05, 1.05);
    transform: scale(1.05, 1.05);
}

.widget-three__icon {
    width: 90px;
    height: 90px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    overflow: hidden;
}

.widget-three__icon i {
    font-size: 46px;
    color: #ffffff;
}

.widget-three__content {
    margin-top: 25px;
}
.widget-three__content .numbers {
    font-size: 24px;
    font-weight: 600;
}

.widget-four {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    align-items: center;
}

.widget-four .widget__icon {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    overflow: hidden;
}

.widget-four .widget__content {
    width: calc(100% - 75px);
    padding-left: 30px;
}

.widget-five {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    align-items: center;
}

.widget-five .widget__icon {
    width: 65px;
    height: 65px;
    overflow: hidden;
}

.widget-five .widget__content {
    width: calc(100% - 65px);
    padding-left: 20px;
}

.widget-five .widget__content ul li + li {
    margin-top: 5px;
}
.b-radius--3 {
    border-radius: 3px !important;
    -webkit-border-radius: 3px !important;
    -moz-border-radius: 3px !important;
    -ms-border-radius: 3px !important;
    -o-border-radius: 3px !important;
}

.b-radius--4 {
    border-radius: 4px !important;
    -webkit-border-radius: 4px !important;
    -moz-border-radius: 4px !important;
    -ms-border-radius: 4px !important;
    -o-border-radius: 4px !important;
}

.b-radius--5 {
    border-radius: 5px !important;
    -webkit-border-radius: 5px !important;
    -moz-border-radius: 5px !important;
    -ms-border-radius: 5px !important;
    -o-border-radius: 5px !important;
}

.b-radius--6 {
    border-radius: 6px !important;
    -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
}

.b-radius--7 {
    border-radius: 7px !important;
    -webkit-border-radius: 7px !important;
    -moz-border-radius: 7px !important;
    -ms-border-radius: 7px !important;
    -o-border-radius: 7px !important;
}

.b-radius--8 {
    border-radius: 8px !important;
    -webkit-border-radius: 8px !important;
    -moz-border-radius: 8px !important;
    -ms-border-radius: 8px !important;
    -o-border-radius: 8px !important;
}

.b-radius--9 {
    border-radius: 9px !important;
    -webkit-border-radius: 9px !important;
    -moz-border-radius: 9px !important;
    -ms-border-radius: 9px !important;
    -o-border-radius: 9px !important;
}

.b-radius--10 {
    border-radius: 10px !important;
    -webkit-border-radius: 10px !important;
    -moz-border-radius: 10px !important;
    -ms-border-radius: 10px !important;
    -o-border-radius: 10px !important;
}

.b-radius--rounded {
    border-radius: 50% !important;
    -webkit-border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -ms-border-radius: 50% !important;
    -o-border-radius: 50% !important;
}

.b-radius--capsule {
    border-radius: 999px !important;
    -webkit-border-radius: 999px !important;
    -moz-border-radius: 999px !important;
    -ms-border-radius: 999px !important;
    -o-border-radius: 999px !important;
}

.b-radius--none {
    border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    -ms-border-radius: 0 !important;
    -o-border-radius: 0 !important;
}

.numbers {
    font-size: 24px;
    font-weight: 600;
}
</style>

</head>
<body>
<script type="text/javascript" src="js/jquery/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js" integrity="sha512-E/kDI3wGWMS9Ea/EsDJMduyGSSx/VfdNXAMr/URDQwOAGkGn3uYaZa4Y7bim3ad/6mMA82l+9FxNWl64BR9pkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-----<script type="text/javascript" src="js/select2/jquery.select2.js"></script>----->

<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script>
<![endif]-->
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.canvas.js"></script>
<script type="text/javascript" src="js/typeahead.js"></script>

<!-- PNOTIFY NOTIFICATIONS JS -->
<script src="js/pnotify.custom.js"></script>

<!-- Main content starts -->
<div class="content">';
//---------------------------------
include_once(get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/left_navi.php");
//---------------------------------
echo '
<!-- Main bar -->
<div class="mainbar">
<!----------------------COMMON PAGE HEADING--------------------------------->';
//-----------------------------------
	include_once(get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/top_navi.php");