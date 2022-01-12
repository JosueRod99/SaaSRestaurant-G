<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();




 if(isset($_POST['modificar_rest']))
 {

 	$id_re = $_POST['id_rest'];
 	$calle = $_POST['calle_rest'];
 	$num = $_POST['num_rest'];
 	$ciudad = $_POST['ciudad_rest'];
 	$estado = $_POST['estado_rest'];
 	$pais = $_POST['pais_rest'];
 	$tel = $_POST['tel_rest'];
 	$email = $_POST['email_rest'];
 	$nombre = $_POST['nombre_rest'];

 	$sql = "UPDATE REST_INFO SET CALLE='$calle', NUMERO = '$num', CIUDAD='$ciudad', ESTADO='$estado', PAIS='$pais', TELEFONO='$tel', EMAIL='$email', NOMBRE = '$nombre' WHERE ID_REST = $id_re";
 	$result = mysqli_query($conection,$sql);
 	echo $sql;
 	
 } 
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		edit_rest = function(ID,NAME, ST, NUM, CITY, STATE, COUNTRY, TEL, EMAIL)
        {	
        	$('#ID_REST').val(ID);
        	$('#NOMBRE_REST').val(NAME);
        	$('#CALLE_REST').val(ST);
        	$('#NUM_REST').val(NUM);
        	$('#CIUDAD_REST').val(CITY);
        	$('#ESTADO_REST').val(STATE);
        	$('#PAIS_REST').val(COUNTRY);
        	$('#TEL_REST').val(TEL);
        	$('#EMAIL_REST').val(EMAIL);

           
        };
	</script>
	
</head>
<body>
	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>
<div class="col py-3" style="background-color: #dee3e1;">
	<div  class="container">
		<table class="table table-hover" style="text-align: center;">
       		<thead class="thead-dark">
	  			<tr>
	   	 		<th colspan="9"><b>	Información del restaurante</b></th>
	  			</tr>
	  		</thead>
	  	<thead class="thead-light">
	    <tr>
	      <th class="top">Nombre</th>
		  <th class="top">Calle</th>
		  <th class="top">Núm.</th>
		  <th class="top">Ciudad</th>
		  <th class="top">Estado</th>
		  <th class="top">Pais</th>
	      <th class="top">Telefono</th>
	      <th class="top">Email</th>
	      <th class="top">Editar</th>
	    </tr>
	  	</thead>
	  <?php 
  		//ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO
  		$sql = "SELECT * FROM REST_INFO;";

  		$result=mysqli_query($conection, $sql);
  
	    while ($row=mysqli_fetch_assoc($result)){ 
	      ?>

	      
	        <tr style="height: 32.12px;"> 
	          </td>
	          <td > <?php echo $row['Nombre']; ?></td>
	          <td > <?php echo $row['Calle']; ?></td>
	          <td > <?php echo $row['Numero']; ?></td>
	          <td > <?php echo $row['Ciudad']; ?></td>
	          <td > <?php echo $row['Estado']; ?></td>
	          <td > <?php echo $row['Pais']; ?></td>
	          <td > <?php echo $row['Telefono']; ?></td>
	          <td > <?php echo $row['Email']; ?></td>
	          <td><span type="button" class="btn fas fa-edit" data-toggle="modal" data-target="#editUsuario" onclick="edit_rest(<?php echo $row['ID_Rest']; ?>,'<?php echo $row['Nombre']; ?>','<?php echo $row['Calle']; ?>','<?php echo $row['Numero']; ?>','<?php echo $row['Ciudad']; ?>','<?php echo $row['Estado']; ?>','<?php echo $row['Pais']; ?>','<?php echo $row['Telefono']; ?>','<?php echo $row['Email']; ?>')"></span></td>
	        </tr> 
	      <?php 
	    }
	    mysqli_free_result($result);
	    //mysqli_close($conection);

	  ?>
	</table>

	
            
           

	<!-- Modal Edit Rest -->
	 <form action="restinfo.php?user=<?php echo $id;?>" method="post">
    <div class="modal fade" id="editUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
            
                    <h5 class="modal-title">Modificar Restaurante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>


            <div class="modal-body">
              <div class="container" style="text-align: center;">  
               
                        <input type="hidden"  class="form-control" id="ID_REST" name="id_rest" style="border:0; text-align: center;" readonly="readonly" style="text-align: center;">
                 
               

				<div class="form-group">
                    <label>Nombre</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="NOMBRE_REST" name="nombre_rest"  required="" placeholder="Ingrese el nombre del restaurante" style="text-align: center;">
                    </div>
                </div>

                <div class="form-row">
					    <div class="form-group col-md-8">
					      <label for="inputPassword4">Calle</label>
					      <input type="text" class="form-control" required=""  id="CALLE_REST" name="calle_rest" placeholder="Ingrese la calle" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-4">
					      <label for="inputPassword4">Número</label>
					      <input type="text" class="form-control" id="NUM_REST" name="num_rest" required=""  placeholder="Ingrese el número" onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align: center;">
					    </div>
				</div>


                
				<div class="form-row">
					    <div class="form-group col-md-4">
					      <label for="inputPassword4">Ciudad</label>
					      <input type="text" class="form-control" required="" id="CIUDAD_REST" name="ciudad_rest" placeholder="Ingrese la ciudad" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-4">
					      <label for="inputPassword4">Estado</label>
					      <input type="text" class="form-control" required="" id="ESTADO_REST" name="estado_rest" placeholder="Ingrese el estado" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-4">
					      <label for="inputPassword4">Pais</label>
					      <input type="text" class="form-control" required="" id="PAIS_REST" name="pais_rest" placeholder="Ingrese el país" style="text-align: center;">
					    </div>
				</div>

                 <div class="form-row">
                 	<div class="form-group col-md-6">
					      <label for="inputPassword4">Teléfono</label>
					      <input type="text" class="form-control" id="TEL_REST" name="tel_rest" required="" placeholder="Ingrese el teléfono" onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align: center;">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Email</label>
					      <input type="email" class="form-control" required="" id="EMAIL_REST" name="email_rest" placeholder="Ingrese el email de contacto" style="text-align: center;">
					    </div>
					    
				</div>

	               
               <div>
                
            </div>
        </div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="modificar_rest"class="btn btn-custom">Modificar</button>
            </div>

            
        </div>
        </div>
    </div>
    <!-- Modal Edit Rest END -->
</form>

		</div>
	</div>
</body>
</html>