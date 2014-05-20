<?php

//Connect to database

include_once"connect_to_database.php"; 

//Important variables

$item_list = NULL ;

$item_t = NULL;

if($_POST['request']=='product_type_list'){

	$product_type=$_POST['product_type'];


	$sql_list=mysql_query("SELECT distinct * FROM product WHERE product_type='$product_type'");

                                      
        				
        				while ($row=mysql_fetch_array($sql_list)) {
        					$item_type=$row['product_name'];
        					$item_id=$row['product_id'];
        					$item_price=$row['price'];
                                                
        					$item_list.='<button class="shortcut primary product_icon" onclick="displaycount(this)" name="'.$item_type.'" id="'.$item_id.'">'.$item_type.'  Rs. '.$item_price.'</button>';
        					$item_list.='  '; 
        				}
        				//Displaying the Item List
        				echo $item_list;

                                        


}
else if ($_POST['request']=='product_list') {
	
	$product_id=$_POST['product_id'];

	$sql_list=mysql_query("SELECT distinct * FROM product WHERE product_id='$product_id'");

	while ($row=mysql_fetch_array($sql_list)) {
        					$item_type=$row['product_name'];
        					$item_id=$row['product_id'];
        					$item_price=$row['price'];
        					
        				}

        				echo json_encode(array('product_id' => $item_id,'product_name' => $item_type,'product_price' => $item_price));
        				
}

?>