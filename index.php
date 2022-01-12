
<?php
require_once('php/conexion.php');
	$conn=new Conexion();
	$conection = $conn->conectarse();

if(isset($_POST['login_cliente']))
{	/*
	$sql = "SELECT * FROM USUARIO  WHERE TIPO_USUARIO = 'NULL' ORDER BY ID_USUARIO LIMIT 1 ;";
	$result = mysqli_query($conection,$sql);
	$row=mysqli_fetch_assoc($result); 
	$id = $row['ID_Usuario'];

	if($id != NULL)
	{
		$sql_mesa = "SELECT * FROM MESA WHERE ESTADO = 'Disponible' ORDER BY ID_MESA LIMIT 1;";
		$result_mesa= mysqli_query($conection,$sql_mesa);
		$row_mesa=mysqli_fetch_assoc($result_mesa);
		$id_mesa = $row_mesa['ID_Mesa'];

		if($id_mesa!=NULL)
		{
			$orden = 1;

	    $sql="SELECT MAX(ORDEN) as ORDEN from PEDIDO_MESA;";
	    $result = mysqli_query($conection,$sql);
	    $row=mysqli_fetch_assoc($result);
	    
	    if(is_null($row['ORDEN'])){}
	        else{$orden = $row['ORDEN']+1;}

	    $ID_CLIENTE = 0;

	    $sql="SELECT MAX(ID_USUARIO) as ID from PEDIDO_MESA;";
	    $result = mysqli_query($conection,$sql);
	    $row=mysqli_fetch_assoc($result);
	    
	    if(is_null($row['ID'])){}
	        else{$ID_CLIENTE = $row['ID']+1;}


	    $sql = "INSERT INTO PEDIDO_MESA (ID_MESA, ORDEN, ID_USUARIO_MESERO, ESTADO_ORDEN, ID_USUARIO) VALUES ($id_mesa, $orden, 0, 'En proceso', $ID_CLIENTE);";
	    $result = mysqli_query($conection,$sql);
	    echo $sql;

	    $sql="UPDATE MESA SET ESTADO = 'Activa' WHERE ID_MESA = $id_mesa;" ;
    	$result = mysqli_query($conection,$sql);

			header("location:php/home.php?user=$id&cliente=$ID_CLIENTE");
		}
		
		else
		{
			mysqli_free_result($result);
			mysqli_close($conection);
			echo "<script>
	                alert('No hay mesas disponibles, intente más tarde.');
	                window.location= 'index.php';
	    </script>";
		}

	}
	else 
	{
    mysqli_free_result($result);
	mysqli_close($conection);
	echo "<script>
	                alert('Ha ocurrido un error intente más tarde.');
	                window.location= 'index.php';
	    </script>";
	}*/
	header('Location: php/opcion_restaurante.php');
	die();
}

if(isset($_POST['login']))
 {
  	
	$usuario = $_POST['user'];
	$password = $_POST['password'];

	
	
	
	$sql="SELECT * FROM USUARIO WHERE Credencial_Usuario = '$usuario';";
	$result = mysqli_query($conection,$sql);
	$row=mysqli_fetch_assoc($result); 
	$id = $row['ID_Usuario'];
	$contraseña_hash = $row['Credencial_Password'];

	if (password_verify($password,$contraseña_hash)) 
	{
		mysqli_free_result($result);
		mysqli_close($conection);
		header("location:php/home.php?user=$id");
			   /*if($type == 1)	
					header("location:home_admin.php?user=$id");
				else if($type == 2)
					header("location:home_users.php?user=$id");
				*/
	} 
	else 
	{
    mysqli_free_result($result);
	mysqli_close($conection);
	echo "<script>
	                alert('Datos incorrectos, favor de verificar.');
	                window.location= 'index.php';
	    </script>";}
	}


?>

<!DOCTYPE html>
<html lang="en" >


<head>
  <meta charset="UTF-8">
  <title>SGR</title>
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
  <link rel="stylesheet" href="css/style_login.css">

</head>
<body>
<!-- partial:index.partial.html -->
<h2>Sistema Gestor de Restaurantes</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container" >
		<form action="php/script.php" method="post">
			<div class="contenedor">
			<h1>Dar de alta Restaurante</h1>
			<span>Ingrese la información correspondiente a su Restaurante</span>
			<div class="form-row">
				
				<div class="form-group col-md-12">
				<input type="text" name="nombre_rest" placeholder="Nombre del restaurante" />
				</div>
			</div>
			<div class="form-row">
			    <div class="form-group col-md-8">
			      <input type="text" required=""  name="calle_rest" placeholder="Ingrese la calle">
			    </div>
			    <div class="form-group col-md-4">
			      <input type="text" id="NUM_REST" name="num_rest" required=""  placeholder="Núm" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
			    </div>
			</div>

			<div class="form-row">
			    <div class="form-group col-md-6">
			      <input type="text"  required=""  name="ciudad_rest" placeholder="Ciudad">
			    </div>
			    <div class="form-group col-md-6">
			      <input type="text"  required=""  name="estado_rest" placeholder="Estado" >
			    </div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-12">
				      <input type="country"  required=""  name="pais_rest" placeholder="País" >
				</div>
			</div>

			<div class="form-row">
             	<div class="form-group col-md-12">
				    <input type="text" name="tel_rest" required="" placeholder="Teléfono" onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
				</div>
			</div>
			<div class="form-row">
			    <div class="form-group col-md-12">
			      <input type="email"  required="" name="email_rest" placeholder="Email de contacto">
			    </div>
			</div>

			<h1>Dar de alta al Gerente</h1>
			<span>Esta será la cuenta principal</span>

			<div class="form-group">
                    <div class="col-sm">
                        <input type="text" name="Nombre" required=""  placeholder="Nombre">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm">
                        <input type="text" name="Apellido" required=""  placeholder="Apellido">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm">
                        <input type="text"  name="Usuario" required="" placeholder="Credencial de acceso" title="Con esta credencial accederá al sistema.">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm">
                        <input type="text" name="Contraseña" required="" placeholder="Contraseña" title="Con esta contraseña accederá al sistema. ¡Importante no perder!">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm">
                        <input type="text" name="Telefono" required=""  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Celular">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm">
                        <input type="text" name="Salario" required="" placeholder="Salario mensual">
                    </div>
                </div>
			<button name="Registrar">¡Registrar!</button>
		</div>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
			<h1>Iniciar Sesión</h1>
			<input type="text" placeholder="Cuenta" name="user" />
			<input type="password" placeholder="Password" name="password"/>
			<button name="login">Iniciar</button><br>
			<button style="background-color: white; color: #2b72ff;" name="login_cliente">Soy un cliente</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>¿Ya tienes cuenta?</h1>
				<p>Inicia sesión para utilizar el sistema</p>
				<button class="ghost" id="signIn">Iniciar Sesión</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>¡Bienvenido <br>a SGR!</h1>
				<p>Registra tu Restaurante para empezar a utilizar el sistema</p>
				<button class="ghost" id="signUp">Registrar</button>
			</div>
		</div>
	</div>
</div>

<!-- partial -->
  <script  src="js/script.js"></script>

</body>
</html>

  