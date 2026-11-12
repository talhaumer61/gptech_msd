<?php
	$adjacents = 3;
    if(!($Limit)) 	{ $Limit = 16; } 
    if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

	$conditions = array ( 
							  'select' 		=>  'i.item_id, i.id_cat, i.item_name, i.item_classes,i.item_code,i.item_photo, i.item_pricesale'
							, 'join' 		=> "INNER JOIN ".ITEMS_CAT." cat ON cat.cat_id = i.id_cat"
							, 'where' 		=> array( 
														 'i.id_company' 	=> 0 
														,'i.item_status' 	=> 1 
													)
                            , 'not_equal' 		=> array( 
                                                        'i.id_brand' 	=> 0 
                                                   )
							, 'order_by' 	=> 'i.item_name ASC'
							, 'return_type' => 'count' 
						);

    if(isset($_SESSION['brand']) && !empty($_SESSION['brand'])){
        $conditions['search_by'] = ' AND FIND_IN_SET('.$_SESSION['brand'].', i.id_brand) > 0';
    }
                        
    $search_word = '';
    if(isset($_GET['search_word']) && !empty($_GET['search_word'])){
        $search_word = $_GET['search_word'];
        $conditions['search_by'] .= ' AND (i.item_name LIKE \'%' . $search_word . '%\')';
        $sqlstring	.= "&search_word=".$search_word."";
    }

    $id_cls = '';
    if(isset($_GET['id_cls']) && !empty($_GET['id_cls'])){
        $id_cls                                 = $_GET['id_cls'];
        $conditions['where']['i.item_classes']  = $id_cls;
        $sqlstring	.= "&id_cls=".$id_cls."";
    }
    
    $id_cat = '';
    if(isset($_GET['id_cat']) && !empty($_GET['id_cat'])){
        $id_cat                             = $_GET['id_cat'];
        $conditions['where']['i.id_cat']    = $id_cat;
        $sqlstring	.= "&id_cat=".$id_cat."";
    }

	$records		= $dblms->getRows(ITEMS.' i', $conditions);
	$count 			= ($records);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;		

	$conditions['start'] 		=	($page-1)*$Limit;
	$conditions['limit'] 		=	$Limit;
	$conditions['return_type'] 	=	'all';

	$Items 	= $dblms->getRows(ITEMS.' i', $conditions);

    // ITEM CATEGORIES
    $catconditions = array ( 
                                  'select' 		=>  'cat.cat_id, cat.cat_name'
                                , 'where' 		=> array( 
                                                            'cat.cat_status' => 1 
                                                        )
                                , 'order_by' 	=> 'cat.cat_name  ASC'
                                , 'return_type' => 'all' 
                            ); 
    $itemCategories	= $dblms->getRows(ITEMS_CAT. ' cat', $catconditions);

    echo '
    <div style="width:100%;  padding: 15px 0px 10px 10px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
                <h4 class="modal-title" style="font-weight:700;"><i class="icon-list-ul"></i> Item List</h4>
                
            </div>

            <div class="modal-body" style="height:2043px">
                <form action="customerestimates.php?view=add" method="GET" autocomplete="off">
                    <input type="hidden" name="view" value="add">

                    <div class="col-md-5 col-sm-3">
                        <div class="form_sep">
                            <label>Search </label>
                            <input type="search" class="form-control" name="search_word" id="search_word" value="'.$search_word.'" placeholder="item name or item code">
                        </div> 
                    </div>
                    

                    <div class="col-md-3 col-sm-4">
                        <div class="form_sep">
                            <label>Class</label>
                            <select name="id_cls" id="id_cls" class="id_cls" style="width:100%" >
                                <option value=""></option>';
                                foreach ($classnames as $cls):
                                    echo'<option value="'.$cls['id'].'" '.($id_cls == $cls['id'] ? 'selected' : '').'>'.$cls['name'].'</option>';
                                endforeach;
                            echo'
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-3 col-sm-4">
                        <div class="form_sep">
                            <label>Categories </label>
                            <select name="id_cat" id="id_cat" class="id_cat" style="width:100%" >
                                <option value=""></option>';
                                foreach ($itemCategories as $cat):
                                    echo'<option value="'.$cat['cat_id'].'" '.($id_cat == $cat['cat_id'] ? 'selected' : '').'>'.$cat['cat_name'].'</option>';
                                endforeach;
                            echo'
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-1 col-sm-1">
                        <div class="form_sep">
                            <label></label>
                            <button class="btn btn-primary btn-block" name="search"><i class="fa fa-search"></i></button>
                        </div> 
                    </div>
                </form>
                
                <div style="clear:both;padding:3px;"></div>
                <hr>
                <div style="clear:both;padding:3px;"></div>

                <div class="row row-sm" id="items">';
                    if($Items){
                        foreach($Items as $item){
                            $img = SITE_URL.'/uploads/items/'.(!empty($item['item_photo']) ? $item['item_photo'] : 'default.jpg');
                            echo '
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mb-sm">
                                <div class="card card-file">
                                    <div class="card-file-thumb">
                                        <img src="'.$img.'"  height="337">
                                    </div>
                                    <div class="card-body  text-center">
                                        <b class="line-clamp-2">'.$item['item_name'].'</b>
                                        <b class="text-blue">Rs: '.round($item['item_pricesale']).'</b>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a onclick="addtocart(\''.$item['item_id'].'\',\''.$img.'\',\''.$item['item_name'].'\',\''.round($item['item_pricesale']).'\')" class="btn btn-danger btn-sm"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    </div>
                                </div>	
                            </div>';
                        }
                    }else{
                        echo '
                        <div class="col-lg-12">
                            <div class="widget-tabs-notification">No Result Found</div>
                        </div>';
                    }
                    echo '
                </div>';
                echo $Pagination->get_Paginator('customerestimates.php?view=add', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
                echo '
            </div>
        </div>
    </div>';