<?php

 include_once(APPPATH."config/config2.php");




					
 if(isset($_POST['filtrar']) && isset($_POST['fecha_inicial']) &&
	   isset($_POST['fecha_final'])){
	
	$customer_id=$_POST['cliente'];	
	 $fecha_inicial=$_POST['fecha_inicial'];	
	 $fecha_final=$_POST['fecha_final'];	


	if ($fecha_final>=$fecha_inicial){

		//direccion donde se solicita los datos del cliente

		$datos=json_decode(file_get_contents("http://localhost:8000/prueba_beitech_codeigniter/api/read_one?customer_id=$customer_id&fecha_inicial='$fecha_inicial'&fecha_final='$fecha_final'"),true); 
	

		if ($datos=="No record found"){

			//alerta
			   echo '<script language="javascript">alert("No hay ordenes registradas en el rango de fechas señalado");</script>'; 
	

			    }
	
	}else{
		//alerta
		echo '<script language="javascript">alert("fecha inicial es mayor que la fecha final, porfavor corrija las fechas");</script>'; 
	}
	
}
 						

?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Homepage</title>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<style type="text/css">
			.table > tbody > tr > td {vertical-align: middle;}
		</style>
	</head>
	<body>
	<div class="container" style="padding: 3% 0 0;">
		<h1 class="page-header text-center">LISTADO DE ORDENES</h1>
    <br/>
     <div class="col-sm-12">
     	 <form name="form1" method="post">
     	 	<div class="row">
     	 		<div class="col-sm-4 form-group">
     			<label>Cliente:</label>
	     	 	<select id="cliente" name="cliente">

	        <?php
	          $query = mysqli_query($mysqli, "SELECT * FROM test.customer");

	          while ($valores = mysqli_fetch_array($query)) {
	          	if(isset($_POST["cliente"]) && $_POST["cliente"]==$valores['customer_id']){
	          		echo '<option value="'.$valores['customer_id'].'" selected>'.$valores['name'].'</option>';
	          	}else{
	          		echo '<option value="'.$valores['customer_id'].'">'.$valores['name'].'</option>';
	          	}
	            
	          }
	        ?>
	      </select>

     		</div>

     	 	    	
     	 	</div>
     	 	<br>
     		
     	 	<div class="row">
     	 		<div class="col-sm-4 form-group">
					<label>Fecha de inicio:</label>
					<?php
					if(isset($_POST["fecha_inicial"])){						
					?>
					<input type="date" class="form-control"  name="fecha_inicial" value="<?php echo $_POST["fecha_inicial"]; ?>" required>
					<?php
					}else{	
					?>
					
					<input type="date" class="form-control"  name="fecha_inicial" required>
					<?php
					}
					?>
			</div>	
     	 		<div class="col-sm-4 form-group">
			
					<label>Fecha de terminación:</label>
							<?php
					if(isset($_POST["fecha_final"])){						
					?>
					<input type="date" class="form-control"  name="fecha_final" value="<?php echo $_POST["fecha_final"]; ?>" required>
					<?php
					}else{	
					?>
					
					<input type="date" class="form-control"  name="fecha_final" required>
					<?php
					}
					?>
			
     	    </div>
     	 	</div>
     	 	<br>
     	 	<br>
     	 	<div class="row">
     	 	<div class="col-sm-1 form-group" align="left">
     	 		<input type="submit" name="filtrar" value="Filtrar">
     	 	</div>
			<div class="col-sm-11">
				<span class="pull-right"><a href="<?php echo base_url(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Volver</a></span>
			</div>
          
		</div>
     		
		
		</form>
     </div>
          <BR><BR>
    <div class="row">


    	<div class="col-sm-12">
			<table class="table table-bordered table-striped table-responsive-sm">
				<thead>
					<tr bgcolor="#b9c9fe" style="color: #039">
			            <th>Creation Date</th>
			            <th>Order ID</th>
			            <th>Total</th>
			            <th>Delivery Address</th>
			            <th>Products</th>
					</tr>
				</thead>
				<tbody>
				<?php
			if(isset($datos) && $datos!='No record found'){
				if(!is_null($datos)){
					foreach ($datos as $res){
						 echo "<tr>";
				         echo "<td>".$res['creation_date']."</td>";
				         echo "<td>".$res['order_id']."</td>";
				         echo "<td>".$res['total']."</td>";
				         echo "<td>".$res['delivery_address']."</td>";
				         echo "<td>".$res['OrderDetails']."</td>";          				         				         
					}
				}

			}	
				?>
				</tbody>
			</table>			  
		</div>
	</div>

		<br>
	</div>
	</body>
</html>