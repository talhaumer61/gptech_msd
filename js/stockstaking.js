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
        $('#inv_form').on('keyup','.jQinv_system_stock, .jQinv_system_stockamount, .jQinv_sale_price, .jQinv_physically_stock, .jQinv_physically_stockamount', function() {
            rowInputs();
        });

        function rowInputs() {
			
			var grandPhysicalTotal 	= 0;
			var grandPhysicalstock 	= 0;
			var grandDifferqty 	= 0;
			var grandDifferamts	= 0;
			var grandSystemstock	= 0;
			var grandSystemstockamts	= 0;
 
            $(".invE_table tr").not('.last_row').each(function () {
                var $systemstock 		= $('.jQinv_system_stock', this).val();
				var $systemstockamount 	= $('.jQinv_system_stockamount', this).val();
				var $saleprice 			= $('.jQinv_sale_price', this).val();
				var $physicallystock 	= $('.jQinv_physically_stock', this).val();
				
				

				 var $linesystemstock  = ($systemstock * 1); 
				 var parsedsystemstock = parseFloat( ('0' + $linesystemstock).replace(/[^0-9-\.]/g, ''), 10 );
				grandSystemstock += parsedsystemstock;
				
				var $linesystemstockamts  = ($systemstockamount * 1); 
				 var parsedsystemstockamts = parseFloat( ('0' + $linesystemstockamts).replace(/[^0-9-\.]/g, ''), 10 );
				grandSystemstockamts += parsedsystemstockamts;
				
				var $linephysicalstock  = ($physicallystock * 1); 
				 var parsedphysicalstock = parseFloat( ('0' + $linephysicalstock).replace(/[^0-9-\.]/g, ''), 10 );
				grandPhysicalstock += parsedphysicalstock;
				
				 var $linephysicaltotal  = ($saleprice * $physicallystock); 
				 var parsedPhysicalTotal = parseFloat( ('0' + $linephysicaltotal).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_physically_stockamount',this).val($linephysicaltotal.toFixed(2));
				grandPhysicalTotal += parsedPhysicalTotal;
				
				
				 var $linedifferqty = ($physicallystock - $systemstock); 
				 var parsedDifferqty = parseFloat( ('0' + $linedifferqty).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_difference_stock',this).val($linedifferqty.toFixed(2));
				grandDifferqty += parsedDifferqty;
				
				 var $linedifferamts  = (($physicallystock - $systemstock) * $saleprice); 
				 var parsedDifferamts = parseFloat( ('0' + $linedifferamts).replace(/[^0-9-\.]/g, ''), 10 );
				$('.jQinv_difference_stockamount',this).val($linedifferamts.toFixed(2));
				grandDifferamts += parsedDifferamts;
                
            });


            
           // var totalReceivable = ( (grandPhysicalTotal * 1));  
            
			$(".inV_grandPhysicalstock span").html(grandPhysicalstock.toFixed(2));
			$('#inV_grandPhysicalstock').val(grandPhysicalstock.toFixed(2));
			$(".inV_grandPhysicaltotal span").html(grandPhysicalTotal.toFixed(2));
			$('#inV_grandPhysicaltotal').val(grandPhysicalTotal.toFixed(2));
            $(".inV_grandDifferqty span").html(grandDifferqty.toFixed(2));
            $('#inV_grandDifferqty').val(grandDifferqty.toFixed(2));
			$(".inV_grandDifferamts span").html(grandDifferamts.toFixed(2));
            $('#inV_grandDifferamts').val(grandDifferamts.toFixed(2));
			
			$(".inV_grandSystemstock span").html(grandSystemstock.toFixed(2));
            $('#inV_grandSystemstock').val(grandSystemstock.toFixed(2));
			
			$(".inV_grandSystemsamts span").html(grandSystemstockamts.toFixed(2));
            $('#inV_grandSystemsamts').val(grandSystemstockamts.toFixed(2));
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandPhysicalstock span").html('0.00');
				$(".inV_grandPhysicaltotal span").html('0.00');
				
				$(".inV_grandDifferqty span").html('0.00');
				$(".inV_grandDifferamts span").html('0.00');
				
				$(".inV_grandSystemstock span").html('0.00');
				$(".inV_grandSystemsamts span").html('0.00');
            })
        }
       
    });

//--Get Stocking Type-->
function get_stockTakingtype(idtype) {   
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/get_stockTakingtype.php",  
		data: "idtype="+idtype,  
		success: function(msg){  
			$("#getstockTakingtype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
//--Get Item Detail-->
function get_Itemstockdetail(id_item, srno) {   
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/get_Itemstockdetail.php",  
		data: "id_item="+id_item+"&srno="+srno,  
		success: function(msg){  
			$("#getItemstockdetail_"+srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}