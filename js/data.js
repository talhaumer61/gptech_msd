<!--Get Prgam Detail-->
function get_joborders(id_customer) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_joborders.php",  
		data: "id_customer="+id_customer,  
		success: function(msg){  
			$("#getjoborders").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Prgam Detail-->
function get_joborderdetail(orderno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_joborderdetail.php",  
		data: "orderno="+orderno,  
		success: function(msg){  
			$("#getjoborderdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Prgam Detail-->
function get_1stinvoicedate(id_customer) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_1stinvoicedate.php",  
		data: "id_customer="+id_customer,  
		success: function(msg){  
			$("#get1stinvoicedate").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Prgam Detail-->
function get_employeebydept(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/employee/get_employeebydept.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getemployeebydept").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Prgam Detail-->
function get_employeeleves(id_emply) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/employee/get_employeeleves.php",  
		data: "id_emply="+id_emply,  
		success: function(msg){  
			$("#getemployeeleves").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prgam Detail-->
function get_employeebydeptprevious(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/employee/get_employeebydeptprevious.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getemployeebydeptprevious").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prgam Detail-->
function get_employeeattendbyno(emply_no) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/employee/get_employeeattendbyno.php",  
		data: "emply_no="+emply_no,  
		success: function(msg){  
			$("#getemployeeattendbyno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

// get_customerDetail-->
function get_customerDetailforlogin(idcustomer) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/customer/get_customerDetailforlogin.php",  
		data: "idcustomer="+idcustomer,  
		success: function(msg){  
			$("#getcustomerDetailforlogin").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
