<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();
 
date_default_timezone_set('America/Mazatlan');
 $hoy = getdate();


//Nombre de los meses esp en arreglos
    $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');

 $fec_top = $meses[$hoy['mon']]." ".$hoy['mday'].", ".$hoy['year'];

 $fecha_hoy = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];


if(isset($_POST['login_cliente']))
{   
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

            header("location:home.php?user=$id&cliente=$ID_CLIENTE");
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
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <style type="text/css">
        .x
        {
            display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
        }
  		
.myContMenu
        {
           width: 250px; 
        }
        .myBtnMenu
        {
            background-color: blue;
            width: 15rem;
            height: 15rem;
            border-radius: 20px;
        }
        .myImg
        {
        	height: 80%; 
        	width: 100%; 
        	border-radius: 10px;
        }
	  </style>



</head>
<body>
<!-- Bootstrap NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-theme fixed-top">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="fas fa-h-square ml-1 mr-2"></span>
            <span class="menu-collapsed">
                SGR | Restaurantes
            </span>

        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><?php echo $fec_top;?></a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
            
                <li class="nav-item active">
                    <a class="nav-link" href="/">Go Back</a>
                </li>
            </ul>
            
            

    </nav>
	
	<!-- MAIN --><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
	<div class="container x">
			<div class="col py-3" style="background-color: #dee3e1;">
                <center><font size="10"><p>Selecciona un Restaurante</font></center>
            
                <div class="row">
                <?php 
                $sql = "SELECT * FROM REST_INFO;";
                $result = mysqli_query($conection,$sql);

                $row_rest = mysqli_fetch_assoc($result);
               
                ?>
                
                <div class="col-md-3 m-4 d-flex justify-content-center">
                    <div class="container myContMenu">
                        <div class="row d-flex justify-content-center">
                            <button type="button m-1 " name="login_cliente"
                            class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                                <img src="../images/restaurante.png" class="myImg">
                            </button>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <h4> <?php echo $row_rest['Nombre'];?> </h4>
                        </div>
                    </div>
                </div>
        

    </div>
</div>
</div>

</body>
</html>