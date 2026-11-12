<!--Get Prgam Detail-->
function regularnewclients(job_for) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/regularnewclients.php",  
		data: "job_for="+job_for,  
		success: function(msg){  
			$("#regularnewclients").html(msg); 
			$("#loading").html(''); 
		}
	});  
}