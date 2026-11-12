/* [ ---- Beoro Admin - invoices ---- ] */

    $(document).ready(function() {

        //* clone row
        var id = 0;
        $(".inv_clone_btn").click(function() {
            id++;
            var table = $(this).closest("table");
            var clonedRow = table.find(".inv_row").clone();
            clonedRow.removeAttr("class");
            clonedRow.find(".id").attr("value", id);
            clonedRow.find(".inv_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".last_row").before(clonedRow);
        });
        //* remove row
        $(".invE_table").on("click",".inv_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });
		
       //* subtotal sum
        $('#inv_form').on('keyup','.jQinv_item_qty, .jQinv_item_rate, .jQinv_deducation', function() {
            rowInputs();
        });

        function rowInputs() {
         //   var balance = 0;
//            var subTotal = 0;
			var grandTotal 		= 0;
//            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $qty 			= $('.jQinv_item_qty', this).val();
				var $rate 			= $('.jQinv_item_rate', this).val();
				
				
//monthly
								
				 var $linetotal 	= ($rate * $qty); 
				 var parsedSubTotal = parseFloat( ('0' + $linetotal).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_item_total',this).val($linetotal.toFixed(2));
				grandTotal += parsedSubTotal;
                
            });
			
			var $deducationper = (grandTotal) * ($('.jQinv_deducation').val()/parseFloat("100"));
			var parsedDedper = parseFloat( ('0' + $deducationper).replace(/[^0-9-\.]/g, ''), 10 );
            var openingbalance = document.getElementById("vendor_openingbalance").value;  
           
            var totalgrandtotal = ( (grandTotal * 1) - ($deducationper * 1));  
			var totalReceivable = ((openingbalance * 1) - ((totalgrandtotal * 1) ));  
			

            
			$(".inV_invoicetotal span").html(grandTotal.toFixed(0));
			$('#inV_invoicetotal').val(grandTotal.toFixed(0));
			$(".inV_grandtotal span").html(totalgrandtotal.toFixed(0));
			$('#inV_grandtotal').val(totalgrandtotal.toFixed(0));
            $(".inV_receiveable span").html(totalReceivable.toFixed(0));
            $('#inV_receiveable').val(totalReceivable.toFixed(0));
			
			$('#inV_deducation').val(parsedDedper.toFixed(0));
			$(".inV_deducation span").html(parsedDedper.toFixed(0));
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
				$(".inV_invoicetotal span").html('0.00');
				$(".inV_deducation span").html('0.00');
				$(".inV_receiveable span").html('0.00');
				
            });
        }
       
    });


    function get_retrunvendordetail(id_vendor) {  

        $("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_retrunvendordetail.php",  
            data: 'id_vendor='+id_vendor,  
            success: function(msg){  
                $("#getretrunvendordetail").html(msg); 
                $("#loading").html(''); 
            }
        });  

    }

    function get_paymethoddetail(payment_method) {  

        $("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_paymethoddetail.php",  
            data: 'payment_method='+payment_method,  
            success: function(msg){  
                $("#getpaymethoddetail").html(msg); 
                $("#loading").html(''); 
            }
        });  

    }