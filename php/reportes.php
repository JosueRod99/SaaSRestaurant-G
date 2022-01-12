<?php 
require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();
 
 date_default_timezone_set('America/Mazatlan');
 $hoy = getdate();
 $fecha_hoy = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];


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
	<script type="text/javascript">
		
		
		
        function Reset(k)
        {	
        	for (var i = 0; i < 9; i++) 
        	{
        		var input = document.getElementById("input_"+i);
				if(input)
					{
						if(i == k)
						{

								input.disabled=false;
						}
						else
						{
							input.disabled=true;
						}
					}
			}
        }



	</script>
</head>
<body>

	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>

	<div class="container">
		<div class="col py-3" style="background-color: #dee3e1;">
			
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Reportes</font>
					</div>
				</div>
			<br>

			<!-- Nuevos reportes -->
			
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Creador de reporte</font>
					</div>
				</div>
				<br>
				<div class="row justify-content-center text-center" >
				    <div class="col-md-11" style="background-color: white ;border: solid 1px white; border-top-right-radius: 10px; border-top-left-radius: 10px">
				      <font size=4>Tipo de reporte</font>  
				    </div>
				</div>
				<form action="generador_reporte.php" method="POST" >
					
				<div class="row justify-content-center text-center" >
				    <div class="col-md-9" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; border-bottom-left-radius: 10px;">
				      <div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 200px; overflow-y: scroll;">
						<?php if($row_user['Tipo_Usuario'] ==  'Gerente'){ ?>
				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="0" onclick="Reset(0)" required="">&nbsp<font size=4>Ventas del día</font><br>
				      			</div>
				      		</div>
				      	</div>

				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="1"  onclick="Reset(1)" required="">&nbsp<font size=4>Ventas de algún día</font><br> 
				      			</div>
				      			<div class="col-md-6">
				      				<input type="date" disabled="" id="input_1" name="dia_ventas" required=""> 
				      			</div>
				      		</div>
				      	</div>

				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="2" onclick="Reset(2)" id="radio_2" required="">&nbsp<font size=4>Ventas del mes</font><br> 
				      			</div>
				      			<div class="col-md-6">
				      				<input type="month" disabled="" id="input_2" name="mes_ventas" required=""> 
				      			</div>
				      		</div>
				      	</div>

				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="3" onclick="Reset(3)" id="radio_3" required="">&nbsp<font size=4>Ventas de alguna semana</font><br> 
				      			</div>
				      			<div class="col-md-6">
				      				<input type="date"   disabled="" id="input_3" name="sem_ventas" required="" title="Selecciona algún día en la semana que quieres revisar."> 
				      			</div>
				      		</div>
				      	</div>
				      	
				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="4" onclick="Reset(4)" required="">&nbsp<font size=4>Productos vendidos</font><br>
				      			</div>
				      		</div>
				      	</div>

				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="5" onclick="Reset(5)" required="">&nbsp<font size=4>Ventas por cajero</font><br>  
				      			</div>
				      		</div>
				      	</div>

				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="6" onclick="Reset(6)" required="">&nbsp<font size=4>Ventas por mesero</font><br>
				      			</div>
				      		</div>
				      	</div>
				      	
				      	<?php } if($row_user['Tipo_Usuario'] ==  'Cajero') {?>
				      	<div class="container">
				      		<div class="row">
				      			<div class="col-md-6">
				      				<input type="radio" name="reporte" value="7" onclick="Reset(7)" required="">&nbsp<font size=4>Corte del turno</font><br>
				      			</div>
				      		</div>
				      	</div>
				      	<?php }?>

				      </div>
				    </div>
					<div class="col-md-2" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; border-bottom-right-radius: 10px;">
					    <div class="containter"  style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
					    <input type="hidden" name="id_user" value="<?php echo $id;?>">
					      <button type="submit" class="btn btn-custom">Generar</button>

					      <button type="button" onclick="reset()" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
					    </div>
					</div>
				</div>
				<br>

			</div>
			

			<br>

			<!-- 	Recibos de las Mesas -->

			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-3" style="background-color: white; border-radius: 10px">
						<font size=5>Recibos de las cuentas cobradas el día de hoy</font>
					</div>
				</div>
				<br>
				<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 200px; overflow-y: scroll;">
				<div class="row justify-content-center text-center" >
				    <div class="col-md-1" style="background-color: white ;border: solid 1px white; border-top-left-radius: 10px">
				      <font size=4>Orden</font>  
				    </div>
				    <div class="col-md-1" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Mesa</font>  
				    </div>
				    <div class="col-md-2" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Hora</font>  
				    </div>
				    <div class="col-md-2" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Cajero</font>  
				    </div>
				    <div class="col-md-2" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Mesero</font>  
				    </div>
				    <div class="col-md-2" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Total</font>  
				    </div>
				    <div class="col-md-1" style="background-color: white ;border: solid 1px white; border-top-right-radius: 10px;">
				      <font size=4>Recibo</font>  
				    </div>
				</div>
				

				
					<?php $sql="SELECT * FROM PEDIDO_MESA WHERE ESTADO_ORDEN = 'Terminada' AND FECHA = '$fecha_hoy';";
 						  $result = mysqli_query($conection,$sql);
 						 while ($row=mysqli_fetch_assoc($result))
 					{ $id_pedido = $row['ID_Pedido'];
 						if($row_user['Tipo_Usuario'] ==  'Gerente' | ($row_user['Tipo_Usuario'] ==  'Cajero' AND $row_user['ID_Usuario'] ==  $row['ID_Usuario_Cajero'] )){
 						?>
					<div class="row justify-content-center text-center" >
				    <div class="col-md-1" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo $row['Orden'];?>
				    </div>
				    <div class="col-md-1" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo $row['ID_Mesa'];?>
				    </div>
				    <div class="col-md-2" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo $row['Hora'];?>
				    </div>


				    <?php

					
					$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
					$result_cajero = mysqli_query($conection,$sql_cajero);
					while ($row_cajero=mysqli_fetch_assoc($result_cajero))
		 			{
					?>
					<div class="col-md-2" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?>
				    </div>
					
					<?php
					}
					
					$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
					$result_cajero = mysqli_query($conection,$sql_cajero);
					while ($row_cajero=mysqli_fetch_assoc($result_cajero))
		 			{
					?>
					<div class="col-md-2" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?>
				    </div>
					
					<?php
					}?>
				    
				    <div class="col-md-2" style="background-color: #dee3e1 ;border: solid 1px #dee3e1; ">
				    	<?php echo "$ ".$row['Total'];?>
				    </div>
					<div class="col-md-1" style="background-color: #dee3e1 ;border: solid 1px #dee3e1;">
					    <div class="containter"  style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
					    	<input type="hidden" value="<?php echo $row['ID_Pedido'];?>" name="id">
					      <span class="btn far fa-eye" onclick="window.open('generar_recibo.php?id=<?php echo $row['ID_Pedido'];?>');"></span>
					    </div>
					</div>
				</div>
				<?php }}?>

				<br>

			</div>
		</div>



		<!-- 	Cuadros de estadísticas -->
			<br>
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>


				
				<div class="row justify-content-center text-center" >
				    <div class="col-md-3" style="background-color: white ;border: solid 1px white; border-top-left-radius: 10px">
				      <font size=4>Ventas de Hoy</font>  
				    </div>
				    <div class="col-md-3" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Ventas de la semana</font>  
				    </div>
				    <div class="col-md-3" style="background-color: white ;border: solid 1px white; border-top-right-radius: 10px;;">
				      <font size=4>Ventas del mes</font>  
				    </div>
				</div>

				<div class="row justify-content-center text-center" >
				    <div class="col-md-3" style="background-color: white ;border: solid 1px white; border-bottom-left-radius: 10px;"> 
				      <?php
				      $hoy = getdate();
					  $fecha_hoy = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
				      $sql="SELECT SUM(TOTAL) AS TOTAL FROM PEDIDO_MESA WHERE FECHA = '$fecha_hoy';";
				      $result = mysqli_query($conection,$sql);
						while ($row=mysqli_fetch_assoc($result))
		 				{
		 					echo '<font size=4>$ '.$row['TOTAL'].'</font>';
		 				}
		 				
				      ?>
				    </div>
				    <div class="col-md-3" style="background-color: white ;border: solid 1px white;">
				      
				      <?php
				      	$fec_sep = explode('-', $fecha_hoy);
				      	$semana = $fec_sep[2].'-'.$fec_sep[1].'-'.$fec_sep[0];
				      	$semana = week_from_monday($semana);
				      	
				      	$sql="SELECT SUM(TOTAL) AS TOTAL FROM PEDIDO_MESA WHERE FECHA >= '$semana[0]' and FECHA <= '$semana[6]';";
				      	$result = mysqli_query($conection,$sql);
						while ($row=mysqli_fetch_assoc($result))
		 				{
		 					echo '<font size=4>$ '.$row['TOTAL'].'</font>';
		 				}
		 				
				      ?>  
				    </div>

				    <div class="col-md-3" style="background-color: white ;border: solid 1px white; border-bottom-right-radius: 10px;">
				        <?php
				        $mes_o = $fec_sep[0].'-'.$fec_sep[1].'-1';

				        if($fec_sep[1]!=12)
				        {
				        	$mes_f = $fec_sep[0].'-'.(intval($fec_sep[1])+1).'-1';
				        }
				        else
				        {
				        	$mes_f = (intval($fec_sep[0])+1).'-1-1';
				        }
				        

				      	$sql="SELECT SUM(TOTAL) AS TOTAL FROM PEDIDO_MESA WHERE FECHA >= '$mes_o' and FECHA <= '$mes_f';";
				      	$result = mysqli_query($conection,$sql);
						while ($row=mysqli_fetch_assoc($result))
		 				{
		 					echo '<font size=4>$ '.$row['TOTAL'].'</font>';
		 				}
		 				
				      ?>  
				    </div>


				</div><br>
			</div>



		</div>
	</div>
</form>

</body>
</html>