<?php
require_once('conexion.php');
$conn=new Conexion();
$conection = $conn->conectarse();

$mesa = $_GET['mesa'];
$userID = $_GET['user'];

$sql = "SELECT ID_PEDIDO, ORDEN, ID_MESA, TOTAL, FECHA, HORA, ID_USUARIO_MESERO, ESTADO_ORDEN, ID_USUARIO_MESERO, NOMBRE, APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE ID_MESA = $mesa AND ESTADO_ORDEN = 'En proceso' AND PEDIDO_MESA.ID_USUARIO_MESERO = USUARIO.ID_USUARIO;";
$result = mysqli_query($conection,$sql);
$row_pedido=mysqli_fetch_assoc($result);
$id_pedido = $row_pedido['ID_PEDIDO'];

$sql = "SELECT * FROM MENU WHERE ID_ITEM_MENU > 15 AND ID_ITEM_MENU < 30;"
$result = mysqli_query($conection,$sql);





// Agregar productos a la cuenta
if(isset($_POST['agregar_productos']))
 {

	$estado = 'Esperando_mesero';
	$porcion = 0;

	if(!empty($_POST['lista_origen'])&&!empty($_POST['lista_porcion']))
	{
		$i=0;
		foreach($_POST['lista_origen'] as $selected)
		{	

			$array_producto = explode("*",$selected);

			$nombre = $array_producto[1];
			$precio = $array_producto[2];
			$porcion = $_POST['lista_porcion'][$i];
			$total = $precio*$porcion;

			$sql = "INSERT INTO PEDIDO (ID_PEDIDO, NOMBRE_PRODUCTO, CANTIDAD, PRECIO, 
					TOTAL, ESTADO_ORDEN) VALUES ($id_pedido, '$nombre', $porcion, $precio, 
					$total, '$estado')";
 			$result = mysqli_query($conection,$sql);

			$i++;
			$porcion = 0;

		}
	}

	$sql = "UPDATE MESA SET ESTADO='Pedido activo' WHERE ID_MESA = $mesa;";
	$result = mysqli_query($conection,$sql);
	
 }

// Iniciar pedido
if(isset($_POST['iniciar_pedido']))
 {
 	

 	if(!empty($_POST['lista_origen']))
	{
		if($row_pedido['ID_USUARIO_MESERO'] == 0)
		{
			$sql = "UPDATE PEDIDO_MESA SET ID_USUARIO_MESERO = $userID WHERE ID_PEDIDO = $id_pedido;";
			$result = mysqli_query($conection,$sql);
			
		}
		foreach($_POST['lista_origen'] as $selected)
		{	
			$sql = "UPDATE PEDIDO SET ESTADO_ORDEN = 'Esperando_cocinero' WHERE ID_PEDIDO_ITEM = $selected;";
 			$result = mysqli_query($conection,$sql);
		}
	}

 }

// Eliminar productos
if(isset($_POST['eliminar_productos']))
 {
 	if(!empty($_POST['lista_origen']))
	{
		foreach($_POST['lista_origen'] as $selected)
		{	
			$sql = "DELETE FROM PEDIDO WHERE ID_PEDIDO_ITEM = $selected;";
 			$result = mysqli_query($conection,$sql);
		}
	}

 }

// Terminar pedido
if(isset($_POST['finalizar_cuenta']))
 {
 	$total = 0;
 	$sql = "SELECT PEDIDO.ID_PEDIDO_ITEM,PEDIDO.ID_PEDIDO, PEDIDO.NOMBRE_PRODUCTO, PEDIDO.CANTIDAD, PEDIDO.PRECIO, PEDIDO.TOTAL, PEDIDO.ESTADO_ORDEN FROM PEDIDO, PEDIDO_MESA WHERE PEDIDO_MESA.ESTADO_ORDEN = 'En proceso' AND PEDIDO.ID_PEDIDO = PEDIDO_MESA.ID_PEDIDO AND PEDIDO_MESA.ID_MESA = $mesa";
 	$result = mysqli_query($conection,$sql);
 	while ($row=mysqli_fetch_assoc($result)) 
 	{
 		$total = $total + $row['TOTAL']; 
 	}
 		
 	$sql = "UPDATE PEDIDO_MESA SET TOTAL = $total, ID_USUARIO_CAJERO = $userID, ESTADO_ORDEN = 'Terminada' WHERE ID_PEDIDO = $id_pedido;";
 	$result = mysqli_query($conection,$sql);

 	$sql = "UPDATE MESA SET ESTADO = 'Disponible' WHERE ID_MESA = $mesa;";
 	$result = mysqli_query($conection,$sql);
 	
 	echo "<script> 
                  window.open( 'generar_recibo.php?id=".$id_pedido."', '_blank');
                  alert('hecho');
                  window.open( 'mesas.php?user=".$userID."', '_self');
          </script>";
 }


 ?>



<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function Activar_porcion(k)
	  	{
   			var checkbox = document.getElementById("Origen_"+k);
   			var input = document.getElementById("Porcion_"+k);
		   if(checkbox.checked)
		   {
		   	  input.disabled=false;   	  
		   }
		    else
		   {
		   	  input.value="NULL";
		      input.disabled=true;
		   }
			
		}
	</script>
	<style type="text/css">
		 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
	</style>
	<title></title>
</head>
<body>
	<?php include("menu_top.php") ?>
	<?php if($row_user['Tipo_Usuario'] != "NULL"){include("menu_side.php");}?>
	

	
	<div class="container x">
		<form action="mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $mesa;?>" method="post">
		<div class="col py-3" style="background-color: #dee3e1;">
			<div class="row justify-content-center text-center">
				<div class="col-3" style="background-color: white; border-radius: 10px">
					<font size=5>Registrar pedido</font>
				</div>
			</div>
			<br>

			<div class="col py-3 text-center" style="background-color: white; border-radius: 10px">
				<font size=4><?php echo "Mesa #".$mesa." | Mesero: ".$row_pedido['NOMBRE']." ".$row_pedido['APELLIDO_P'];?></font>
			</div>

			<br>

			<div class="col py-3" style="background-color: white; border-radius: 10px">
				<div class="row justify-content-center text-center">
					<div class="col-4" style="background-color: #c0e1ed; border-radius: 10px">
					<font size=4>Procutos</font>

				<div class="row rounded-top bg-theme6" id="rooms-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active tab" id="floor1-tab" data-toggle="tab" href="#floor1" role="tab" aria-controls="floor1" aria-selected="true">Bebidas</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor2-tab" data-toggle="tab" href="#floor2" role="tab" aria-controls="floor2" aria-selected="false">Entradas</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor3-tab" data-toggle="tab" href="#floor3" role="tab" aria-controls="floor3" aria-selected="false">Alimentos</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor4-tab" data-toggle="tab" href="#floor4" role="tab" aria-controls="floor4" aria-selected="false">Postres</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor5-tab" data-toggle="tab" href="#floor5" role="tab" aria-controls="floor5" aria-selected="false">Extras</a>
                        </li>
                    </ul>
                </div>

				<div class="form-row">
							    
							    <div class="form-group col-md-6 ">
							      <label for="inputPassword4">Nombre</label>  
							    </div>
							    <div class="form-group col-md-6">
							      <label for="inputPassword4">Cantidad</label>  
							    </div>
					</div>
                
                        <div class="tab-pane fade show active" id="floor1" role="tabpanel" aria-labelledby="floor1-tab" style="background-color: #c0e1ed;">

						<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 400px; overflow-y: scroll;">
					       	<table >
					    		
					    	<?php
								$sql="SELECT  MENU.ID_ITEM_MENU, MENU.NOMBRE, MENU.PRECIO_PUBLICO, INVENTARIO.CATEGORIA FROM MENU, INVENTARIO  WHERE MENU.ORIGEN = INVENTARIO.ID_ITEM AND INVENTARIO.CATEGORIA = 'Bebida' GROUP BY ID_ITEM_MENU ORDER BY CATEGORIA; ";
						 		$result = mysqli_query($conection,$sql);
							    while ($row=mysqli_fetch_assoc($result)) {
							      ?><tr style="width: 2%">
							      	<td><input type="checkbox" name="lista_origen[]" id="Origen_<?php echo $row['ID_ITEM_MENU']; ?>" onclick="Activar_porcion(<?php echo $row['ID_ITEM_MENU']; ?>)" value="<?php echo $row['ID_ITEM_MENU']."*".$row['NOMBRE']."*".$row['PRECIO_PUBLICO']; ?>">
							      	</td>
							      	<td style="width: 55%">
						          	<?php echo $row['NOMBRE']; ?>
						          </td>
						          <td>
						          	<input type="number" name="lista_porcion[]" id="Porcion_<?php echo $row['ID_ITEM_MENU']; ?>" disabled="disabled" class="form-control form-control" min="1" style="text-align: center;" placeholder="Cantidad" required> 
						          </td>
						          </tr>
						          <?php 
							    } 
							  	?>
							  </table>
							</div>
					</div>

				</div>
               

					<div class="col-1.4" style="background-color: white; border-radius: 10px">

						<div class="btn-group-vertical">
							<?php if($row_user['Tipo_Usuario'] ==  'Mesero'){?>         
							<button type="submit" name="agregar_productos" class="btn btn-custom-order m-auto" >Agregar</button>
							<button type="submit" name="iniciar_pedido" class="btn btn-custom-order m-auto" >Iniciar pedido</button>
							<button type="submit" name="eliminar_productos" class="btn btn-custom-order m-auto" >Eliminar</button>
							<?php }?>
							<?php if($row_user['Tipo_Usuario'] ==  'Cliente'){?>         
							<button type="submit" name="agregar_productos" class="btn btn-custom-order m-auto" >Agregar</button>
							<button type="submit" name="solicitar_pedido" class="btn btn-custom-order m-auto" >Solicitar pedido</button>
							<button type="submit" name="eliminar_productos" class="btn btn-custom-order m-auto" >Eliminar</button>
							<?php }?>
							<?php if($row_user['Tipo_Usuario'] ==  'Cajero'){?>
							<button type="submit" id="btn_Finalizar"  name="finalizar_cuenta"  class="btn btn-custom-order m-auto" >Finalizar Cuenta</button>
							
							<?php }?>
						</div>
					</div>
				
					<div class="col-6" style="background-color: #c0e1ed; border-radius: 10px">
					<font size=4>Cuenta</font>
						<div class="table_wrapper">
					


					<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 500px; overflow-y: scroll;">
					       	
					       	<table class="table table-hover" style="width:100%; text-align: center; ">
					       		<tr>
					       			<td>Producto</td>
					       			
					       			<td>Estado</td>
					       			
					       			<td>Cantidad</td>
					       			
					       			<td>Precio</td>
					       			
					       			<td>Total</td>
					       		</tr>
					       		
					    		
					    	<?php
								$sql="SELECT PEDIDO.ID_PEDIDO_ITEM,PEDIDO.ID_PEDIDO, PEDIDO.NOMBRE_PRODUCTO, PEDIDO.CANTIDAD, PEDIDO.PRECIO, PEDIDO.TOTAL, PEDIDO.ESTADO_ORDEN FROM PEDIDO, PEDIDO_MESA WHERE PEDIDO_MESA.ESTADO_ORDEN = 'En proceso' AND PEDIDO.ID_PEDIDO = PEDIDO_MESA.ID_PEDIDO AND PEDIDO_MESA.ID_MESA = $mesa;";
						 		$result = mysqli_query($conection,$sql);

							    while ($row=mysqli_fetch_assoc($result)) {
							      ?><tr>
							      	<td style="text-align: left;">
							      		<?php 
							      		$estado = $row['ESTADO_ORDEN'];
							      		switch ($estado) {
							      			case 'Esperando_mesero':
							      				?>
							      				<input type="checkbox" checked="" name="lista_origen[]" value="<?php echo $row['ID_PEDIDO_ITEM']; ?>">
							      					&nbsp<?php echo $row['NOMBRE_PRODUCTO'];?>
							      				<?php
							      				break;
							      			case 'Entregado_mesero':
							      				?>
							      				<input type="hidden" name="lista_entregado[]" value="<?php echo $row['ID_PEDIDO_ITEM']; ?>">
							      					&nbsp<?php echo $row['NOMBRE_PRODUCTO'];?>
							      				<?php
							      				break;
							      			default:
							      				echo "&nbsp".$row['NOMBRE_PRODUCTO'];
							      				break;
							      		}
							      		?>
							      		
							      	</td>
							      	
							      	<td>
							      		<?php echo $row['ESTADO_ORDEN'];?>
							      	</td>
							      	
							      	<td>
							      		<?php echo $row['CANTIDAD'];?>
							      	</td>
							      	
							      	<td>
							      		<?php echo $row['PRECIO'];?>
							      	</td>
							      	
							      	<td>
							      		<?php echo $row['TOTAL'];?>
							      	</td>

						          </tr>
						          <?php 
							    } 
							  	?>
							  </table>
							</div>
					</div>
					</div>



					
		</div>
	</div>	
			
		</div></div>
</form>
		
</body>
</html>