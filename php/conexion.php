<?php
		class Conexion{


			function conectarse(){
				$enlace= mysqli_connect("localhost","JosueDev","Mysql9914","restaurante");
				//$enlace= mysqli_connect("sql308.epizy.com","epiz_30072014","Dvqwe9xfPU1uEn","epiz_30072014_restaurante");
				if($enlace){
						
				}else{
					die('Error de Conexión (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
				}
				return($enlace);
				// mysqli_close($enlace); //cierra la conexion a nuestra base de datos, un punto de seguridad importante.
			}
			
		}

?>