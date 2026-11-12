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
        $('#inv_form').on('keyup','.jQinv_item_width, .jQinv_item_height, .jQinv_item_qty, .jQinv_item_rate, .jQinv_gst_rate, .jQinv_ntn_rate, .invoice_advance', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $unit_width 	= $('.jQinv_item_width', this).val();
				var $unit_height 	= $('.jQinv_item_height', this).val();
                var $qty 			= $('.jQinv_item_qty', this).val();
				var $rate 			= $('.jQinv_item_rate', this).val();
				
				if($qty == '') { 				
				// once;
					 var $total = (($unit_width * 1) * ($unit_height * 1) * 1); 
				} else { 				
				//monthly
					 var $total = (($unit_width * 1) * ($unit_height * 1) * ($qty * 1)); 
				} 
                            
  
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );

				var $totalamount = (($total * 1) * ($rate * 1)); 
				
                $('.jQinv_item_sqft',this).val($total.toFixed(0));
                
				var parsedeachTotal = parseFloat( ('0' + $totalamount).replace(/[^0-9-\.]/g, ''), 10 );

				
				$('.jQinv_item_total',this).val(parsedeachTotal.toFixed(0));
				grandTotal += parsedeachTotal;
                
            });

            
			$(".inV_total span").html(grandTotal.toFixed(0));
			$('#inV_total').val(grandTotal.toFixed(0));

			 var $tax_gstamount = (grandTotal) * ($('.jQinv_gst_rate').val()/parseFloat("100"));
			 var parsedGstTax = parseFloat( ('0' + $tax_gstamount).replace(/[^0-9-\.]/g, ''), 10 );
			 var $tax_ntnamount = (grandTotal) * ($('.jQinv_ntn_rate').val()/parseFloat("100"));
			 var parsedNtnTax = parseFloat( ('0' + $tax_ntnamount).replace(/[^0-9-\.]/g, ''), 10 );
			 var $grandtotal = ((grandTotal + parsedGstTax + parsedNtnTax) - $('.invoice_advance').val());
			 
			 $('#inV_totalgsttax').val(parsedGstTax.toFixed(0));
			 $(".inV_totalgsttax span").html(parsedGstTax.toFixed(0));
			 $('#inV_totalntntax').val(parsedNtnTax.toFixed(0));
			 $(".inV_totalntntax span").html(parsedNtnTax.toFixed(0));
			 
			$(".inV_grandtotal span").html($grandtotal.toFixed(0));
			$('#inV_grandtotal').val($grandtotal.toFixed(0));
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_total span").html('0.00');
				$(".inV_grandtotal span").html('0.00');
				$(".inV_totalgsttax span").html('0.00');
				$(".inV_totalntntax span").html('0.00');
            })
        }
       
    });
