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
        $('#inv_form').on('keyup','.jQinv_item_credit, .jQinv_item_debit', function() {
            rowInputs();
        });

        function rowInputs() {
            //var balance = 0;
//            var subTotal = 0;
			var grandcreditTotal = 0;
			var granddebitTotal = 0;
  //          var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $credit 		= $('.jQinv_item_credit', this).val();
				var $debit 			= $('.jQinv_item_debit', this).val();
				
				
//monthly
								
				 var $linetotalcredit 		= ($credit * 1); 
				 var $linetotaldebit 		= ($debit * 1); 
				 var parsedSubcreditTotal 	= parseFloat( ('0' + $linetotalcredit).replace(/[^0-9-\.]/g, ''), 10 );
				 var parsedSubdebitTotal 	= parseFloat( ('0' + $linetotaldebit).replace(/[^0-9-\.]/g, ''), 10 );
				grandcreditTotal += parsedSubcreditTotal;
				granddebitTotal += parsedSubdebitTotal;
                
            });

            
			$(".inV_grandcreditTotal span").html(grandcreditTotal.toFixed(2));
			$('#inV_grandcreditTotal').val(grandcreditTotal.toFixed(2));
            $(".inV_granddebitTotal span").html(granddebitTotal.toFixed(2));
            $('#inV_granddebitTotal').val(granddebitTotal.toFixed(2));
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandcreditTotal span").html('0.00');
				$(".inV_granddebitTotal span").html('0.00');
            })
        }
       
    });
