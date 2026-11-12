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
        $('#inv_form').on('keyup','.jQinv_itemtotal, .jQinv_item_received, .jQinv_item_receive, .jQinv_unitprice', function() {
            rowInputs();
        });

        function rowInputs() {
            //var balance = 0;
//            var subTotal = 0;
			var grandTotal = 0;
  //          var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $receivedqty 	= $('.jQinv_item_received', this).val();
				var $receiveqty 	= $('.jQinv_item_receive', this).val();
				var $toalqty 		= $('.jQinv_itemtotal', this).val();
				var $rate 			= $('.jQinv_unitprice', this).val();				
				
//monthly
								
				 var $linebalance 	= (($toalqty * 1) - (($receivedqty * 1) + ($receiveqty * 1))); 
//				 var parsedSubTotal = parseFloat( ('0' + $linebalance).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_item_balance',this).val($linebalance.toFixed(0));
				var $linetotal 	= ($rate * $receiveqty); 
				 var parsedSubTotal = parseFloat( ('0' + $linetotal).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_unittotal',this).val($linetotal.toFixed(2));
				grandTotal += parsedSubTotal;

                
            });
			$(".inV_grandtotal span").html(grandTotal.toFixed(2));
			$('#inV_grandtotal').val(grandTotal.toFixed(2));
			
			
        }

       function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
            })
        }
       
    });
