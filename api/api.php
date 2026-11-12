<?php 
//Require Connection & Function Files
require_once("../dbsetting/lms_vars_config.php");
require_once("../dbsetting/classdbconection.php");
require_once("../functions/functions.php");
$dblms = new dblms();

//Get Request Data
$requestData = $_REQUEST;

//Items
if($requestData['method'] == "items"){

    if(!isset($requestData['pageNo'])){$requestData['pageNo'] = 1;}
    if(!isset($requestData['items'])){$page_limit = 50;}else{$page_limit = $requestData['items'];}
    $limit = ($requestData['pageNo']-1) * $page_limit;

    $searchSQL = '';
    if(isset($requestData['searchQuery'])){

        $searchSQL .= "AND (de.item_name LIKE '%".cleanvars($requestData['searchQuery'])."%' OR de.item_code LIKE '".cleanvars($requestData['searchQuery'])."')";

    }

    $sqllmsItemsCount  = $dblms->querylms("SELECT COUNT(de.item_id) as total
                                            FROM ".ITEMS." de
                                            INNER JOIN ".ITEMS_CAT." cat ON cat.cat_id =  de.id_cat 
                                            WHERE item_id != '0' AND de.item_status = '1' $searchSQL 
                                            ORDER BY item_name ASC");
    $valueItemsCount = mysqli_fetch_assoc($sqllmsItemsCount);

    $sqllmsItems  = $dblms->querylms("SELECT de.item_id, de.id_cat, de.item_name, de.item_code, de.item_type, de.item_details, 
										de.item_pricepurchase, de.item_pricesale, cat.cat_name
										FROM ".ITEMS." de
										INNER JOIN ".ITEMS_CAT." cat ON cat.cat_id =  de.id_cat 
										WHERE de.item_id != '0' AND de.item_status = '1' $searchSQL 
										ORDER BY de.item_name ASC LIMIT $limit, $page_limit");
    if(mysqli_num_rows($sqllmsItems) > 0){

        $jsonObj0 = array();

        $srno = 0;
        while($valueItem = mysqli_fetch_assoc($sqllmsItems)){

            $srno++;

            $data0['id'] 	        = $valueItem['item_id'];
            $data0['code'] 	        = $valueItem['item_code'];
            $data0['name'] 	        = html_entity_decode($valueItem['item_name'],ENT_QUOTES);
            $data0['details'] 	    = html_entity_decode($valueItem['item_details'],ENT_QUOTES);
            $data0['price'] 	    = $valueItem['item_pricesale'];
            $data0['cat_id'] 	    = $valueItem['id_cat'];
            $data0['cat_name'] 	    = $valueItem['cat_name'];

            array_push($jsonObj0,$data0);
        }

        $data['result_code'] 	= '000';
        $data['searched_items'] = $jsonObj0;
        $data['page_no'] 	    = $requestData['pageNo'];
        $data['counts'] 	    = (int)$valueItemsCount['total'];

    } else{

        $data['result_code'] 	= '001';

    }
    
    header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    die();

//Item Categories
} else if($requestData['method'] == "cats")  {

    if(!isset($requestData['pageNo'])){$requestData['pageNo'] = 1;}
    if(!isset($requestData['items'])){$page_limit = 50;}else{$page_limit = $requestData['items'];}
    $limit = ($requestData['pageNo']-1) * $page_limit;

    $searchSQL = '';
    if(isset($requestData['searchQuery'])){

        $searchSQL .= "AND (cat_name LIKE '%".cleanvars($requestData['searchQuery'])."%' OR cat_detail LIKE '".cleanvars($requestData['searchQuery'])."' )";

    }

    $sqllmsCatCount  = $dblms->querylms("SELECT COUNT(cat_id) as total
                                            FROM ".ITEMS_CAT."
                                            WHERE cat_id != '0' AND cat_status = '1' $searchSQL 
                                            ORDER BY cat_id ASC");
    $valueCatCount = mysqli_fetch_assoc($sqllmsCatCount);

    $sqllmsCats  = $dblms->querylms("SELECT cat_id,cat_name,cat_detail
										FROM ".ITEMS_CAT." 
										WHERE cat_id != '0' AND cat_status = '1' $searchSQL 
										ORDER BY cat_id ASC LIMIT $limit, $page_limit");
    if(mysqli_num_rows($sqllmsCats) > 0){

        $jsonObj0 = array();

        $srno = 0;
        while($valueCat = mysqli_fetch_assoc($sqllmsCats)){

            $srno++;

            $data0['id'] 	        = $valueCat['cat_id'];
            $data0['name'] 	        = html_entity_decode($valueCat['cat_name'],ENT_QUOTES);
            $data0['details'] 	    = html_entity_decode($valueCat['cat_detail'],ENT_QUOTES);

            array_push($jsonObj0,$data0);
        }

        $data['result_code'] 	= '000';
        $data['searched_cats'] = $jsonObj0;
        $data['page_no'] 	    = $requestData['pageNo'];
        $data['counts'] 	    = (int)$valueCatCount['total'];

    } else{

        $data['result_code'] 	= '001';

    }

    header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    die();

} else {

    $data['result_code'] 	= '001';
    $data['message'] 	= 'Not Allowed!';

    header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    die();

}
?>