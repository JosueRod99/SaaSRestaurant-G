<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();


//Agregar usuario
if(isset($_POST['agregar_usuario']))
 {
  	$tipo_usuario = $_POST['tipo_usuario'];
  	$nombre_usuario = strtoupper($_POST['Nombre']);
  	$apellido_usuario = strtoupper($_POST['Apellido']);
  	$crendencial_usuario = $_POST['Usuario'];
  	$contraseña = $_POST['Contraseña'];
  	$contraseña_usuario = password_hash($contraseña, PASSWORD_DEFAULT);
  	$telefono_usuario = $_POST['Telefono'];
  	$salario_usuario = $_POST['Salario'];

  	$sql="INSERT INTO USUARIO (TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO) VALUES 
  	('$tipo_usuario', '$nombre_usuario', '$apellido_usuario', '$crendencial_usuario', '$contraseña_usuario', $telefono_usuario, $salario_usuario);";
 	$result = mysqli_query($conection,$sql);
 	
 }

//Modificar usuario
if(isset($_POST['modificar_usuario']))
 {
 	$id_usuario = $_POST['id_usu'];
  	$tipo_usuario = $_POST['tipo_usuario'];
  	$nombre_usuario = strtoupper($_POST['Nombre']);
  	$apellido_usuario = strtoupper($_POST['Apellido']);
  	$crendencial_usuario = $_POST['Usuario'];
  	$telefono_usuario = $_POST['Telefono'];
  	$salario_usuario = $_POST['Salario'];

  	$sql = "UPDATE USUARIO SET TIPO_USUARIO = '$tipo_usuario', NOMBRE = '$nombre_usuario', APELLIDO_P = '$apellido_usuario', CREDENCIAL_USUARIO = '$crendencial_usuario', TELEFONO = '$telefono_usuario', SALARIO = $salario_usuario WHERE ID_USUARIO = $id_usuario; ";

 	$result = mysqli_query($conection,$sql);
 	
 }

//Eliminar Usuario
if(isset($_POST['eliminar_usuario']))
 {
 	$id_usuario = $_POST['id_usu'];
  	$sql = "DELETE FROM USUARIO WHERE ID_USUARIO = $id_usuario; ";
 	$result = mysqli_query($conection,$sql);
 	
 } 

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		edit_user = function(ID,Type,Name,LName,User,Phone,Salary)
        {
            $('#ID_USER').val(ID);
            $('#NAME_USER').val(Name);
            $('#LNAME_USER').val(LName);
            $('#USER_USER').val(User);
            $('#PHONE_USER').val(Phone);
            $('#SALARY_USER').val(Salary);
            $('#TYPE_USER_'+Type).prop('checked', true);
           
        };
        del_user = function(ID)
        {
        	$('#Delete_ID').val(ID); 
        }
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
	   	 		<th colspan="8"><b>Usuarios</b></th>
	  			</tr>
	  		</thead>
	  	<thead class="thead-light">
	    <tr>
	      <th class="top">Tipo</th>
	      <th class="top">Nombre</th>
	      <th class="top">Apellido</th>
	      <th class="top">Credencial Usuario</th>
	      <th class="top">Telefono</th>
	      <th class="top">Salario Mensual</th>
	      <th class="top">Editar</th>
	      <th class="top">Eliminar</th>
	    </tr>
	  	</thead>
	  <?php 
  		//ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO
  		$sql = "SELECT * FROM USUARIO WHERE ID_USUARIO != 0 order by TIPO_USUARIO asc;";

  		$result=mysqli_query($conection, $sql);
  
	    while ($row=mysqli_fetch_assoc($result)){ 
	      ?>

	      
	        <tr style="height: 32.12px;"> 
	          </td>
	          <td ><?php echo $row['Tipo_Usuario']; ?></td>
	          <td ><?php echo $row['Nombre']; ?></td>
	          <td ><?php echo $row['Apellido_P']; ?></td>
	          <td ><?php echo $row['Credencial_Usuario']; ?></td>
	          <td ><?php echo $row['Telefono']; ?></td>
	          <td >$ <?php echo $row['Salario']; ?></td>
	          <td><span type="button" class="btn fas fa-edit" data-toggle="modal" data-target="#editUsuario" onclick="edit_user(<?php echo $row['ID_Usuario']; ?>,'<?php echo $row['Tipo_Usuario']; ?>','<?php echo $row['Nombre']; ?>','<?php echo $row['Apellido_P']; ?>','<?php echo $row['Credencial_Usuario']; ?>','<?php echo $row['Telefono']; ?>',<?php echo $row['Salario']; ?>)"></span></td>
              <td><span type="button" class="btn fas fa-trash-alt" data-toggle="modal" data-target="#EliminarUsuario" onclick="del_user(<?php echo $row['ID_Usuario']; ?>)"></span></td>
	        </tr> 
	      <?php 
	    }
	    mysqli_free_result($result);
	    //mysqli_close($conection);

	  ?>
	</table>

	<div class="row rounded-bottom" >
                    <div class="container-fluid d-flex">
                       <button type="button" class="btn btn-custom m-auto" data-toggle="modal" data-target="#agregarmesa">Agregar Usuario</button> 
                    </div>
                </div>

            </div>

            <form action="personal.php?user=<?php echo $id;?>" method="post">
            <!-- Modal Agregar User  -->
            <div class="modal fade" id="agregarmesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
            
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>


            <div class="modal-body">
              <div class="container" style="text-align: center;"> 

                <div class="form-group">
                    <label >Nombre</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" name="Nombre" required="" style="text-align: center;" placeholder="Ingrese el nombre">
                    </div>
                </div>

                <div class="form-group" style="text-align: center;">
                    <label >Apellido</label>
                    <div class="col-sm">
                        <input type="text" class="form-control"  name="Apellido" required="" style="text-align: center;" placeholder="Ingrese el apellido">
                    </div>
                </div>

                <div class="form-group">
                    <label >Crendencial</label>
                    <div class="col-sm">
                        <input type="text" class="form-control"  name="Usuario" required="" style="text-align: center;" placeholder="Ingrese la credencial de acceso">
                    </div>
                </div>

                <div class="form-group">
                    <label >Contraseña</label>
                    <div class="col-sm">
                        <input type="text" class="form-control"  name="Contraseña" required="" style="text-align: center;" placeholder="Ingrese la contraseña">
                    </div>
                </div>

                <div class="form-group">
                    <label >Telefono</label>
                    <div class="col-sm">
                        <input type="text" class="form-control"  name="Telefono" required=""  onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align: center;" placeholder="Ingrese el telefono">
                    </div>
                </div>

                <div class="form-group">
                    <label>Salario</label>
                    <div class="col-sm">
                        <input type="text" class="form-control"  name="Salario" required="" style="text-align: center;" placeholder="Ingrese el salario mensual">
                    </div>
                </div>

	                <label>Puesto</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" value="Gerente">
						  <label class="form-check-label" >Gerente</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" value="Cajero">
						  <label class="form-check-label" >Cajero</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" value="Mesero" >
						  <label class="form-check-label" >Mesero</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" value="Cocinero"> 
						  <label class="form-check-label" >Cocinero</label>
					</div>
               <div>
                
            </div>
        	</div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="agregar_usuario"class="btn btn-custom">Agregar</button>
            </div>

            </form>
        </div>
        </div>
            </div>
            <!-- Modal Agregar User END-->

	<!-- Modal Edit User -->
    <form action="personal.php?user=<?php echo $id;?>" method="post" name="user">
    <div class="modal fade" id="editUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
            
                    <h5 class="modal-title">Modificar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>


            <div class="modal-body">
              <div class="container" style="text-align: center;">  
               <div class="form-group">
                    <label>Id</label>
                    <div class="col-sm">
                        <input type="text"  class="form-control" id="ID_USER" name="id_usu" style="border:0; text-align: center;" readonly="readonly" style="text-align: center;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nombre</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="NAME_USER" name="Nombre" required="" style="text-align: center;">
                    </div>
                </div>

                <div class="form-group" style="text-align: center;">
                    <label>Apellido</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="LNAME_USER" name="Apellido" required="" style="text-align: center;">
                    </div>
                </div>



                <div class="form-group">
                    <label>Crendencial</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="USER_USER" name="Usuario"  required="" style="text-align: center;">
                    </div>
                </div>

                <div class="form-group">
                    <label >Telefono</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="PHONE_USER" name="Telefono" required=""  onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align: center;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Salario</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="SALARY_USER" name="Salario" required="" style="text-align: center;">
                    </div>
                </div>

	                <label>Puesto</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" id="TYPE_USER_Gerente" value="Gerente">
						  <label class="form-check-label" >Gerente</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" id="TYPE_USER_Cajero" value="Cajero">
						  <label class="form-check-label" >Cajero</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" id="TYPE_USER_Mesero" value="Mesero" >
						  <label class="form-check-label" >Mesero</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="tipo_usuario" required="" id="TYPE_USER_Cocinero" value="Cocinero"> 
						  <label class="form-check-label" >Cocinero</label>
					</div>
               <div>
                
            </div>
        </div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="modificar_usuario"class="btn btn-custom">Modificar</button>
            </div>

            </form>
        </div>
        </div>
    </div>
    <!-- Modal Edit User END -->

    <!-- Modal Eliminar User -->
    <form action="personal.php?user=<?php echo $id;?>" method="post">
    <div class="modal fade" id="EliminarUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Desea Eliminar al usuario
                        <input type="text" id="Delete_ID" name="id_usu" style="border:0;" readonly="readonly"> ?
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_usuario" class="btn btn-danger">Si</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Delete User END -->

		</div>
	</div>
</body>
</html>