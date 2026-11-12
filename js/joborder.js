/* [ ---- Beoro Admin - invoices ---- ] */

    $(document).ready(function() {

        //* clone row
        var id = 0;
        $(".inv_clone_btn").click(function() {
            id++;
            var table = $(this).closest("table");
            var clonedRow = table.find(".inv_row").clone();
            clonedRow.removeAttr("class")
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
        $('#inv_form').on('keyup','.jQinv_item_perpack, .jQinv_item_size, .jQinv_item_dmarginrate', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $item_perpack 	= $('.jQinv_item_perpack', this).val();
				var $item_size 		= $('.jQinv_item_size', this).val();
				var $dmarginrate 	= $('.jQinv_item_dmarginrate', this).val();
				

					 var $total = (($item_perpack * 1) / ($item_size * 1)); 
                     var $dmargin = ((($dmarginrate * 1)  * ($item_perpack * 1))/100);       
  
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
				var parsedDmargin = parseFloat( ('0' + $dmargin).replace(/[^0-9-\.]/g, ''), 10 );

				
                $('.jQinv_item_perkg',this).val($total.toFixed(2));
				 $('.jQinv_item_dmargin',this).val($dmargin.toFixed(2));
                
                subTotal += parsedSubTotal;
                
            });			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".setup_package span").html('0');
            })
        }
       
    });

    function get_customerdetail(id_customer) {  

        $("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
        $.ajax({  
            type: "POST",  
            url: "include/ajax/get_customerdetail.php",  
            data: 'id_customer='+id_customer,  
            success: function(msg){  
                $("#getcustomerdetail").html(msg); 
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