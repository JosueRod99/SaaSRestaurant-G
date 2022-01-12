<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();

//Agregar comentario
if(isset($_POST['agregar_act']))
 {
  	$nombre = $_POST['nombre'];

  	$sql = "INSERT INTO ACTIVIDAD (NOMBRE) VALUES ('$nombre');";
	$result = mysqli_query($conection,$sql);
	
 }

 //Editar actividad
if(isset($_POST['editar_act']))
 {
 	$actividad = $_POST['ID_edit'];
 	$nombre = $_POST['nombre'];

 	$sql = "UPDATE ACTIVIDAD SET NOMBRE = '$nombre' WHERE ID_ACTIVIDAD = $actividad";
 	$result = mysqli_query($conection,$sql);
 }


//Eliminar actividad
if(isset($_POST['eliminar_act']))
 {	
 	
  	$actividad = $_POST['ID_Delete'];
  	$sql = "DELETE FROM ACTIVIDAD WHERE ID_ACTIVIDAD = $actividad"; 
 	$result = mysqli_query($conection,$sql);

 }

//Desasignar actividad
if(isset($_POST['Desasignar']))
 {
 	$ID_Act = $_POST['id_actividad'];
  	$sql = "UPDATE ACTIVIDAD SET ID_USUARIO = 0, ESTADO = 'Sin asignar' WHERE ID_ACTIVIDAD = $ID_Act";
	$result = mysqli_query($conection,$sql);
 }

//Asignar actividad
if(isset($_POST['Asignar']))
 {	
 	$ID_User = $_POST['usuario'];
 	$ID_Act = $_POST['id_actividad'];

  	$sql = "UPDATE ACTIVIDAD SET ID_USUARIO = $ID_User, ESTADO = 'Asignado' WHERE ID_ACTIVIDAD = $ID_Act";
	$result = mysqli_query($conection,$sql);
 }

//Terminar actividad
if(isset($_POST['Terminar']))
{
	$ID_USER = $_POST['usuario_asi'];
	$ID_Act = $_POST['id_actividad'];
	$nombre = $_POST['nombre'];


	$sql = "UPDATE ACTIVIDAD SET ID_USUARIO = 0, ESTADO = 'Sin asignar' WHERE ID_ACTIVIDAD = $ID_Act";
	$result = mysqli_query($conection,$sql);

	$sql = "INSERT INTO ACTIVIDAD_LOG (NOMBRE, ID_USUARIO) VALUES ('$nombre', $ID_USER);";
	
	$result = mysqli_query($conection,$sql);
}


?>
<!DOCTYPE html>
<html>
<head>
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
	.table th,td
	{
		width:25%;
	}
	</style>

	<script type="text/javascript">
		del_act = function(ID)
        {
            $('#Delete_ID').val(ID);
            $('#id_del').html('¿Desea eliminar la actividad '+ID+'?');
        };
        edit_act = function(ID, NAME)
        {
        	
        	$('#Edit_ID').val(ID);
        	$('#Nombre_act').val(NAME);
        }
	</script>
</head>
<body>
	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>

	<div class="col py-3" style="background-color: #dee3e1;">
		
		<!-- Empieza card comentarios -->
		<div class="container">
			<div class="card text-center" style="background-color: white;">

	
			  <div class="card-header ">
			   <h5 class="card-title text-center">Actividades</h5>
			  </div>


			  <div class="card-body">
			  	<?php 
			  		if($row_user['Tipo_Usuario'] ==  'Gerente'){
        				$sql = "SELECT * FROM ACTIVIDAD ORDER BY ESTADO DESC;";}
        			else{
        				$iduser = $row_user['ID_Usuario'];
        				$sql = "SELECT * FROM ACTIVIDAD WHERE ID_USUARIO = $iduser;";
        			}
        			$result=mysqli_query($conection, $sql);
						while ($row=mysqli_fetch_assoc($result)){ 
						?>

			  	<!-- Card con comentario -->
			  	<div class="card text-white bg-info mb-3 text-center">

			  		<div class="card-body text-center">
			  			<table style="width: 100%; border: 1px;">
			  				<tr>
			  					<th><h5 class="card-title text-center" >Nombre</h5></th>
			  					<th><h5 class="card-title text-center" >
			  						<?php 
			  								if($row['ESTADO'] == "Sin asignar"){echo "Asignar a";}
			  								else {echo "Asignada a";}
			  						?>
			  							
			  						</h5>
			  					</th>
			  					<th><h5 class="card-title text-center" >Estado</h5></th>
			  					<th rowspan="2">
			  						
			  						<form action="actividades.php?user=<?php echo $id;?>" method="post">
			  							<input type="hidden" value="<?php echo $row['ID_ACTIVIDAD'];?>" name="id_actividad">
			  						<?php 
			  								if($row['ESTADO'] == "Sin asignar")
			  								{?>
									
									<?php if($row_user['TIPO_USUARIO'] ==  'Gerente'){?>
					  						<button type="submit" name="Asignar">
		  											<i class="btn fas fa-play fa-2x"></i>
											</button>
											<font size=4>Asignar

												
			  						<span type="button" class="btn fas fa-edit fa-2x" data-toggle="modal" data-target="#Editar" onclick="edit_act(<?php echo $row['ID_ACTIVIDAD']; ?>,'<?php echo $row['NOMBRE']; ?>')">	<br><font size=4>Editar</font>
			  						</span>
			  						<span type="button" class="btn fas fa-trash-alt fa-2x " data-toggle="modal" data-target="#EliminarAct" onclick="del_act(<?php echo $row['ID_ACTIVIDAD']; ?>)"><br><font size=4>Eliminar</font>
			  						</span>
			  								<?php }}
			  								else {?>
			  									<?php if($row_user['TIPO_USUARIO'] ==  'Gerente'){?>
			  									<button type="submit" name="Desasignar">
  													<i class="btn fas fa-reply-all fa-2x"></i>
												</button>
												<br><font size=4>Desasignar</font>
												
												<?php }
												else{?>

												<button type="submit" name="Terminar">
  													<i class="btn far fa-check-square fa-2x"></i>
												</button>
												<br><font size=4>Terminar</font>
			  								<?php }}
			  						?>
			  						
			  						
			  						
			  					</th>
			  				</tr>
			  				<tr>	
			  					<td>
			  						<input type="hidden" name="nombre" value="<?php echo $row['NOMBRE']; ?>">
			  						<h5 class="card-title text-center" ><?php echo $row['NOMBRE']; ?></h5>
			  					</td>

			  					<td>
			  										<?php 
			  							
			  							
			  							if($row['ESTADO'] == "Asignado")
			  							{
			  								$id_act = $row['ID_ACTIVIDAD']; 
			  									$sql_asignado="SELECT USUARIO.ID_USUARIO, USUARIO.NOMBRE, USUARIO.APELLIDO_P, ID_ACTIVIDAD FROM USUARIO, ACTIVIDAD WHERE ACTIVIDAD.ID_USUARIO = USUARIO.ID_USUARIO AND ID_ACTIVIDAD = $id_act;";
			  									$result_asignado = mysqli_query($conection, $sql_asignado);
			  									$row_asig=mysqli_fetch_assoc($result_asignado);
			  									echo "<h5 class='card-title text-center' >".$row_asig['NOMBRE']." ".$row_asig['APELLIDO_P']."</h5>";
			  									?>
			  									<input type="hidden" name="usuario_asi" value="<?php echo $row_asig['ID_USUARIO']; ?>">
			  									<?php

			  							}
			  							else
			  							{
			  								echo "<select multiple class='form-control text-center' name='usuario' style='width:80%'>";
			  								$sql_usuarios = "SELECT ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P FROM USUARIO WHERE TIPO_USUARIO != 'Gerente' AND ID_USUARIO != 0;";
        									$result_usuarios = mysqli_query($conection, $sql_usuarios);
			  								while ($row_=mysqli_fetch_assoc($result_usuarios))
			  										{?>

			  										<option value="<?php echo $row_['ID_USUARIO'];?>">
								      					<?php echo $row_['NOMBRE']." ".$row_['APELLIDO_P'];?>
								      				</option>
								    <?php
			  										}

			  								echo "</select>";
			  							}
			  						?>

			  					</td>

			  					<td><h5 class="card-title text-center" ><?php echo $row['Estado']; ?></h5></td>
			  					</form>
			  				</tr>
			  			</table>
			  		</div>	
				</div>
				<!-- Termina Card con comentario -->
			  	<?php }?>
			  </div>
			
			<?php if($row_user['TIPO_USUARIO'] ==  'Gerente'){?>
			  <div class="card-footer text-muted">
			    <div class="container-fluid d-flex">
                       <button type="button" class="btn btn-custom m-auto" data-toggle="modal" data-target="#Agregar">Agregar Actividad</button> 
                </div>
			  </div>
			<?php }?>

			</div>

		
		<!-- termina card -->
		<br><br>
		<!-- 	Actividades de hoy -->
			
			<div class="containter" style="background-color:  #c0e1ed; border-radius: 10px ">
				<br>
				<div class="row justify-content-center text-center">
					<div class="col-6" style="background-color: white; border-radius: 10px">
						<font size=5>Actividades completadas el día de hoy</font>
					</div>
				</div>
				<br>
				<div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 200px; overflow-y: scroll;">
				<div class="row justify-content-center text-center" >
				    <div class="col-md-4" style="background-color: white ;border: solid 1px white; border-top-left-radius: 10px">
				      <font size=4>Actividad</font>  
				    </div>
				    <div class="col-md-4" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Usuario</font>  
				    </div>
				    <div class="col-md-4" style="background-color: white ;border: solid 1px white;">
				      <font size=4>Fecha</font>  
				    </div>
				</div>
				

				
					<?php 
					$fc_hoy = $fecha_hoy.' 00:00:00';
					$fc_man = $fecha_hoy. ' 23:59:59';
					$sql = "SELECT * FROM ACTIVIDAD_LOG WHERE FECHA > '$fc_hoy' AND FECHA < '$fc_man' ORDER BY FECHA;";

 						  $result = mysqli_query($conection,$sql);
 						 while ($row=mysqli_fetch_assoc($result))
 					{ $id_u_act = $row['ID_ACTIVIDAD_LOG'];
 						
 						?>
					<div class="row justify-content-center text-center" >
				    <div class="col-md-4" style=";border-bottom: white solid 1px; ">
				    	<?php echo $row['NOMBRE'];?>
				    </div>
				    
				    <?php
				
					$sql_cajero = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM USUARIO, ACTIVIDAD_LOG WHERE ACTIVIDAD_LOG.ID_ACTIVIDAD_LOG = $id_u_act AND ACTIVIDAD_LOG.ID_USUARIO = USUARIO.ID_USUARIO;";
					$result_cajero = mysqli_query($conection,$sql_cajero);
					while ($row_cajero=mysqli_fetch_assoc($result_cajero))
		 			{
					?>
					<div class="col-md-4" style=";border-bottom: white solid 1px; ">
				    	<?php echo $row_cajero['NOMBRE']." ". $row_cajero['APELLIDO_P'];?>
				    </div>
					
					<?php
					}
					?>

					<div class="col-md-4" style=";border-bottom: white solid 1px; ">
				    	<?php echo $row['FECHA'];?>
				    </div>

				    
				    

					</div>
				<?php }?>

				<br>

			</div>
		</div>
</div>


		<!-- Modal Agregar actividad -->
            <form action="actividades.php?user=<?php echo $id;?>" method="post">
            	
    		<div class="modal fade" id="Agregar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        	<div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                	<div class="form-row">

						    <div class="form-group col-md-1" >
						    </div>

						    <div class="form-group col-md-10 text-center">
						      <label>Nombre de la actividad</label>
						       <input type="text" tittle="Describe la actividad en menos de 150 caracteres." class="form-control" name="nombre"  placeholder="Ingrese el nombre de la actividad" required="" style="text-align: center;">
						    </div>
						       
						</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="agregar_act" class="btn btn-success">Agregar</button>
                </div>
                </div>
            
        	</div>
    		</div>
			</form>
            <!-- Modal agregar actividad -->


            <!-- Modal Editar actividad -->
            <form action="actividades.php?user=<?php echo $id;?>" method="post">
            	<input type="hidden" id="Edit_ID" name="ID_edit" style="border:0; width: 3%" > 
    		<div class="modal fade" id="Editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        	<div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Moficiar actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                	<div class="form-row">

						    <div class="form-group col-md-1" >
						    </div>

						    <div class="form-group col-md-10 text-center">
						      <label>Nombre de la actividad</label>
						       <input type="text" tittle="Describe la actividad en menos de 150 caracteres." class="form-control" name="nombre"  placeholder="Ingrese el nombre de la actividad" required="" style="text-align: center;" id="Nombre_act">
						    </div>
						       
						</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="editar_act" class="btn btn-success">Modificar</button>
                </div>
                </div>
            
        	</div>
    		</div>
			</form>
            <!-- Modal Editar actividad -->


            <!-- Modal Eliminar actividad -->
            <form action="actividades.php?user=<?php echo $id;?>" method="post">
    		<div class="modal fade" id="EliminarAct" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        	<div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header"> 
                    <h5 class="modal-title"><div id="id_del"></div></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                	<input type="hidden" id="Delete_ID" name="ID_Delete">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_act" class="btn btn-danger">Si</button>
                </div>
                </div>
            
        	</div>
    		</div>
			</form>
    <!-- Modal Delete actividad -->

	</div>

</body>
</html>
