<?php

include_once("appx/config/config2.php");
//include_once("./config/config2.php");
$elegido = $_POST['elegido2'];
if (isset($elegido)){
	$query = mysqli_query($mysqli, "SELECT count(p.product_id) as contador FROM test.product p
										INNER JOIN test.customer_product c ON (p.product_id=c.product_id)
										WHERE c.customer_id=1");
//echo '<option value="0">Seleccione:</option>';
	while ($valores = mysqli_fetch_array($query)) {			          				          
			          	//echo '<option value="'.$valores['product_id'].'">'.$valores['product_description'].'</option>';	
			          	echo $contador=$valores['contador'];            
			          }

			          if ($contador<=5){
			          	echo "Tiene  máximo $contador opciones de producto para facturar";
			          }

			          if ($contador>5){
			          	echo "Tiene $contador opciones de productos, puede facturar máximo 5 productos";
			          }



}

?>