<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();

//Agregar comentario
if(isset($_POST['add_comentario']))
 {
  	$comentario = $_POST['comentario'];
  	$atendio = $_POST['atendio'];
  	$servicio = $_POST['servicio'];
  	$comida = $_POST['comida'];



  	$sql = "INSERT INTO RESEÑA (COMIDA, SERVICIO, COMENTARIO, ID_USUARIO) VALUES ($comida, $servicio, '$comentario', $atendio); "; 
	
 	$result = mysqli_query($conection,$sql);

 }

//Eliminar comentario
if(isset($_POST['eliminar_com']))
 {
  	$comentario = $_POST['ID_Delete'];

  	$sql = "DELETE FROM RESEÑA WHERE ID_RESEÑA = $comentario"; 
 	$result = mysqli_query($conection,$sql);

 }


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	
	<style type="text/css">
		.cuadrado {
  width:25vh;
  max-width:100%;
  height:25vh;
  max-height:100%;
  margin-left: auto;
  margin-right: auto;
  
  background:#7eaebf;

  
}	
	.myTable td,th
  	{
  		border: solid 1px;
  		 border-top-right-radius: 15px;
    border-top-left-radius: 15px;

  	}
  	.myTable th,td
  	{
  		border: solid 1px;
  	}
  	.myth
  	{
  		border: 0px;
  	}

	</style>
	<script type="text/javascript">
		del_com = function(ID)
        {
            $('#Delete_ID').val(ID);
            $('#id_del').html('¿Desea Eliminar el comentario '+ID+'?');
           
        };


	</script>
</head>
<body>
	<?php include("menu_top.php") ?>
	<?php if($row_user['Tipo_Usuario']!= 'NULL'){include("menu_side.php");} ?>

	<div class="col py-3" style="background-color: #dee3e1;">
		
		<!-- Empieza card comentarios -->
		<div class="container">
			<div class="card text-center" style="background-color: white;">

	
			  <div class="card-header ">
			   <h5 class="card-title text-center">Comentarios</h5>
			  </div>


			  <div class="card-body">
			  	<?php 
        			$sql = "SELECT RESEÑA.ID_RESEÑA AS ID_RE, ((RESEÑA.COMIDA + RESEÑA.SERVICIO)/2) AS PROM, COMIDA, SERVICIO, COMENTARIO, NOMBRE, APELLIDO_P, FECHA FROM RESEÑA, USUARIO WHERE RESEÑA.ID_USUARIO = USUARIO.ID_USUARIO;";
        			$result=mysqli_query($conection, $sql);

						while ($row=mysqli_fetch_assoc($result)){ 
						?>

			  	<!-- Card con comentario -->
			  	<div class="card mb-3 text-center "  style="background-color: #9cd3e6; height:  ;">

			  		<div class="card-body text-center">
			  			<table class="myTable" style="width: 100%; background: white;">
			  				<tr>
			  					<th><h5 class="card-title text-center" >Calif. General</h5></th>
			  					<th><h5 class="card-title text-center" >Calif. Comida</h5></th>
			  					<th><h5 class="card-title text-center" >Calif. Servicio</h5></th>
			  					<th><h5 class="card-title text-center" >Mesero</h5></th>
			  					<th width="30%"><h5 class="card-title text-center" >Comentario</h5></th>
			  					<th><h5 class="card-title text-center" >Fecha</h5></th>
			  					<?php if($row_user['Tipo_Usuario'] == 'Gerente'){?>
			  					<th rowspan="2" class="myth"><span type="button" class="btn fas fa-trash-alt fa-3x " data-toggle="modal" data-target="#EliminarCom" onclick="del_com(<?php echo $row['ID_RE']; ?>)"></span><br>Eliminar</th>
			  				<?php }?>
			  				</tr>
			  				<tr>	
			  					<td><h5 class="card-title text-center" ><?php echo $row['PROM']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['COMIDA']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['SERVICIO']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['NOMBRE']." ".$row['APELLIDO_P']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['COMENTARIO']; ?></h5></td>
			  					<td><h5 class="card-title text-center" ><?php echo $row['FECHA']; ?></h5></td>
			  					
			  				</tr>
			  			</table>
			  			
			  		</div>	
				</div>
				<!-- Termina Card con comentario -->
			  	<?php }?>
			  </div>
			<?php if($row_user['Tipo_Usuario'] ==  'NULL'){?>
			  <div class="card-footer text-muted">
			    <div class="container-fluid d-flex">
                       <button type="button" class="btn btn-custom m-auto" data-toggle="modal" data-target="#add" onclick="modal()">Agregar Comentario</button> 
                    </div>
			  </div>
			<?php }?>
			</div>

		</div>
		<!-- termina card -->



		<!-- Modal Agregar comentario  -->
		
            <div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            	<form action="comentarios.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>" method="post">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                    <h5 class="modal-title">Agregar Comentario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    

                    <div class="modal-body">
                    	
                        <div class="form-row">

						    <div class="form-group col-md-3" >
						    </div>

						    <div class="form-group col-md-3 text-center">
						      <label for="inputPassword4">Comida</label>
						       <input type="number" min="1" max="10" step=".1" paso class="form-control" name="comida"  placeholder="Comida" required="" style="text-align: center;">
						    </div>
						    <div class="form-group col-md-3 text-center">
						      <label for="inputPassword4">Servicio</label>
						       <input type="number" min="1" max="10" step=".1" class="form-control" name="servicio" placeholder="Servicio" required="" style="text-align: center;">
						    </div>    
						</div>
						<center><label style="color: gray;">Califique del 1 al 10, siendo el 10 como excelente.</label></center><br>

						<div class="form-group text-center">
                    		<label>Comentarios</label>
                    		<div class="col-sm">
                        		<textarea class="form-control" id="text_area" name="comentario" placeholder="Ingrese sus comentarios, evite el uso de lenguaje inapropiado o más de 200 caracteres." rows="4" style="text-align: justify;"></textarea>	
                    		</div>
                    		
                		</div>

                		<div class="form-row">
                			<div class="form-group col-md-3">
                			</div>
	                		<div class="form-group col-md-6 text-center">
	                    		<label>¿Quién lo atendió?</label>
	                    		<div class="col-sm">
	                        		<select multiple class="form-control" name="atendio">
	                        			<?php 
	                        			$sql = "SELECT * FROM USUARIO WHERE TIPO_USUARIO != 'Gerente' ORDER BY ID_USUARIO DESC;";
	                        			$result=mysqli_query($conection, $sql);
	  
		   								while ($row=mysqli_fetch_assoc($result)){ 
		     							?>

								      <option value="<?php echo $row['ID_Usuario'];?>"><?php echo $row['Nombre']." ".$row['Apellido_P'];?></option>
								      	<?php }?>

								    </select>
	                    		</div>
	                		</div>
                		</div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="add_comentario" class="btn btn-custom">Agregar</button>
                    </div>

                    
                </div>
                </div>
            </div>
        </form>
            <!-- Modal Agregar comentario END-->

            <!-- Modal Eliminar comentario -->
            <form action="comentarios.php?user=<?php echo $id;?>" method="post">
    <div class="modal fade" id="EliminarCom" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><div id="id_del"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                	<input type="hidden" id="Delete_ID" name="ID_Delete">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_com" class="btn btn-danger">Si</button>
                </div>
                </div>
            
        </div>
    </div>
</form>
    <!-- Modal Delete Mesa comentario -->

	</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
</html>