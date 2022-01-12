<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();

 /*------*/
 //Descontar del menu al inventario 
if(isset($_POST['descontar']))
 {
  	$ID_ITEM = $_POST['ID_ITEM_MENU'];
  	$Cantidad = $_POST['CANTIDAD'];
	

	//ID_ITEM_MENU, NOMBRE, ORIGEN, PORCION, PRECIO_PUBLICO
  	$sql="SELECT ORIGEN, PORCION FROM MENU WHERE ID_ITEM_MENU = $ID_ITEM ";

 	$result = mysqli_query($conection,$sql);

 	while ($row=mysqli_fetch_assoc($result)) 
 	{	
 		$new_cantidad = 0;
 		$new_cantidad = $row['PORCION'] * $Cantidad;
 		$origen = $row['ORIGEN'];
 		$sql_edit = "UPDATE INVENTARIO SET CANTIDAD_DISPONIBLE = (CANTIDAD_DISPONIBLE - ( $new_cantidad )) WHERE ID_ITEM = '$origen'; ";
 		$sql_result = mysqli_query($conection,$sql_edit);
 	}
 	mysqli_free_result($result);
 }


  /*------*/
 //Agregar mesas
if(isset($_POST['agregar_mesa']))
 {
  	$Cantidad = $_POST['cantidad_de_mesas'];
  	$Max_mesa = 0;

  	$sql="SELECT MAX(ID_MESA) as Max_mesa from Mesa;";
 	$result = mysqli_query($conection,$sql);
 	$row=mysqli_fetch_assoc($result);
 	
 	if(is_null($row['Max_mesa'])){$Max_mesa = 0;}
 		else{$Max_mesa = $row['Max_mesa'];}

 	mysqli_free_result($result);

 	$Cantidad = $Cantidad + $Max_mesa;

 	while( $Max_mesa <= $Cantidad)
 	{
 		$sql="INSERT INTO MESA (ID_Mesa, ESTADO) VALUES ($Max_mesa,'Disponible');";
 		$result = mysqli_query($conection,$sql);
 		$Max_mesa++;
 	}
 }

//Agregar usuario
if(isset($_POST['agregar_usuario']))
 {
  	$tipo_usuario = $_POST['tipo_usuario'];
  	$nombre_usuario = $_POST['Nombre'];
  	$apellido_usuario = $_POST['Apellido'];
  	$crendencial_usuario = $_POST['Usuario'];
  	$contraseña = $_POST['Contraseña'];
  	$contraseña_usuario = password_hash($contraseña, PASSWORD_DEFAULT);
  	$telefono_usuario = $_POST['Telefono'];
  	$salario_usuario = $_POST['Salario'];

  	$sql="INSERT INTO USUARIO (TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO) VALUES 
  	('$tipo_usuario', '$nombre_usuario', '$apellido_usuario', '$crendencial_usuario', '$contraseña_usuario', $telefono_usuario, $salario_usuario);";
 	$result = mysqli_query($conection,$sql);
 	
 }


// Agregar item al menu 
if(isset($_POST['agregar_menu']))
 {
  	
	$nombre = $_POST['Nombre'];
	$precio = $_POST['Precio_publico'];
	$Max_menu = 0;
	$porcion = 0;

  	$sql="SELECT MAX(ID_ITEM_MENU) as Max_menu from Menu;";
 	$result = mysqli_query($conection,$sql);
 	$row=mysqli_fetch_assoc($result);
 	
 	if(is_null($row['Max_menu'])){$Max_menu = 0;}
 		else{$Max_menu = $row['Max_menu'] + 1; }

 	mysqli_free_result($result);

 	echo $Max_menu;


	if(!empty($_POST['lista_origen'])&&!empty($_POST['lista_porcion']))
	{
		$i=0;
		foreach($_POST['lista_origen'] as $selected)
		{	$porcion = $_POST['lista_porcion'][$i];

			$sql="INSERT INTO MENU (ID_ITEM_MENU, NOMBRE, ORIGEN, PORCION, PRECIO_PUBLICO) VALUES ($Max_menu, '$nombre', $selected, $porcion , $precio);";
 			$result = mysqli_query($conection,$sql);
			$i++;
			$porcion = 0;

		}
	}
 }




 //$psswd = substr( md5(microtime()), 1, 8);
 //echo $psswd;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	  
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
		      input.disabled=true;
		   }
			
		}
	  </script>



</head>
<body>

	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>
	<!-- MAIN -->
        <div class="col py-3" style="background-color: #dee3e1;">

            <h1>
                Welcome, Juan!
            </h1>

            <table border=1;>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th></th>
		</tr>
		<?php
		 $sql="SELECT ID_ITEM_MENU, NOMBRE, PRECIO_PUBLICO FROM MENU GROUP BY ID_ITEM_MENU; ";
 			$result = mysqli_query($conection,$sql);
	    while ($row=mysqli_fetch_assoc($result)) {
	      ?>
	    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<tr>
			<td><input type="text" value="<?php echo $row['ID_ITEM_MENU']; ?>" name="ID_ITEM_MENU"> </td>
			<td><?php echo $row['NOMBRE']; ?></td>
			<td><?php echo $row['PRECIO_PUBLICO']; ?></td>
			<td><input type="number" name="CANTIDAD"></td>
			<td><input type="submit" name="descontar" value="Descontar"></td>
		</form>
		 <?php 
	    }
	    mysqli_free_result($result);

	    //mysqli_close($conection);
	  	?>
		</tr>
	</table>
	<br>
	<table border=1;>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th></th>
		</tr>
		<tr>
		<?php
		$sql="SELECT * FROM INVENTARIO; ";
 		$result = mysqli_query($conection,$sql);
	    while ($row=mysqli_fetch_assoc($result)) {
	      ?>
	   
		<tr>
			<td><?php echo $row['ID_Item']; ?></td>
			<td><?php echo $row['Nombre']; ?></td>
			<td><?php echo $row['Cantidad_disponible']; ?></td>
		</tr>
			
		 <?php 
	    }
	    mysqli_free_result($result);

	    //mysqli_close($conection);
	  	?>	
		</tr>
	</table>
<br>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table border = 1;>
		<tr>
			<th>Cantidad de mesas</th>
			<th>Acción</th>
		</tr>
		<tr>
			<td>
				<input type="number" name="cantidad_de_mesas" min="0" max="100">
			</td>
			<td>
				<input type="submit" name="agregar_mesa" value="Agregar">
			</td>
		</tr>
	</table>
	</form>

<br>
	<!-- Muestra usuarios-->
  <?php 
  //ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO
  $sql = "SELECT * FROM USUARIO order by ID_Usuario asc;";

  $result=mysqli_query($conection, $sql);
  ?>
<br><br><br>
<br>
	<div  class="container">
		<table class="table table-hover" style="text-align: center;">
       		<thead class="thead-dark">
	  			<tr>
	   	 		<th colspan="14"><b>Usuarios</b></th>
	  			</tr>
	  		</thead>
	  	<thead class="thead-light">
	    <tr>
	      <th class="top" width="4%">ID</th>
	      <th class="top">Tipo de usuario</th>
	      <th class="top">Nombre</th>
	      <th class="top">Apellido</th>
	      <th class="top">Credencial_Usuario</th>
	      <th class="top">Credencial_Password</th>
	      <th class="top">Telefono</th>
	      <th class="top">Salario</th>
	    </tr>
	  	</thead>
	  <?php
	    while ($row=mysqli_fetch_assoc($result)){ 
	      ?>
	      
	        <tr style="height: 32.12px;"> 
	          </td>
	          <td ><?php echo $row['ID_Usuario']; ?></td>
	          <td ><?php echo $row['Tipo_Usuario']; ?></td>
	          <td ><?php echo $row['Nombre']; ?></td>
	          <td ><?php echo $row['Apellido_P']; ?></td>
	          <td ><?php echo $row['Credencial_Usuario']; ?></td>
	          <td ><?php echo $row['Credencial_Password']; ?></td>
	          <td ><?php echo $row['Telefono']; ?></td>
	          <td ><?php echo $row['Salario']; ?></td>
	        </tr> 
	      <?php 
	    }
	    mysqli_free_result($result);
	    //mysqli_close($conection);

	  ?>
	</table>

	<br>

	<br>

<div  class="container">
<table class="table table-hover" style="text-align: center;">
        <thead class="thead-dark">
    <th colspan="8">Agregar usuario</th>
  </tr>
      </thead>
       <thead class="thead-light">
    <tr>
      <th class="top">Tipo de usuario</th>
      <th class="top">Nombre</th>
      <th class="top">Apellido</th>
      <th class="top">Credencial_Usuario</th>
      <th class="top">Credencial_Password</th>
      <th class="top">Telefono</th>
      <th class="top">Salario</th>
      <th class="top"></th>
    </tr>
  </tr>
</thead>
 
       
        <tr style="height: 32.12px;">
          <td style="text-align: left;">
          	&nbsp<input type="radio" name="tipo_usuario" value="Gerente">Gerente <br>
           	&nbsp<input type="radio" name="tipo_usuario" value="Cajero">Cajero <br>
           	&nbsp<input type="radio" name="tipo_usuario" value="Mesero">Mesero <br>
           	&nbsp<input type="radio" name="tipo_usuario" value="Cocinero">Cocinero 
          </td>
          <td>
          <input type="text" name="Nombre" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese el nombre">
          </td>
          <td>
          <input type="text" name="Apellido" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese el apellido">
          </td>
          <td>
          <input type="text" name="Usuario" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese el Usuario">
          </td>
          <td>
          <input type="text" name="Contraseña" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese la contraseña">
          </td>
          <td>
          <input type="text" name="Telefono" required="required" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control form-control" style="text-align: center;" placeholder="Ingrese el telefono">
          </td>
          <td>
          <input type="number" name="Salario" required="required"  class="form-control form-control" style="text-align: center;" placeholder="Ingrese el salario">
          </td>

          <td ><button name="agregar_usuario"><img src="/images/sumbit.png" width="20px" height="20px"></button></td>
        </tr> 
      </form>

</table>
</div>

<br><br>

<div  class="container">
<table class="table table-hover" style="text-align: center;">
        <thead class="thead-dark">
    <th colspan="6">Agregar item menu</th>
  </tr>
      </thead>
       <thead class="thead-light">
    <tr>
      <th class="top">Nombre</th>
      <th class="top">Origen</th>
      <th class="top">Precio Original</th>
      <th class="top">Porcion</th>
      <th class="top">Precio al público</th>
      <th class="top"></th>
    </tr>
  </tr>
</thead>


      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <tr style="height: 32.12px; text-align: center;">
          <td>
          		<input type="text" name="Nombre" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese el nombre">
          </td>

          <td style="text-align: left;">
          <?php
		$sql="SELECT * FROM INVENTARIO; ";
 		$result = mysqli_query($conection,$sql);
	    while ($row=mysqli_fetch_assoc($result)) {
	      ?>
          	&nbsp<input type="checkbox" name="lista_origen[]" id="Origen_<?php echo $row['ID_Item']; ?>" onclick="Activar_porcion(<?php echo $row['ID_Item']; ?>)" value="<?php echo $row['ID_Item']; ?>"><?php echo $row['Nombre']; ?> <br>
          
          <?php 
	    }
	    //mysqli_free_result($result);

	    //mysqli_close($conection);
	  	?>
	  	  </td>

	  	  <td style="text-align: left;">
	  	  <?php
	  	    //$sql="SELECT * FROM INVENTARIO; ";
	  	  	$result = mysqli_query($conection,$sql);
	  	  	while ($row=mysqli_fetch_assoc($result)) {
	      ?>
          	&nbsp <?php echo '$ ', $row['Precio_Original']; ?><br>
          <?php 
	    }
	  	?>
	  	  </td>
	  	  <td>
	  	  	 <?php
	  	  	$result = mysqli_query($conection,$sql);
	  	  	while ($row=mysqli_fetch_assoc($result)) {
	      ?>

          <input type="number" name="lista_porcion[]" id="Porcion_<?php echo $row['ID_Item']; ?>" disabled="disabled" class="form-control form-control" style="text-align: center;" placeholder="Ingrese la porcion.">
          <?php 
	    }
	  	?> 

          <td>
          <input type="number" name="Precio_publico" required="required"  class="form-control form-control" style="text-align: center;" placeholder="Ingrese el precio final.">
          </td>

          <td ><button name="agregar_menu"><img src="/images/sumbit.png" width="20px" height="20px"></button></td>
        </tr> 
      </form>

</table>
</div>

<!-- ID_ITEM, NOMBRE, CATEGORIA, UNIDAD, PRECIO_ORIGINAL, FECHA_REGISTRO, FECHA_CADUCIDAD, RANGO_MIN, CANTIDAD_DISPONIBLE
-->
<div  class="container">
<table class="table table-hover" style="text-align: center;">
        <thead class="thead-dark">
    <th colspan="8">Agregar invetario</th>
  </tr>
      </thead>
       <thead class="thead-light" style="text-align: center;">
    <tr>
      <th class="top">Nombre</th>
      <th class="top">Categoria</th>
      <th class="top">Unidad</th>
      <th class="top">Precio Original</th>
      <th class="top">Fecha de caducidad</th>
      <th class="top">Rango mínimo</th>
      <th class="top">Cantidad disponible</th>
      <th class="top"></th>
    </tr>
  </tr>
</thead>
 
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <tr style="height: 32.12px;">
            <td>
            	<input type="text" name="Nombre" required="required" class="form-control form-control" style="text-align: center;" placeholder="Ingrese el nombre">
          	</td>
          <td style="text-align: left;">
          	&nbsp<input type="radio" name="categoria" value="Alimento">Alimento <br>
           	&nbsp<input type="radio" name="categoria" value="Bebida">Bebida <br>
           	&nbsp<input type="radio" name="categoria" value="Entrada">Entrada <br>
           	&nbsp<input type="radio" name="categoria" value="Postre">Postre <br>
           	&nbsp<input type="radio" name="categoria" value="Extra">Extra <br>
          </td>
        
          	<td style="text-align: left;">
          	&nbsp<input type="radio" name="unidad" value="Gramos">Gramos <br>
           	&nbsp<input type="radio" name="unidad" value="Pieza">Pieza <br>
           	&nbsp<input type="radio" name="unidad" value="Otro">Otro <br>
          </td>

          <td>
          <input type="number" name="Precio" required="required"  class="form-control form-control" style="text-align: center;" placeholder="Ingrese el precio.">
          </td>

          <td>
          <input type="date" name="Fecha" required="required"  class="form-control form-control" style="text-align: center;" >
          </td>

          <td>
          <input type="number" name="Rango" required="required"  class="form-control form-control" style="text-align: center;" placeholder="Ingrese el rango mínimo.">
          </td>

          <td>
          <input type="number" name="Precio" required="required"  class="form-control form-control" style="text-align: center;" placeholder="Ingrese la cantidad.">
          </td>

          <td ><button name="agregar_inventario"><img src="/images/sumbit.png" width="20px" height="20px"></button></td>
        </tr> 
      </form>

</table>
</div>

<span id='date-time'></span>


        </div>
        <!-- Main Col END -->

    </div>
    <!-- body-row END -->
	
	



</body>
</html>