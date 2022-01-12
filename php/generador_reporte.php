 <?php
require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();

 $tipo_reporte = $_POST['reporte'];
 $fname = "Test.xls";
 date_default_timezone_set('America/Mazatlan');
 $hoy = getdate();
 $fecha_hoy = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
 $ID_USER = $_POST['id_user'];

	echo pack("CCC",0xef,0xbb,0xbf);
	//header("Content-type:application/x-msexcel; charset=utf-8");
 	
	//Nombre de los meses en arreglos
	$meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');

	//Función para sacar los días de x semana

	function week_from_monday($date) {
    // Assuming $date is in format DD-MM-YYYY
    list($day, $month, $year) = explode("-", $date);

    // Get the weekday of the given date
    $wkday = date('l',mktime('0','0','0', $month, $day, $year));

    switch($wkday) {
        case 'Monday': $numDaysToMon = 0; break;
        case 'Tuesday': $numDaysToMon = 1; break;
        case 'Wednesday': $numDaysToMon = 2; break;
        case 'Thursday': $numDaysToMon = 3; break;
        case 'Friday': $numDaysToMon = 4; break;
        case 'Saturday': $numDaysToMon = 5; break;
        case 'Sunday': $numDaysToMon = 6; break;   
    }

    // Timestamp of the monday for that week
    $monday = mktime('0','0','0', $month, $day-$numDaysToMon, $year);

    $seconds_in_a_day = 86400;

    // Get date for 7 days from Monday (inclusive)
    for($i=0; $i<7; $i++)
    {
        $dates[$i] = date('Y-m-d',$monday+($seconds_in_a_day*$i));
    }

    return $dates;
	}

	

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src='https://cdn.plot.ly/plotly-2.4.2.min.js'></script>
	<style type="text/css">
		.table th,td
		{
			text-align: center;

		}
		.tdNombre 
		{
			width: 250px;
			border-top: 2px solid;
		}
		.first_row
		{
			border-top: 2px solid;
		}
		.no_border
		{
			border: 0px;
		}
	</style>
	<script type="text/javascript">
		var data = [
		  {
		    x: ['giraffes', 'orangutans', 'monkeys'],
		    y: [20, 14, 23],
		    type: 'bar'
		  }
		];

		Plotly.newPlot('myDiv', data);

	</script>
</head>
<body>
	
 <?php
	  switch ($tipo_reporte) 
	 {
	 	case 0: //Reporte de ventas del día
	 	$fname = "Reporte de ventas del ".$fecha_hoy.".xls";
	 	header("Content-Disposition: attachment; filename=$fname");
	 		
	 	?>
	 	
	 	<table style="border:solid 2px; ">

		<?php
		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Orden</th>
			<th class="first_row">Mesa</th>
			<th class="first_row">Hora</th>
			<th class="first_row">Cajero</th>
			<th class="first_row">Mesero</th>
			<th class="first_row">Nombre</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Precio</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$first_row = True;
		 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>		
		<tr>
			<td class="first_row"><?php echo $row['Orden'];?></td>
			<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
			<td class="first_row"><?php echo $row['Hora'];?></td>

			<?php

			$id_pedido = $row['ID_Pedido'];
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}
			
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}

			$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
			$result_items = mysqli_query($conection,$sql_items);
			while ($row_i=mysqli_fetch_assoc($result_items))
 			{	
 				
 				
 				if($first_row)
 				{?>

 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
 					
 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
 					</tr>
 				<?php
 				$first_row = False;
 				}

 				else
 				{?>	
 				<tr>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td><?php echo $row_i['Nombre_producto'];?></td>
 					<td><?php echo $row_i['Cantidad'];?></td>
 					<td><?php echo "$ ".$row_i['Precio'];?></td>
 					<td><?php echo "$ ".$row_i['Total'];?></td>
 				</tr>
 				<?php
 				}
 			}


			?>
		</tr>
		<?php 
		$first_row = True;
		?>
 				<tr>
 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
 					<th><?php echo "$ ".$row['Total'];?></th>
 				</tr>
 				<?php 
		}
		?>
		<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
	</table>


	 	<?php	
	 		break;
	 	case 1: // Reporte de ventas de algún día

	 	$fecha_hoy = $_POST['dia_ventas'];
	 	$fname = "Reporte de ventas del ".$fecha_hoy.".xls";
	 	header("Content-Disposition: attachment; filename=$fname");
	 	?>

	 	<table style="border:solid 2px; ">

		<?php
		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Orden</th>
			<th class="first_row">Mesa</th>
			<th class="first_row">Hora</th>
			<th class="first_row">Cajero</th>
			<th class="first_row">Mesero</th>
			<th class="first_row">Nombre</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Precio</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$first_row = True;
		 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>		
		<tr>
			<td class="first_row"><?php echo $row['Orden'];?></td>
			<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
			<td class="first_row"><?php echo $row['Hora'];?></td>

			<?php

			$id_pedido = $row['ID_Pedido'];
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}
			
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}

			$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
			$result_items = mysqli_query($conection,$sql_items);
			while ($row_i=mysqli_fetch_assoc($result_items))
 			{	
 				
 				
 				if($first_row)
 				{?>

 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
 					
 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
 					</tr>
 				<?php
 				$first_row = False;
 				}

 				else
 				{?>	
 				<tr>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td><?php echo $row_i['Nombre_producto'];?></td>
 					<td><?php echo $row_i['Cantidad'];?></td>
 					<td><?php echo "$ ".$row_i['Precio'];?></td>
 					<td><?php echo "$ ".$row_i['Total'];?></td>
 				</tr>
 				<?php
 				}
 			}


			?>
		</tr>
		<?php 
		$first_row = True;
		?>
 				<tr>
 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
 					<th><?php echo "$ ".$row['Total'];?></th>
 				</tr>
 				<?php 
		}
		?>
		<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
	</table>


	 	<?php
	 		break;
	 	case 2://Reporte del mes

	 		$mes_info = $_POST["mes_ventas"];
	 		$mes_o = $mes_info."-1";
			$mes = explode('-', $mes_o);
			$mes_num = intval($mes[1]);
			$fname = "Reporte de ventas del mes de ".$meses[$mes_num].".xls";
			header("Content-Disposition: attachment; filename=$fname");

			$par_mes = $mes[1];

			if($par_mes != '12')
			{
				$par_mes = intval($par_mes)+1;

				$mes_f = $mes[0]."-".strval($par_mes)."-1";
			}
			else
			{
				$par_año = intval($mes[0])+1;
				$mes_f = $par_año."-1-1";
			}

			?>


			<table style="border:solid 2px; ">

				<?php
				 	$sql="SELECT * FROM REST_INFO;";
		 			$result = mysqli_query($conection,$sql);
		 			while ($row=mysqli_fetch_assoc($result))
		 			{ ?>
					<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
					<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
					<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
					<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
					<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
				<?php }?>


				<tr >
					<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del mes de <?php echo $meses[$mes_num];?> </th>
				</tr>
				<tr>
					<th class="first_row">Orden</th>
					<th class="first_row">Mesa</th>
					<th class="first_row">Fecha</th>
					<th class="first_row">Cajero</th>
					<th class="first_row">Mesero</th>
					<th class="first_row">Nombre</th>
					<th class="first_row">Cantidad</th>
					<th class="first_row">Precio</th>
					<th class="first_row">Total</th>
				</tr>
				 <?php
				 	$first_row = True;
				 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA >= '$mes_o' AND FECHA <= '$mes_f' ORDER BY FECHA;";
		 			$result = mysqli_query($conection,$sql);
		 			while ($row=mysqli_fetch_assoc($result))
		 			{ ?>		
				<tr>
					<td class="first_row"><?php echo $row['Orden'];?></td>
					<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
					<td class="first_row"><?php echo $row['Fecha']." ".$row['Hora'];?></td>

					<?php

					$id_pedido = $row['ID_Pedido'];
					$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
					$result_cajero = mysqli_query($conection,$sql_cajero);
					while ($row_cajero=mysqli_fetch_assoc($result_cajero))
		 			{
					?>
					<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
					<?php
					}
					
					$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
					$result_cajero = mysqli_query($conection,$sql_cajero);
					while ($row_cajero=mysqli_fetch_assoc($result_cajero))
		 			{
					?>
					<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
					<?php
					}

					$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
					$result_items = mysqli_query($conection,$sql_items);
					while ($row_i=mysqli_fetch_assoc($result_items))
		 			{	
		 				
		 				
		 				if($first_row)
		 				{?>

		 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
		 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
		 					
		 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
		 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
		 					</tr>
		 				<?php
		 				$first_row = False;
		 				}

		 				else
		 				{?>	
		 				<tr>
		 					<td></td>
		 					<td></td>
		 					<td></td>
		 					<td></td>
		 					<td></td>
		 					<td><?php echo $row_i['Nombre_producto'];?></td>
		 					<td><?php echo $row_i['Cantidad'];?></td>
		 					<td><?php echo "$ ".$row_i['Precio'];?></td>
		 					<td><?php echo "$ ".$row_i['Total'];?></td>
		 				</tr>
		 				<?php
		 				}
		 			}


					?>
				</tr>
				<?php 
				$first_row = True;
				?>
		 				<tr>
		 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
		 					<th><?php echo "$ ".$row['Total'];?></th>
		 				</tr>
		 				<?php 
				}
				?>
				<tr>
					<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
					<?php
					$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA >= '$mes_o' AND FECHA <= '$mes_f'";
		 			$result = mysqli_query($conection,$sql);
		 			while ($row=mysqli_fetch_assoc($result))
		 			{ ?>
					<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
					<?php }?>
				</tr>
			</table>




		<?php
	 		break;

	 	case 3: // Ventas de la semana

	 		$dia_sem = $_POST['sem_ventas'];
	 		//año mes dia
	 		$semana = explode("-", $dia_sem);
	 		$semana = $semana[2]."-".$semana[1]."-".$semana[0];
	 		$semana = week_from_monday($semana);
 
	 		?>
	 		<table style="border:solid 2px; ">

				<?php
				 	$sql="SELECT * FROM REST_INFO;";
		 			$result = mysqli_query($conection,$sql);
		 			while ($row=mysqli_fetch_assoc($result))
		 			{ ?>
					<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
					<tr><td colspan="8" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
					<tr><td colspan="8" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
					<tr><td colspan="8" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
					<tr><td colspan="8" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
				<?php }?>


				<tr >
					<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas de la semana del 
						<?php echo explode("-", $semana[0])[2]." al ".explode("-", $semana[6])[2]." de ".$meses[intval(explode("-", $semana[0])[1])]." del ".explode("-", $semana[0])[0];?> </th>
				</tr>
				<tr>
					<th rowspan="2" class="first_row">Total de ventas:</th>
					<th class="first_row">Lunes</th>
					<th class="first_row">Martes</th>
					<th class="first_row">Miércoles</th>
					<th class="first_row">Jueves</th>
					<th class="first_row">Viernes</th>
					<th class="first_row">Sabado</th>
					<th class="first_row">Domingo</th>
				</tr>
				<tr>
					<?php 
					foreach ($semana as $key => $value) 
					{
						$sql = "SELECT SUM(TOTAL) AS TOTAL FROM PEDIDO_MESA WHERE FECHA = '$value';";
						$result = mysqli_query($conection,$sql);
		 				while ($row=mysqli_fetch_assoc($result))
		 				{ 
		 					if($row['TOTAL']>0){echo '<td>$ '.$row['TOTAL'].'</td>';}
		 					else{echo '<td>$ 0</td>';}
		 				}
					}
					?>
					
				</tr>
			</table>
				<?php

	 		break;
	 		?><div id='myDiv'><?php
	 	case 8://Corte de turno para los cajeros
	 	
	 	$fname = "Reporte de ventas del turno del día ".$fecha_hoy.".xls";
	 	header("Content-Disposition: attachment; filename=$fname");
	 		
	 	?>
	 	
	 	<table style="border:solid 2px; ">

		<?php
		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Orden</th>
			<th class="first_row">Mesa</th>
			<th class="first_row">Hora</th>
			<th class="first_row">Cajero</th>
			<th class="first_row">Mesero</th>
			<th class="first_row">Nombre</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Precio</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$first_row = True;
		 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy' AND ID_USUARIO_CAJERO = $ID_USER;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>		
		<tr>
			<td class="first_row"><?php echo $row['Orden'];?></td>
			<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
			<td class="first_row"><?php echo $row['Hora'];?></td>

			<?php

			$id_pedido = $row['ID_Pedido'];
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}
			
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
			?>
			<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}

			$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
			$result_items = mysqli_query($conection,$sql_items);
			while ($row_i=mysqli_fetch_assoc($result_items))
 			{	
 				
 				
 				if($first_row)
 				{?>

 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
 					
 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
 					</tr>
 				<?php
 				$first_row = False;
 				}

 				else
 				{?>	
 				<tr>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td><?php echo $row_i['Nombre_producto'];?></td>
 					<td><?php echo $row_i['Cantidad'];?></td>
 					<td><?php echo "$ ".$row_i['Precio'];?></td>
 					<td><?php echo "$ ".$row_i['Total'];?></td>
 				</tr>
 				<?php
 				}
 			}


			?>
		</tr>
		<?php 
		$first_row = True;
		?>
 				<tr>
 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
 					<th><?php echo "$ ".$row['Total'];?></th>
 				</tr>
 				<?php 
		}
		?>
		<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy' AND ID_USUARIO_CAJERO = $ID_USER;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
	</table>


	 	<?php	

	 		break;
	 	case 5://Ventas por cajero

	 		$fname = "Reporte de ventas del turno del día ".$fecha_hoy.".xls";
	 		header("Content-Disposition: attachment; filename=$fname");
	 		
	 	?>
	 	
	 	<table style="border:solid 2px; ">

		<?php

		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Orden</th>
			<th class="first_row">Mesa</th>
			<th class="first_row">Hora</th>
			<th class="first_row">Cajero</th>
			<th class="first_row">Mesero</th>
			<th class="first_row">Nombre</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Precio</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$first_row = True;
		 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy' ORDER BY ID_USUARIO_CAJERO;";
		 	$cajeros = array();
		 	$cajeros_nombres = array();
			
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>		
		<tr>
			<td class="first_row"><?php echo $row['Orden'];?></td>
			<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
			<td class="first_row"><?php echo $row['Hora'];?></td>

			<?php

			$id_pedido = $row['ID_Pedido'];
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
 				if (!in_array($row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'], $cajeros_nombres)){array_push($cajeros_nombres, $row_cajero['NOMBRE']." ".$row_cajero['APELLIDO_P']);}
			?>
			<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}
			
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{ 
			?>
			<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}

			$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
			$result_items = mysqli_query($conection,$sql_items);
			while ($row_i=mysqli_fetch_assoc($result_items))
 			{	
 				
 				 
 				if($first_row)
 				{
 					?>

 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
 					
 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
 					</tr>
 				<?php
 				$first_row = False;
 				}

 				else
 				{?>	
 				<tr>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td><?php echo $row_i['Nombre_producto'];?></td>
 					<td><?php echo $row_i['Cantidad'];?></td>
 					<td><?php echo "$ ".$row_i['Precio'];?></td>
 					<td><?php echo "$ ".$row_i['Total'];?></td>
 				</tr>
 				<?php
 				}
 			}


			?>
		</tr>
		<?php 
		$first_row = True;

			
			if (!in_array($row['ID_Usuario_Cajero'], $cajeros))
				{array_push($cajeros, $row['ID_Usuario_Cajero']);
				}
		?>
 				<tr>
 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
 					<th><?php echo "$ ".$row['Total'];?></th>
 				</tr>
 				<?php 
		}
		
		$i = 0;
		foreach ($cajeros as $key => $value) 
			{?>
			<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas de <?php echo $cajeros_nombres[$i];?></th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy' AND ID_USUARIO_CAJERO = $value;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
		<?php
		$i++;
		}
		?>
		<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
	</table>

	<?php 
		break;

		case 6://Ventas por Mesero

	 		$fname = "Reporte de ventas del turno del día ".$fecha_hoy.".xls";
	 		header("Content-Disposition: attachment; filename=$fname");
	 		
	 	?>
	 	
	 	<table style="border:solid 2px; ">

		<?php

		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="9" class="first_row" style="text-align: right; font-size: 25px;">Reporte de ventas del día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Orden</th>
			<th class="first_row">Mesa</th>
			<th class="first_row">Hora</th>
			<th class="first_row">Cajero</th>
			<th class="first_row">Mesero</th>
			<th class="first_row">Nombre</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Precio</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$first_row = True;
		 	$sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy' ORDER BY ID_USUARIO_CAJERO;";
		 	$cajeros = array();
		 	$cajeros_nombres = array();
			
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>		
		<tr>
			<td class="first_row"><?php echo $row['Orden'];?></td>
			<td class="first_row"><?php echo $row['ID_Mesa'];?></td>
			<td class="first_row"><?php echo $row['Hora'];?></td>

			<?php

			$id_pedido = $row['ID_Pedido'];
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{
 				
			?>
			<td class="tdNombre" style="border-top:solid 2px;"> <?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}
			
			$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
			$result_cajero = mysqli_query($conection,$sql_cajero);
			while ($row_cajero=mysqli_fetch_assoc($result_cajero))
 			{ 
 				if (!in_array($row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'], $cajeros_nombres)){array_push($cajeros_nombres, $row_cajero['NOMBRE']." ".$row_cajero['APELLIDO_P']);}
			?>
			<td class="tdNombre" style="border-top:solid 2px;"><?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?></td>
			<?php
			}

			$sql_items = "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
			$result_items = mysqli_query($conection,$sql_items);
			while ($row_i=mysqli_fetch_assoc($result_items))
 			{	
 				
 				 
 				if($first_row)
 				{
 					?>

 					<td class="first_row"><?php echo $row_i['Nombre_producto'];?></td>
 					<td class="first_row"><?php echo $row_i['Cantidad'];?></td>
 					
 					<td class="first_row"><?php echo "$ ".$row_i['Precio'];?></td>
 					<td class="first_row"><?php echo "$ ".$row_i['Total'];?></td>
 					</tr>
 				<?php
 				$first_row = False;
 				}

 				else
 				{?>	
 				<tr>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td></td>
 					<td><?php echo $row_i['Nombre_producto'];?></td>
 					<td><?php echo $row_i['Cantidad'];?></td>
 					<td><?php echo "$ ".$row_i['Precio'];?></td>
 					<td><?php echo "$ ".$row_i['Total'];?></td>
 				</tr>
 				<?php
 				}
 			}


			?>
		</tr>
		<?php 
		$first_row = True;

			
			if (!in_array($row['ID_Usuario_Mesero'], $cajeros))
				{array_push($cajeros, $row['ID_Usuario_Mesero']);
				}
		?>
 				<tr>
 					<th colspan="7" style="text-align: right; ">Total de la mesa</th>
 					<th><?php echo "$ ".$row['Total'];?></th>
 				</tr>
 				<?php 
		}
		
		$i = 0;
		foreach ($cajeros as $key => $value) 
			{?>
			<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas de <?php echo $cajeros_nombres[$i];?></th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy' AND ID_USUARIO_MESERO = $value;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
		<?php
		$i++;
		}
		?>
		<tr>
			<th style="text-align: right; font-size: 15px" colspan="7" class="first_row">Total de ventas</th>
			<?php
			$sql="SELECT SUM(TOTAL) AS TOTAL from pedido_mesa where estado_orden ='Terminada' AND FECHA = '$fecha_hoy';";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<th colspan="2" style="font-size: 15px" class="first_row"><?php echo "$ ".$row['TOTAL'];?></th>
			<?php }?>
		</tr>
	</table>

	<?php 
		break;


		case 4://Productos vendidos

	 		$fname = "Productos vendidos el día ".$fecha_hoy.".xls";
	 		header("Content-Disposition: attachment; filename=$fname");
	 		
	 	?>
	 	
	 	<table style="border:solid 2px; ">

		<?php

		 	$sql="SELECT * FROM REST_INFO;";
 			$result = mysqli_query($conection,$sql);
 			while ($row=mysqli_fetch_assoc($result))
 			{ ?>
			<tr class="no_border"><th colspan="9" style="height:30px; font-size: 35px;"><?php echo $row['Nombre'];?></th></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Calle']." ".$row['Numero'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo $row['Ciudad'].", ".$row['Estado'].", ".$row['Pais'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Teléfono: ".$row['Telefono'];?></td></tr>
			<tr><td colspan="9" style="font-size: 15px;"><?php echo "Correo: ".$row['Email'];?></td></tr>
		<?php }?>


		<tr >
			<th colspan="3" class="first_row" style="text-align: right; font-size: 25px;">Productos vendidos el día <?php echo $fecha_hoy?> </th>
		</tr>
		<tr>
			<th class="first_row">Nombre del producto</th>
			<th class="first_row">Cantidad</th>
			<th class="first_row">Total</th>
		</tr>
		 <?php
		 	$productos = array();
		 	$sql = "SELECT NOMBRE_PRODUCTO FROM PEDIDO WHERE FECHA = '$fecha_hoy' GROUP BY NOMBRE_PRODUCTO;";
		 	$result = mysqli_query($conection,$sql);
		 	while ($row=mysqli_fetch_assoc($result))
 			{
 				array_push($productos, $row['NOMBRE_PRODUCTO']);
 			}

 			foreach ($productos as $key => $value) 
 			{?>
 				<tr>
 					<?php
 				$sql="SELECT NOMBRE_PRODUCTO AS NOMBRE_PRODUCTO, SUM(CANTIDAD) AS CANTIDAD, SUM(TOTAL) AS TOTAL FROM PEDIDO WHERE NOMBRE_PRODUCTO = '$value' AND FECHA = '$fecha_hoy';";
 				$result = mysqli_query($conection,$sql);
 				$row=mysqli_fetch_assoc($result);?>
 				<td class="first_row"><?php echo $row['NOMBRE_PRODUCTO'];?></td>
 				<td class="first_row"><?php echo $row['CANTIDAD'];?></td>
 				<td class="first_row"><?php echo '$ '.$row['TOTAL'];?></td>
 				</tr>
 				<?php 	
 			}?>

		 	
		
	</table>

	<?php 
		break;

	 	default:
	 		# code...
	 		break;
	 }
 ?>
				

	

 
</body>

</html>

<?php

?>