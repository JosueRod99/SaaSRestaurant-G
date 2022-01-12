<?php 
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();
 $id = $_GET['user'];

	// Entregar pedido
	if(isset($_POST['entregar_pedido']))
	 {	
	 	$id_item = $_POST['ID_item'];
	 	
		//Codigo para divir en segmentos los pedidos
	 	

		$array_pedido = new ArrayObject();
		$array_pedido_paquete = new ArrayObject();
	 	
	 	foreach($_POST['items_pedido'] as $selected)
	 	{	
	 		$array_producto = explode("*",$selected);
	 		$array_pedido->append($array_producto);	
	 	}
		
		$i = 0; 
		$temp_id_pedido =  $array_pedido[0][1];
		$temp_hora =  $array_pedido[0][2];

	 	foreach ($array_pedido as $selected) 
	 	{	
	 		if($selected[1] == $temp_id_pedido and $selected[2] == $temp_hora)
	 		{
	 			$array_pedido_paquete->append($selected);
	 		}
	 		else
	 		{	
	 			if($array_pedido_paquete[$i][0] == $id_item )
	 			{	

	 				for ($j=0; $j < count($array_pedido_paquete) ; $j++) 
	 				{ 
	 					$ID = $array_pedido_paquete[$j][0];
	 					$sql = "UPDATE PEDIDO SET ESTADO_ORDEN = 'Entregado_mesero' WHERE ID_PEDIDO_ITEM = $ID;";
						$result = mysqli_query($conection,$sql);	
	 				}
	 				break;	
	 			}
	 			

	 			$array_pedido_paquete = new ArrayObject();
	 			$array_pedido_paquete->append($selected);

	 			$temp_id_pedido =  $selected[1];
				$temp_hora =  $selected[2];
	 		}


	 		
	 	}

	 	
	 	// Termina división

	 	
	 }



	// pedido_preparado
	if(isset($_POST['pedido_preparado']))
	 {	
	 	$id_item = $_POST['ID_item'];
	 	
		//Codigo para divir en segmentos los pedidos
	 	

		$array_pedido = new ArrayObject();
		$array_pedido_paquete = new ArrayObject();
	 	
	 	foreach($_POST['items_pedido'] as $selected)
	 	{	
	 		$array_producto = explode("*",$selected);
	 		$array_pedido->append($array_producto);	
	 	}
		
		$i = 0; 
		$temp_id_pedido =  $array_pedido[0][1];
		$temp_hora =  $array_pedido[0][2];

	 	foreach ($array_pedido as $selected) 
	 	{	
	 		if($selected[1] == $temp_id_pedido and $selected[2] == $temp_hora)
	 		{
	 			$array_pedido_paquete->append($selected);
	 		}
	 		else
	 		{	
	 			if($array_pedido_paquete[$i][0] == $id_item )
	 			{	

	 				for ($j=0; $j < count($array_pedido_paquete) ; $j++) 
	 				{ 
	 					$ID = $array_pedido_paquete[$j][0];
	 					$sql = "UPDATE PEDIDO SET ESTADO_ORDEN = 'Listo_cocina' WHERE ID_PEDIDO_ITEM = $ID;";
						$result = mysqli_query($conection,$sql);	
	 				}
	 				break;	
	 			}
	 			

	 			$array_pedido_paquete = new ArrayObject();
	 			$array_pedido_paquete->append($selected);

	 			$temp_id_pedido =  $selected[1];
				$temp_hora =  $selected[2];
	 		}


	 		
	 	}

	 	
	 	// Termina división

	 	
	 }




	//Iniciar pedido 
	 if(isset($_POST['iniciar_pedido']))
	 {	
	 	$id_item = $_POST['ID_item'];
	 	
		//Codigo para divir en segmentos los pedidos
	 	

		$array_pedido = new ArrayObject();
		$array_pedido_paquete = new ArrayObject();
	 	
	 	foreach($_POST['items_pedido'] as $selected)
	 	{	
	 		$array_producto = explode("*",$selected);
	 		$array_pedido->append($array_producto);	
	 	}
		
		$i = 0; 
		$temp_id_pedido =  $array_pedido[0][1];
		$temp_hora =  $array_pedido[0][2];

	 	foreach ($array_pedido as $selected) 
	 	{	
	 		if($selected[1] == $temp_id_pedido and $selected[2] == $temp_hora)
	 		{
	 			$array_pedido_paquete->append($selected);
	 		}
	 		else
	 		{	
	 			if($array_pedido_paquete[$i][0] == $id_item )
	 			{	

	 				for ($j=0; $j < count($array_pedido_paquete) ; $j++) 
	 				{ 
	 					$ID = $array_pedido_paquete[$j][0];
	 					$sql = "UPDATE PEDIDO SET ESTADO_ORDEN = 'En_preparacion' WHERE ID_PEDIDO_ITEM = $ID;";
	 					$result = mysqli_query($conection,$sql);	
	 				}
	 				break;	
	 			}
	 			

	 			$array_pedido_paquete = new ArrayObject();
	 			$array_pedido_paquete->append($selected);

	 			$temp_id_pedido =  $selected[1];
				$temp_hora =  $selected[2];
	 		}


	 		
	 	}

	 	
	 	// Termina división

	 	
	 }
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<script type="text/javascript"></script>
	<title></title>
	<style type="text/css">
			button {
				  outline: none !important;
				  border: none;
				  background: transparent;
				}

			button:hover {
			  cursor: pointer;
			}
		.myth
		{
			width: 10%;
			background-color: #9cd3e6;
		}

	</style>
	<script type="text/javascript">
		function Activar(k)
		{
			
			var checkbox = document.getElementById("id_item_terminar_"+k);
   			var input = document.getElementById("btn_item_terminar_"+k);

		   if(checkbox.checked)
		   {
		   	  input.disabled=false;   	  
		   }
		    else
		   {
		   	  checkbox.checked=false;
		      input.disabled=true;
		   }
		}

		function Activar_Entregado(k)
		{
			
			var checkbox = document.getElementById("id_item_entregar_"+k);
   			var input = document.getElementById("btn_item_entregar_"+k);

		   if(checkbox.checked)
		   {
		   	  input.disabled=false;   	  
		   }
		    else
		   {
		   	  checkbox.checked=false;
		      input.disabled=true;
		   }
		}

	</script>
	
</head>
<body>
	<form action="pedidos_activos.php?user=<?php echo $id;?>" method="post" >
	<?php include("menu_top.php") ?>
	<?php if($row_user['Tipo_Usuario']!= 'NULL'){include("menu_side.php");} ?>

	<div class="container">
		<div class="col py-3" style="background-color: #dee3e1;">
			
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Pedidos activos</font>
					</div>
				</div>
			<br>

			<!-- Nuevos pedidos -->
			<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 400px; overflow-y: scroll;">
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Nuevos pedidos</font>
					</div>

				</div>
			<br><!-- Aqui va el pedido -->
			
				<div class="row justify-content-center text-center">
					
						

						<?php 
        			$sql = "SELECT USUARIO.NOMBRE, PEDIDO_MESA.ID_MESA, PEDIDO.ID_PEDIDO_ITEM, PEDIDO.ID_PEDIDO, PEDIDO.NOMBRE_PRODUCTO, PEDIDO.CANTIDAD, PEDIDO.ESTADO_ORDEN, PEDIDO.HORA, PEDIDO.ID_PEDIDO_ITEM, PEDIDO_MESA.ID_USUARIO AS CLIENTE FROM USUARIO, PEDIDO_MESA, PEDIDO WHERE PEDIDO.ESTADO_ORDEN = 'Esperando_cocinero' AND PEDIDO.ID_PEDIDO = PEDIDO_MESA.ID_PEDIDO AND PEDIDO_MESA.ID_USUARIO_MESERO = USUARIO.ID_USUARIO AND PEDIDO_MESA.ID_USUARIO = $id_cliente ORDER BY HORA asc;";
        			$result=mysqli_query($conection, $sql);
        			
        			
        				$first = TRUE; 
        				$hora_pedido = '';
        				$id_orden = 0 ;

        				$flag_col= TRUE;
        				$columnas = 0; 
        			


        				$hora = '';
						while ($row=mysqli_fetch_assoc($result)){

							

							if($id_orden != $row['ID_PEDIDO'])
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				

							if($id_orden == 0)
							{?>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			
				  			<table class="myTable" style="width: 100%; background: white; border-radius: 10px">
				  				<tr><th colspan="3" style="border-bottom:  solid 1px; background-color: #cedade; border-top-left-radius: 10px; border-top-right-radius: 10px "><h5 class="card-title text-center" >Mesa <?php echo $row['ID_MESA']." | "."Mesero ".$row['NOMBRE']; ?></h5></th>
				  					<?php
							 		if($first and $row_user['Tipo_Usuario'] ==  'Cocinero')
							 			{?>

							 		<input type="radio" checked  style="display:none;" name="ID_item" id="id_item" value="<?php echo $row['ID_PEDIDO_ITEM'];?>">
				  					<th rowspan="50" class="myth">
				  						<button type="submit" name="iniciar_pedido" id="iniciar_submit">
		  											<i class="btn fas fa-play fa-3x"></i>
											</button>Iniciar
										
				  					</th>
				  						<?php $first = False;
				  					}?>	
				  				</tr>

								
					  			
				  			</tr>
				  				<tr>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Orden</h5></th>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th style="border-bottom: solid 1px;" class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  					
				  				</tr>
				  				
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

							<?php
							 if($id_orden == $row['ID_PEDIDO'] and $hora != $row['HORA'] )
							 	{?>

							 		</table>


			  					</div>	
			  					</div>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			<table class="myTable" style="width: 100%; background: white;">
				  				<tr>

				  					<th><h5 class="card-title text-center" >Orden</h5></th>
				  					<th><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  				</tr>
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

			  	<!-- Card con comentario  -->
			  				<?php
			  				if($id_orden == $row['ID_PEDIDO'] && $hora == $row['HORA'])
			  				{?>
							<tr>	<input type="hidden" name="items_pedido[]" value="<?php echo $row['ID_PEDIDO_ITEM']."*". $row['ID_PEDIDO']."*".$row['HORA'];?>">
								
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['ID_PEDIDO']; ?></h5></td>
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['NOMBRE_PRODUCTO']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['CANTIDAD']; ?></h5></td>		
			  				</tr>

			  				<?php
			  				
			  				}
			  				else
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  						
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				?>

			  <?php 
				}//Fin While
			?>
			  					</table>



			  					</div>	
			  					</div>		
			  			
			  		
				
				<!-- Termina Card con comentario -->
			  


					
				</div>
				<!-- Termina  Nuevos pedidos -->




				<br><br>

			<!-- Pedidos en proceso -->
			<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 400px; overflow-y: scroll;">
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Pedidos en proceso</font>
					</div>

				</div>
			<br><!-- Aqui va el pedido -->
			
				<div class="row justify-content-center text-center">
					
						

						<?php 
        			$sql = "SELECT USUARIO.NOMBRE, PEDIDO_MESA.ID_MESA, PEDIDO.ID_PEDIDO_ITEM, PEDIDO.ID_PEDIDO, PEDIDO.NOMBRE_PRODUCTO, PEDIDO.CANTIDAD, PEDIDO.ESTADO_ORDEN, PEDIDO.HORA FROM USUARIO, PEDIDO_MESA, PEDIDO WHERE PEDIDO.ESTADO_ORDEN = 'En_preparacion' AND PEDIDO.ID_PEDIDO = PEDIDO_MESA.ID_PEDIDO AND PEDIDO_MESA.ID_USUARIO_MESERO = USUARIO.ID_USUARIO AND PEDIDO_MESA.ID_USUARIO = $id_cliente ORDER BY HORA;";
        			$result=mysqli_query($conection, $sql);

        			
        				
        				$hora_pedido = '';
        				$id_orden = 0 ;

        				$flag_col= TRUE;
        				$columnas = 0; 
        			


        				$hora = '';
						while ($row=mysqli_fetch_assoc($result)){


							if($id_orden != $row['ID_PEDIDO'])
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				

							if($id_orden == 0)
							{?>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			
				  			<table class="myTable" style="width: 100%; background: white; border-radius: 10px">
				  				<tr><th colspan="3" style="border-bottom:  solid 1px; background-color: #cedade; border-top-left-radius: 10px; border-top-right-radius: 10px "><h5 class="card-title text-center" >Mesa <?php echo $row['ID_MESA']." | "."Mesero ".$row['NOMBRE']; ?></h5></th>
				  					
							 		<?php if ($row_user['Tipo_Usuario'] ==  'Cocinero'){?>
							 		
				  					<th rowspan="50" class="myth">
										<input type="radio" name="ID_item" id="id_item_terminar_<?php echo $row['ID_PEDIDO_ITEM'];?>" value="<?php echo $row['ID_PEDIDO_ITEM'];?>" onClick="Activar(<?php echo $row['ID_PEDIDO_ITEM'];?>)">
				  						<button type="submit" name="pedido_preparado" id="btn_item_terminar_<?php echo $row['ID_PEDIDO_ITEM'];?>" disabled>
		  											<i class="btn fas fa-check-square fa-3x"></i>
											</button>Terminar

				  					</th>
				  					<?php }?>
				  				</tr>
				  				

								
					  			
				  			</tr>
				  				<tr>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Orden</h5></th>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th style="border-bottom: solid 1px;" class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  					
				  				</tr>
				  				
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

							<?php
							 if($id_orden == $row['ID_PEDIDO'] and $hora != $row['HORA'] )
							 	{?>

							 		</table>


			  					</div>	
			  					</div>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			<table class="myTable" style="width: 100%; background: white;">
				  				<tr>

				  					<th><h5 class="card-title text-center" >Orden</h5></th>
				  					<th><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  				</tr>
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

			  	<!-- Card con comentario  -->
			  				<?php
			  				if($id_orden == $row['ID_PEDIDO'] && $hora == $row['HORA'])
			  				{?>
							<tr>
							<input type="hidden" name="items_pedido[]" value="<?php echo $row['ID_PEDIDO_ITEM']."*". $row['ID_PEDIDO']."*".$row['HORA'];?>">	
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['ID_PEDIDO']; ?></h5></td>
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['NOMBRE_PRODUCTO']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['CANTIDAD']; ?></h5></td>		
			  				</tr>

			  				<?php
			  				
			  				}
			  				else
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  						
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				?>

			  <?php 
				}//Fin While
			?>
			  					</table>
			  					</div>	
			  					</div>		
			  			
			  		
				
				<!-- Termina Card con comentario -->
			  


					
				</div>
				<!-- Termina  Nuevos pedidos -->

				<br><br>


				<!-- Pedidos terminados -->
			<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 400px; overflow-y: scroll;">
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Pedidos Terminados</font>
					</div>

				</div>
			<br><!-- Aqui va el pedido -->
			
				<div class="row justify-content-center text-center">
					
						

						<?php 
						
        			$sql = "SELECT USUARIO.NOMBRE, PEDIDO_MESA.ID_MESA, PEDIDO.ID_PEDIDO_ITEM, PEDIDO.ID_PEDIDO, PEDIDO.NOMBRE_PRODUCTO, PEDIDO.CANTIDAD, PEDIDO.ESTADO_ORDEN, PEDIDO.HORA, USUARIO.ID_USUARIO FROM USUARIO, PEDIDO_MESA, PEDIDO WHERE PEDIDO.ESTADO_ORDEN = 'Listo_cocina' AND PEDIDO.ID_PEDIDO = PEDIDO_MESA.ID_PEDIDO AND PEDIDO_MESA.ID_USUARIO_MESERO = USUARIO.ID_USUARIO AND PEDIDO_MESA.ID_USUARIO = $id_cliente ORDER BY HORA;";
        			
        			$result=mysqli_query($conection, $sql);

        			
        				
        				$hora_pedido = '';
        				$id_orden = 0 ;

        				$flag_col= TRUE;
        				$columnas = 0; 
        			


        				$hora = '';
						while ($row=mysqli_fetch_assoc($result)){


							if($id_orden != $row['ID_PEDIDO'])
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				

							if($id_orden == 0)
							{?>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			
				  			<table class="myTable" style="width: 100%; background: white; border-radius: 10px">
				  				<tr><th colspan="3" style="border-bottom:  solid 1px; background-color: #cedade; border-top-left-radius: 10px; border-top-right-radius: 10px "><h5 class="card-title text-center" >Mesa <?php echo $row['ID_MESA']." | "."Mesero ".$row['NOMBRE']; ?></h5></th>
				  					
							 		<?php if ($row_user['Tipo_Usuario'] ==  'Mesero' && $row_user['ID_Usuario'] == $row['ID_USUARIO']){?>
				  					<th rowspan="50" class="myth">

				  						<input type="radio" name="ID_item" id="id_item_entregar_<?php echo $row['ID_PEDIDO_ITEM'];?>" value="<?php echo $row['ID_PEDIDO_ITEM'];?>" onClick="Activar_Entregado(<?php echo $row['ID_PEDIDO_ITEM'];?>)">
				  						<button type="submit" name="entregar_pedido" id="btn_item_entregar_<?php echo $row['ID_PEDIDO_ITEM'];?>" disabled>
		  											<i class="btn fas fa-play fa-3x"></i>
											</button>Entregado

				  						
				  					</th>
				  					<?php } ?>

				  				</tr>

								
					  			
				  			</tr>
				  				<tr>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Orden</h5></th>
				  					<th style="border-right: solid 1px; border-bottom: solid 1px;"><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th style="border-bottom: solid 1px;" class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  					
				  				</tr>
				  				
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

							<?php
							 if($id_orden == $row['ID_PEDIDO'] and $hora != $row['HORA'] )
							 	{?>

							 		</table>


			  					</div>	
			  					</div>
						<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

				  		<div class="card-body text-center">
				  			
				  			<table class="myTable" style="width: 100%; background: white;">
				  				<tr>
				  					
				  					<th><h5 class="card-title text-center" >Orden</h5></th>
				  					<th><h5 class="card-title text-center" >Producto/Platillo</h5></th>
				  					<th class="myTh-border"><h5 class="card-title text-center" >Cantidad</h5></th>
				  				</tr>
				  				<?php
				  			$id_orden = $row['ID_PEDIDO'];
				  			$hora = $row['HORA'];	
							}?>

			  	<!-- Card con comentario  -->
			  				<?php
			  				if($id_orden == $row['ID_PEDIDO'] && $hora == $row['HORA'])
			  				{?>
							<tr>	
								<input type="hidden" name="items_pedido[]" value="<?php echo $row['ID_PEDIDO_ITEM']."*". $row['ID_PEDIDO']."*".$row['HORA'];?>">
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['ID_PEDIDO']; ?></h5></td>
			  					<td style="border-right: solid 1px;"><h5 class="card-title text-center" ><?php echo $row['NOMBRE_PRODUCTO']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['CANTIDAD']; ?></h5></td>		
			  				</tr>

			  				<?php
			  				
			  				}
			  				else
			  				{ $id_orden = 0;
			  				   $hora = '';
			  				   ?>
			  					</table>
			  						
			  					</div>	
			  					</div>
			  					<?php
			  				}
			  				?>

			  <?php 
				}//Fin While
			?>
			  					</table>
			  					</div>	
			  					</div>		
			  			
			  		
				
				<!-- Termina Card con comentario -->
			  


					
				</div>
				<!-- Termina pedidos terminados -->



		</div>		
	</div>
</div>
</form>
</body>
</html>