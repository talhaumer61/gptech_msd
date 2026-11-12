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
        $('#inv_form').on('keyup','.jQinv_item_discount, .jQinv_item_qty, .jQinv_item_rate', function() {
            rowInputs();
        });

        function rowInputs() {
         //   var balance = 0;
//            var subTotal = 0;
			var grandTotal = 0;
//            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $qty 			= $('.jQinv_item_qty', this).val();
				var $itemrate 		= $('.jQinv_item_rate', this).val();
				var $discount 	    = $('.jQinv_item_discount', this).val();
				
				
//monthly
				 var $rate 	= ($itemrate - (($itemrate/100)*$discount)); 			
				 var $linetotal 	= ($rate * $qty); 
				 var parsedSubTotal = parseFloat( ('0' + $linetotal).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_item_total',this).val($linetotal.toFixed(2));
				grandTotal += parsedSubTotal;
                
            });


            var openingbalance = document.getElementById("customer_openingbalance").value;  
            var totalReceivable = ((openingbalance * 1) + (grandTotal * 1));  
            
			$(".inV_grandtotal span").html(grandTotal.toFixed(2));
			$('#inV_grandtotal').val(grandTotal.toFixed(2));
            $(".inV_receiveable span").html(totalReceivable.toFixed(2));
            $('#inV_receiveable').val(totalReceivable.toFixed(2));
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
            })
        }
       
    });
