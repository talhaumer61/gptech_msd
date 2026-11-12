<?php
include "../../../dbsetting/lms_vars_config.php";
include "../../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../../functions/login_func.php";
include "../../../functions/functions.php";
checkCpanelLMSALogin();
if(isset($_POST['item_id']) ){
    $conditions = array ( 
                            'select' 		=> ''.CUSTOMERS.'.customer_id',
                            'where' 		=> array( 
                                                        ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                                                    ), 
                            'limit' 		=> 1,
                            'return_type' 	=> 'single' 
                        ); 
    $valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);

    // get Credit Debit Payments of Customer
    $debitcreditconditions = array ( 
                                        'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
                                                            SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
                                        'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
                                        'where' 		=> array ( 
                                                                    ''.PAYMENTS.'.status' => 1
                                                                    , ''.PAYMENTS.'.id_user' => cleanvars($valueCustomer['customer_id'])
                                                                ), 
                                        'return_type' 	=> 'single' 
                                    ); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
    $openingbalance 	= ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);

    session_start(); 

    unset($_SESSION['cart'][$_POST['item_id']]);

    if(count($_SESSION['cart']) > 0){
        $srno 	    = 0;
        $gtotal     = 0;
        $tbody      = '';
        $payable    = '';
        foreach($_SESSION['cart'] as $item){
            $srno++;
            $gtotal = $gtotal + ($item['pricesale'] * $item['quantity']);
            $stockconditions	= array ( 
                                            'select' 		=> "".ITEMS.".item_pricepurchase, 
                                                                SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
                                                                SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY ",
                                            'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
                                            'where' 		=> array( 
                                                                        ''.STOCK.'.id_item' => cleanvars($item['id']) 
                                                                    ), 
                                            'return_type' 	=> 'single' 
                                        ); 
            $valuestockinout 	= $dblms->getRows(STOCK, $stockconditions);
            $itemstock 			= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);
            $tbody .= '
            <tr>
                <td class="center">
                    <a onclick="removeitem(\''.$item['id'].'\')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                </td>
                <td class="center">'.$srno.'</td>
                <td>
                    '.$item['name'].'
                    <input type="hidden" name="id_item['.$srno.']" id="id_item_'.$srno.'" class="form-control" value="'.$item['id'].'" >
                </td>
                <td class="center">
                    <span style="color:#00f; font-size:16px; font-weight:600; text-align:center;">'.$itemstock.'</span>
                    <input type="hidden" name="is_available['.$srno.']" id="is_available_'.$srno.'" value="'.($itemstock > 0 ? '1' : '0').'">
                </td>
                <td class="center">
                    <input type="number" name="total_qty['.$srno.']" id="total_qty_'.$srno.'"  onchange="updatequantity(\''.$item['id'].'\',this.value)" style="color:#00f; font-weight:600; text-align:center;" class="form-control jQinv_item_qty" value="'.$item['quantity'].'" >
                </td>
                <td class="center">
                    <input type="number" name="unit_price['.$srno.']" id="unit_price_'.$srno.'" style="color:#00f; font-weight:600; text-align:center;" readonly="" class="form-control jQinv_item_rate" value="'.$item['pricesale'].'" >
                </td>
                <td class="center">
                    <input type="number" name="total_price['.$srno.']" id="total_price_'.$srno.'" style="color:orangered; font-weight:600; text-align:center;" readonly="" class="form-control jQinv_item_total" value="'.($item['pricesale'] * $item['quantity']).'.00" >
                </td>
            </tr>';
        }
        $tbody .= '
        <tr>
            <th style="text-align:right;" colspan="6">
                Total Amount
            </th>
            <th style="text-align:center;">
                <span style="color:#00f; font-size:16px; font-weight:600;" class="inV_grandtotal"><span>'.number_format($gtotal).'</span></span>
            </th>
        </tr>';

        $payable = '
        <tr>
            <th style="text-align:center;vertical-align: middle;">
                <span style="color:#00f; font-size:16px; font-weight:600; text-align:center;">Rs.<span>'.number_format($openingbalance).'</span></span>
            </th>
            <th style="text-align:center;vertical-align: middle;">
                <span style="color:#00f; font-size:16px; font-weight:600; text-align:center;" class="inV_grandtotal">Rs.<span>'.number_format($gtotal).'</span></span>
            </th>
            <th style="text-align:center;vertical-align: middle;">
                <span style="color:#00f; font-size:16px; font-weight:600; text-align:center;" class="inV_receiveable">Rs.<span>'.number_format($gtotal + $openingbalance).'</span></span>
                <input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$gtotal.'">
                <input type="hidden" id="opening_balance" name="opening_balance" value="'.$openingbalance.'">
                <input type="hidden" id="inV_receiveable" name="inV_receiveable" value="">
            </th>
        </tr>';

        $data['status_code']    = '00';
        $data['tbody']          = $tbody;
        $data['payable']        = $payable;
    }else{
        $pbody = '
        <div class="text-center">
            <h2 class="text text-center text-danger mt-lg">No item found in the cart!</h2>
            <a href="customerestimates.php?view=add" class="btn btn-primary">Go to items!</a>
        </div>';
        $data['status_code']    = '11';
        $data['pbody']          = $pbody;
        $data['payable']        = $payable;
    }

    
    $data['title'] = 'Error';
    $data['text']  = 'Item Removed Successfully.';
    $data['type']  = 'error';
    echo json_encode($data);

}
?>