<?php
//Import price List
if(isset($_POST['import_price_list'])){

    $file_name = $_FILES['file_import']['name'];
    $file_tmp = $_FILES['file_import']['tmp_name'];
    move_uploaded_file($file_tmp, PLUGIN_PATH . 'uploads/' . $file_name );

    $products_imported =  array();
    if (($handle = fopen(PLUGIN_PATH . 'uploads/' . $file_name, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            array_push($products_imported,$data);
        }
        fclose($handle);
    }

    if(isset($_POST['import_new_price_list'])){ //if the user choose create anew list
        $new_price_list_name = $_POST['import_new_price_list'];
        if($price_list_controller->wrpl_exist_price_list_name($new_price_list_name)){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Price list name duplicated! </strong>The price list already exist, please choose other name.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
               </div>';

        }else{
            $price_list_id = $price_list_controller->wrpl_add_price_list($new_price_list_name);
            $result = $product_controller->wrpl_import_products($products_imported,$price_list_id);
        }
    }else{ //import base in existing price list
        $result = $product_controller->wrpl_import_products($products_imported,$_POST['price_list_id']);
    }
var_dump($result);

}

?>