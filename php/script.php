<?php 

	require_once('conexion.php');
	$conn=new Conexion();
	$conection = $conn->conectarse();

	/*$sql=
	"	
CREATE SCHEMA IF NOT EXISTS restaurante DEFAULT CHARACTER SET utf8 ;
USE DATABASE restaurante ;

CREATE TABLE IF NOT EXISTS restaurante.usuario (
  ID_Usuario INT NOT NULL AUTO_INCREMENT,
  Tipo_Usuario ENUM('Gerente', 'Cajero', 'Mesero', 'Cocinero', 'NULL') NOT NULL,
  Nombre CHAR(50) NOT NULL,
  Apellido_P CHAR(50) NOT NULL,
  Credencial_Usuario VARCHAR(45) NOT NULL,
  Credencial_Password VARCHAR(260) NOT NULL,
  Telefono VARCHAR(45) NULL DEFAULT NULL,
  Salario FLOAT NULL DEFAULT NULL,
  PRIMARY KEY (ID_Usuario),
  UNIQUE INDEX ID_Usuario_UNIQUE (ID_Usuario ASC) VISIBLE,
  UNIQUE INDEX Credencial_Usuario_UNIQUE (Credencial_Usuario ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS restaurante.actividad (
  ID_Actividad INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(150) NULL DEFAULT NULL,
  ID_Usuario INT NULL DEFAULT '0',
  Estado ENUM('Sin asignar', 'Asignado', 'Terminado') NULL DEFAULT 'Sin asignar',
  PRIMARY KEY (ID_Actividad),
  UNIQUE INDEX ID_Actividad_UNIQUE (ID_Actividad ASC) VISIBLE,
  INDEX Usuario_ACT (ID_Usuario ASC) VISIBLE,
  CONSTRAINT Usuario_ACT
    FOREIGN KEY (ID_Usuario)
    REFERENCES restaurante.usuario (ID_Usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS restaurante.actividad_log (
  ID_Actividad_log INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(150) NULL DEFAULT NULL,
  Id_Usuario INT NULL DEFAULT NULL,
  Fecha TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX Actividad (ID_Actividad_log ASC) VISIBLE,
  INDEX Usuario (Id_Usuario ASC) VISIBLE,
  CONSTRAINT Usuario
    FOREIGN KEY (Id_Usuario)
    REFERENCES restaurante.usuario (ID_Usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS restaurante.inventario (
  `ID_Item` INT NOT NULL AUTO_INCREMENT,
  `Nombre` CHAR(100) NOT NULL,
  `Categoria` ENUM('Alimento', 'Bebida', 'Entrada', 'Postre', 'Extra') NULL DEFAULT NULL,
  `Unidad` ENUM('Gramos', 'Pieza', 'Otro') NULL DEFAULT NULL,
  `Precio_Original` FLOAT NULL DEFAULT NULL,
  `Fecha_Registro` DATE NULL DEFAULT curdate(),
  `Fecha_Caducidad` DATE NULL DEFAULT curdate(),
  `Rango_min` FLOAT NULL DEFAULT NULL,
  `Cantidad_disponible` FLOAT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Item`))
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`menu` (
  `ID_Item_Menu` INT NOT NULL,
  `Nombre` VARCHAR(100) NULL DEFAULT NULL,
  `Origen` INT NULL DEFAULT NULL,
  `Porcion` FLOAT NOT NULL,
  `Precio_Publico` FLOAT NULL DEFAULT '0',
  INDEX `Origen_idx` (`Origen` ASC) VISIBLE,
  CONSTRAINT `Origen`
    FOREIGN KEY (`Origen`)
    REFERENCES `restaurante`.`inventario` (`ID_Item`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`mesa` (
  `ID_Mesa` INT NOT NULL,
  `Estado` ENUM('Disponible', 'No disponible', 'Activa', 'Pedido activo') NULL DEFAULT 'Disponible',
  PRIMARY KEY (`ID_Mesa`),
  UNIQUE INDEX `ID_Mesa_UNIQUE` (`ID_Mesa` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`pedido` (
  `ID_Pedido_item` INT NOT NULL AUTO_INCREMENT,
  `ID_Pedido` INT NOT NULL,
  `Nombre_producto` VARCHAR(250) NOT NULL,
  `Cantidad` INT NOT NULL,
  `Precio` FLOAT NOT NULL,
  `Total` FLOAT NOT NULL,
  `Estado_orden` ENUM('Esperando_mesero', 'Esperando_cocinero', 'En_preparacion', 'Listo_cocina', 'Entregado_mesero', 'Esperando_cliente') NULL DEFAULT NULL,
  `Hora` TIME NULL DEFAULT curtime(),
  PRIMARY KEY (`ID_Pedido_item`),
  UNIQUE INDEX `Pedido` (`ID_Pedido_item` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 137
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`pedido_mesa` (
  `ID_Pedido` INT NOT NULL AUTO_INCREMENT,
  `Orden` INT NOT NULL,
  `ID_Mesa` INT NOT NULL,
  `Total` FLOAT NOT NULL DEFAULT '0',
  `Fecha` DATE NOT NULL DEFAULT curdate(),
  `Hora` TIME NOT NULL DEFAULT curtime(),
  `ID_Usuario_Cajero` INT NOT NULL DEFAULT '0',
  `ID_Usuario_Mesero` INT NOT NULL DEFAULT '0',
  `Estado_orden` ENUM('En proceso', 'Terminada') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT 'En proceso',
  `ID_USUARIO` INT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Pedido`),
  UNIQUE INDEX `Pedido` (`ID_Pedido` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 59
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `restaurante`.`registro_global` (
  `ID_Usuario` INT NOT NULL AUTO_INCREMENT,
  `Credencial_Usuario` VARCHAR(45) NOT NULL,
  `Credencial_Password` VARCHAR(260) NOT NULL,
  `ID_Tenant` INT NOT NULL,
  PRIMARY KEY (`ID_Usuario`),
  UNIQUE INDEX `ID_Usuario_UNIQUE` (`ID_Usuario` ASC) VISIBLE,
  UNIQUE INDEX `Credencial_Usuario_UNIQUE` (`Credencial_Usuario` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 10001
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`reseña` (
  `ID_Reseña` INT NOT NULL AUTO_INCREMENT,
  `Comida` FLOAT NULL DEFAULT '0',
  `Servicio` FLOAT NULL DEFAULT '0',
  `Comentario` VARCHAR(200) NULL DEFAULT NULL,
  `ID_Usuario` INT NULL DEFAULT NULL,
  `Fecha` DATE NULL DEFAULT curdate(),
  PRIMARY KEY (`ID_Reseña`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `restaurante`.`rest_info` (
  `ID_Rest` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(100) NULL DEFAULT NULL,
  `Calle` VARCHAR(200) NULL DEFAULT NULL,
  `Numero` VARCHAR(30) NULL DEFAULT NULL,
  `Ciudad` VARCHAR(200) NULL DEFAULT NULL,
  `Estado` VARCHAR(200) NULL DEFAULT NULL,
  `Pais` VARCHAR(200) NULL DEFAULT NULL,
  `Telefono` VARCHAR(15) NULL DEFAULT NULL,
  `Email` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_Rest`),
  UNIQUE INDEX `ID_R` (`ID_Rest` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
";
$result = mysqli_query($conection,$sql);
echo mysqli_errno($conection) . ": " . mysqli_error($conection) . "\n";*/

	$usuario = $_POST['Usuario'];
	$contraseña = $_POST['Contraseña'];
	$contraseña_usuario = password_hash($contraseña, PASSWORD_DEFAULT);
	$tenant = 0;

	$sql ="SELECT MAX(ID_USUARIO) AS MAX FROM REGISTRO_GLOBAL;";
	$result = mysqli_query($conection,$sql);
	$row=mysqli_fetch_assoc($result);
 	
 	if(is_null($row['MAX'])){$tenant = 10000;}
 		else{$tenant = $row['MAX'] + 1;}

	$sql="INSERT INTO REGISTRO_GLOBAL VALUES ($tenant,'$usuario','$contraseña_usuario', $tenant);";
	$result = mysqli_query($conection,$sql);

	$tipo_usuario = 'Gerente';
  	$nombre_usuario = $_POST['Nombre'];
  	$apellido_usuario = $_POST['Apellido'];
  	$telefono_usuario = $_POST['Telefono'];
  	$salario_usuario = $_POST['Salario'];

  	$sql="INSERT INTO USUARIO (ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO) VALUES 
  	($tenant,'$tipo_usuario', '$nombre_usuario', '$apellido_usuario', '$usuario', '$contraseña_usuario', $telefono_usuario, $salario_usuario);";
 	$result = mysqli_query($conection,$sql);
 	
 	$calle = $_POST['calle_rest'];
 	$num = $_POST['num_rest'];
 	$ciudad = $_POST['ciudad_rest'];
 	$estado = $_POST['estado_rest'];
 	$pais = $_POST['pais_rest'];
 	$tel = $_POST['tel_rest'];
 	$email = $_POST['email_rest'];
 	$nombre = $_POST['nombre_rest'];

 	$sql = "INSERT INTO REST_INFO (NOMBRE, CALLE, NUMERO, CIUDAD, ESTADO, PAIS, TELEFONO, EMAIL) VALUES ('$nombre', '$calle', '$num', '$ciudad', '$estado', '$pais', '$tel', '$email');";
 	$result = mysqli_query($conection,$sql);


 	echo "<script>
	                alert('Nuevo Restaurante guardado exitosamente, Favor de ingresar con sus credenciales.');
	                window.location= '../index.php';
	    </script>";
	
?>