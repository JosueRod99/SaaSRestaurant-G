<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();
 $id = $_GET['user'];
date_default_timezone_set('America/Mazatlan');
 $hoy = getdate();


//Nombre de los meses esp en arreglos
    $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');

 $fec_top = $meses[$hoy['mon']]." ".$hoy['mday'].", ".$hoy['year'];

 $fecha_hoy = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];


 $sql="SELECT * FROM USUARIO WHERE ID_USUARIO = $id ";
 $result = mysqli_query($conection,$sql);
 $row_user = mysqli_fetch_assoc($result);

 if($row_user['Tipo_Usuario'] == 'NULL')
 {  
    $id_cliente = $_GET['cliente'];
    $sql="SELECT * FROM PEDIDO_MESA WHERE ID_USUARIO = $id_cliente LIMIT 1;";
    $result = mysqli_query($conection,$sql);
    $row_pedido = mysqli_fetch_assoc($result);
    

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
                <?php 
                $sql = "SELECT * FROM REST_INFO;";
                $result = mysqli_query($conection,$sql);
                $row_rest = mysqli_fetch_assoc($result);

                echo $row_rest['Nombre'];
                ?>
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
                    <?php 
                    if($row_user['Tipo_Usuario'] != 'NULL')
                    {?>
                        <a class="nav-link" href="home.php?user=<?php echo $id;?>">Home <span class="sr-only">(current)</span></a>
                    <?php
                    }?>
                    <?php 
                    if($row_user['Tipo_Usuario'] == 'NULL')
                    {?>
                        <a class="nav-link" href="home.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>">Home <span class="sr-only">(current)</span></a>
                    <?php
                    }?> 
                </li>

                <li class="nav-item ">
                    <a class="nav-link" href="#">|</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <?php 
                            if($row_user['Tipo_Usuario'] == 'NULL')
                                {
                                    echo "Cliente - Mesa ".$row_pedido['ID_Mesa'];
                                }
                            else
                                {
                                    echo $row_user['Nombre'],'  ',$row_user['Apellido_P'],' - ',$row_user['Tipo_Usuario'] ;
                                }
                        ?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#">|</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/">Log Out</a>
                </li>
            </ul>
            
            

    </nav>
    <!-- NavBar END -->


    

        <!-- sidebar-container END -->
        
</body>
</html>