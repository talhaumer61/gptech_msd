<?php 
    include "../../dbsetting/lms_vars_config.php";
    include "../../dbsetting/classdbconection.php";
    $dblms = new dblms();
    include "../../functions/login_func.php";
    include "../../functions/functions.php";
    include "../../functions/db_functions.php";
    $mainclass = new main();
    
    if(isset($_POST['idcompany'])) { 

        $idcompany = $_POST['idcompany'];
        $company_condition = "";

        if ($idcompany != 'all') {
            if (is_array($idcompany)) {
                $company_ids = implode(',', array_map('intval', $idcompany));
                $company_condition = " AND ".CUSTOMERS.".id_company IN ($company_ids)";
            } else {
                $company_condition = " AND ".CUSTOMERS.".id_company = ".cleanvars($idcompany);
            }
        }

        $conditions = array ( 
								'select'       => CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_code, '.COMPANY.'.company_name',
								'join'         => "LEFT JOIN ".COMPANY." ON ".COMPANY.".company_id = ".CUSTOMERS.".id_company",
								'where'        => array ( 
													CUSTOMERS.'.customer_status' => '1'
												),
								'search_by'    => $company_condition, 
								'order_by'     => CUSTOMERS.'.customer_code ASC, '.CUSTOMERS.'.customer_name ASC',
								'return_type'  => 'all' 
							); 

        $Customers = $dblms->getRows(CUSTOMERS, $conditions);

        echo '
		<select class="select2" id="id-customer" name="idcustomer" style="width:100%" required autocomplete="off">
            <option value="">Select Customer</option>
            <option value="all">All</option>';
			if($Customers) {
				foreach($Customers as $listcat) {
					echo '<option value="'.$listcat['customer_id'].'">'.$listcat['customer_code'].' - '.$listcat['customer_name'].'</option>';
				}
			}
       		 echo '
		</select>
		<script>
			$("#id-customer").select2({
				allowClear: true
			});			
		</script>';
    }
?>