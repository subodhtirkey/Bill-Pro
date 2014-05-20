<?php 

    include_once"connect_to_database.php"; 

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Simple responsive css framework">
    <meta name="author" content="Sergey S. Pimenov, Ukraine, Kiev">

    <link href="css/metro-bootstrap.css" rel="stylesheet">
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="css/iconFont.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>

    <title>E-Billing System</title>
</head>
<body class="metro">
    <!--Navbar-->

    <div class="navigation-bar dark">
    <div class="navigation-bar-content container">
        <a href="/" class="element"><span class="icon-support"></span> BIll-Pro <sup>1.0</sup></a>
        <span class="element-divider"></span>

        <a class="element1 pull-menu" href="#"></a>
        <ul class="element-menu" style="">
            
        </ul>

        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Enter Product Id Here">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

        
    </div>
	</div>

<!--Container-->
    <div class="container">
     <div class="grid">
    		<div class="row">
    			<!--ITEM TYPE LIST-->
        		<div class="span4">
        			<h3>Product Type</h3>
        			<div class="listview-outlook">

        				<?php
        				$sql_list=mysql_query("SELECT distinct product_type FROM product");
        				
        				while ($row=mysql_fetch_array($sql_list)) {
        					$item_type=$row['product_type'];
        					$item_list.='<a href="#" class="list"><div class="list-content product_list" id="'.$item_type.'">'.$item_type.'</div></a>'; 
        				}
        				//Displaying the Item List
        				echo $item_list;
        				?>
    					
					</div>
        		</div>
        		<!--ITEM LIST-->
        		<div class="span8" id="product_display">
        			
                    <!--Display product Here -->
                   <!-- <button class="shortcut primary product_icon" id="102">dove</button>-->
        			
        		</div>
    		</div>
	  </div> 

	  <div class="grid">
    <div class="row">
        <div class="span8">
        	<!--BIll List-->
        	<table class="table striped" id="mytable">
                        <thead>
                        <tr>
                           
                            <th class="text-left">Product No.</th>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Qty.</th>
                            <th class="text-left">Price</th>
                        </tr>
                        </thead>

                        <tbody id="display_purchased_product">
                        <!--
                        <tr><td>1</td><td class="right">20012</td><td class="right">Pantene Pro V</td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        <tr><td>2</td><td class="right">20032</td><td class="right">Good Day Buscuit</td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        <tr><td>3</td><td class="right">20023</td><td class="right">Choco Pie</td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        <tr><td>4</td><td class="right">20023</td><td class="right">AirWick Rm Freshner </td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        <tr><td>5</td><td class="right">20022</td><td class="right">Axe Deo</td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        <tr><td>6</td><td class="right">20022</td><td class="right">Nivea Soap</td><td class="right">1</td><td class="right">200</td><td class="right"><a href="#"><i class="icon-cancel-2"></i></a></td></tr>
                        -->
                        </tbody>

                        <tfoot></tfoot>
                    </table>

        </div>
        <div class="span4" align="center">
        	<h2 align="center">TOTAL PRICE <span style="font-size:20px;">Rs.</span></h2>

        	<h3 align="center" id="price_display">0</h3>

        	<button class="primary">Print Bill</button>

            <button class="danger" id="clear" onclick="clear_list()" >Clear List</button>


        </div>
    </div>
</div>

     
    </div>



    

    
    <script>

        var url="code.php";

        var total_price = 0;

		$(document).ready(function() {


    		$('.product_list').click(function(){
    				product_t = this.id;

                    $.post(url,{request:"product_type_list",product_type:product_t}, function(data)
                        {
                            $("#product_display").html(data);

                            //alert(data);
                         }); 

    				
				});



		}); 

function displaycount(element){

        var id = element.id;
        var name = element.name;
        

        $.Dialog({
        overlay: true,
        shadow: true,
        flat: true,
        icon: '<span class="icon-support"></span>',
        title: 'Enter The Quantity',
        padding: 20,
        content: '',

        onShow: function(_dialog){
            var content = _dialog.children('.content');
            content.html(name + 
                            '<input type="number" id="count_input" data-transform="input-control" value="1"  />'+ 
                            '<button class="primary" id="'+id+'" name="'+name+'" onclick="display_list(this)">Done</button>');
        }
    });


}

function display_list(element1){

    var id = element1.id;
    var name = element1.name;
    var count= parseFloat(document.getElementById('count_input').value);

   

   $.Dialog.close();

    
    

    /*Code to

        1. get the cost of the item using product_id
        2. multiply the cost by count 
        3. append the data into the table as a new tupple   

    */

      $.post(url,{request:"product_list",product_id:id}, function(data)
                        {
                            var data = JSON.parse(data);
                            console.log(data.product_id);

                            var display_data ='<tr class="'+data.product_name+'" onclick="delete_row(this)" id="'+(count*data.product_price)+'"><td class="right">'+data.product_id+'</td><td class="right">'+data.product_name+'</td><td class="right">'+count+'</td><td class="right">'+(count*data.product_price)+'</td></tr>';

                            $("#display_purchased_product").append(display_data);    

                            total_price = total_price + (count*data.product_price);

                            $('#price_display').html(total_price);         



                         }); 



 

}

function delete_row(element){

    var rIndex = element.rowIndex;
    var price = element.id;
    var pname = element.className;
    alert("The product "+pname+" will be deleted from the list");
    document.getElementById('mytable').deleteRow(rIndex);

     total_price = total_price -price;
     $('#price_display').html(total_price);  

}


function clear_list(){

    total_price = 0;
    var nothing = '';
   
    //document.getElementById("display_purchased_product").innerhtml('');
    $('#price_display').html(total_price);
    $('#display_purchased_product').html(nothing);
}




    </script>

</body>
</html>
