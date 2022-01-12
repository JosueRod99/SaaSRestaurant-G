<?php
    $id = $_GET['user'];
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();


//Agregar mesa
if(isset($_POST['agregar_mesa']))
 {
  	$Cantidad = $_POST['cantidad_de_mesas'];
  	$Max_mesa = 0;

  	$sql="SELECT MAX(ID_MESA) as Max_mesa from Mesa;";
 	$result = mysqli_query($conection,$sql);
 	$row=mysqli_fetch_assoc($result);
 	
 	if(is_null($row['Max_mesa'])){$Max_mesa = 1;}
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
//Fin agregar mesa

//Dar de baja mesa - cambiar lo de la alta con el jquery
 if(isset($_POST['modificar_mesa']))
 {
  	$Mesa = $_POST['Id_Mesa_Edit'];

  	$sql="SELECT ESTADO FROM MESA WHERE ID_MESA = $Mesa;" ;
  
 	$result = mysqli_query($conection,$sql);
 	$row=mysqli_fetch_assoc($result);

 	if($row['ESTADO'] == 'Disponible')
 	{
  		$sql="UPDATE MESA SET ESTADO = 'No disponible' WHERE ID_MESA = $Mesa;" ;
 		$result = mysqli_query($conection,$sql);
 	}
 	else
 	{
 		$sql="UPDATE MESA SET ESTADO = 'Disponible' WHERE ID_MESA = $Mesa;" ;
 		$result = mysqli_query($conection,$sql);
 	}
 }
//Fin dar de baja mesa

 //Activar mesa
 if(isset($_POST['activar_mesa']))
 {
    $Mesa = $_POST['Id_Mesa'];
    $ID_Mesero = $_POST['USER_ID'];

    $sql="UPDATE MESA SET ESTADO = 'Activa' WHERE ID_MESA = $Mesa;" ;
    $result = mysqli_query($conection,$sql);


    $orden = 1;

    $sql="SELECT MAX(ORDEN) as ORDEN from PEDIDO_MESA;";
    $result = mysqli_query($conection,$sql);
    $row=mysqli_fetch_assoc($result);
    
    if(is_null($row['ORDEN'])){}
        else{$orden = $row['ORDEN']+1;}

    $sql = "INSERT INTO PEDIDO_MESA (ID_MESA, ORDEN, ID_USUARIO_MESERO, ESTADO_ORDEN) VALUES ($Mesa, $orden, $ID_Mesero, 'En proceso');";
    $result = mysqli_query($conection,$sql);


 }

//Eliminar mesa
 if(isset($_POST['eliminar_mesa']))
 {
  	$Mesa = $_POST['ID_Delete'];

  	$sql="DELETE FROM MESA WHERE ID_MESA = $Mesa;" ;
 	$result = mysqli_query($conection,$sql);
 	
 	if($result)
 	{
 		echo "<script>
	                alert('Mesa eliminada correctamente.');
	    </script>";
 	}
 	else
 		{
 		echo "<script>
	                alert('Intente nuevamente.');
	    </script>";
 	}

 }
// Fin eliminar mesa
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title></title>
	<script type="text/javascript">
          Mesa = function(ID,STAT)
        {
            $('#editMesa').val(ID);
            $('#eMesa').html("Modificar mesa "+ID);
            $('#Delete_ID').val(ID);
           //var xd =  $('#inputType').val();
        };

         Mesa_activar = function(ID)
        {
            $('#activarMesa').val(ID);
            $('#PMesa').html("¿Activar Mesa "+ID+"?");
            
        };

        Pedido = function(ID)
        {
            $('#pedidoMesa').val(ID);  
        };
        
	</script>
	<style type="text/css">
	  	.card:hover{
     			transform: scale(1.05);
  				box-shadow: 0 10px 20px 
  				rgba(0,0,0,.12), 0 4px 8px 
  				rgba(0,0,0,.06);
					}
		</style>
</head>
<body>
    <form action="mesas.php?user=<?php echo $id;?>" method="post">
	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>

	<div class="col py-3" style="background-color: #dee3e1;">
            <div class="container">

                <div class="row rounded-top bg-theme4" id="rooms-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active tab" id="floor1-tab" data-toggle="tab" href="#floor1" role="tab" aria-controls="floor1" aria-selected="true">Vista general</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor2-tab" data-toggle="tab" href="#floor2" role="tab" aria-controls="floor2" aria-selected="false">Activas</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tab" id="floor3-tab" data-toggle="tab" href="#floor3" role="tab" aria-controls="floor3" aria-selected="false">Pedido Activo</a>
                        </li>
                    </ul>
                </div>

                <div class="row p-4" id="rooms-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="floor1" role="tabpanel" aria-labelledby="floor1-tab">
                            <div class="row">


                            	<?php
									$sql="SELECT * FROM MESA  ;";
 									$result = mysqli_query($conection,$sql);
	    							while ($row=mysqli_fetch_assoc($result)) {
	      							?>
	   
                            	<!-- Mesa -->
                                <!-- Dependiendo del tipo de usuario que le de click, abrira un modal u otro -->
                                <?php if($row_user['Tipo_Usuario'] ==  'Gerente')
                                    {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#editarmesa"style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" data-toggle="modal" data-target="#editarmesa" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        }
                                ?>
                                
                                <?php 
                                    }
                                    else{


                                       if($row_user['Tipo_Usuario'] ==  'Mesero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#activar_mesa"style="width: 14rem; text-align: center;" onclick="Mesa_activar(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero

                                        if($row_user['Tipo_Usuario'] ==  'Cajero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                        if($row_user['Tipo_Usuario'] ==  'Cocinero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" >
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                    }
                                ?>

                                    <div class="card-header"><?php echo $row['Estado']; ?></div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="card-title">Mesa <?php echo $row['ID_Mesa']; ?></h5>
                                                </div>
                                                <div class="col-6 d-flex">
                                                    <!--<span class="fas fa-bed fa-3x m-auto"></span>-->
                                                    <img src="https://img.icons8.com/ios-filled/50/000000/table.png"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								
                            <?php }?>

                            </div>
                        </div>


                        <div class="tab-pane fade" id="floor2" role="tabpanel" aria-labelledby="floor2-tab">
                            <div class="row">


                                <?php
                                    $sql="SELECT * FROM MESA WHERE ESTADO = 'Activa';";
                                    $result = mysqli_query($conection,$sql);
                                    while ($row=mysqli_fetch_assoc($result)) {
                                    ?>
       
                                <!-- Mesa -->
                                <!-- Dependiendo del tipo de usuario que le de click, abrira un modal u otro -->
                                <?php if($row_user['Tipo_Usuario'] ==  'Gerente')
                                    {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#editarmesa"style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" data-toggle="modal" data-target="#editarmesa" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        }
                                ?>
                                
                                <?php 
                                    }
                                    else{


                                       if($row_user['Tipo_Usuario'] ==  'Mesero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#activar_mesa"style="width: 14rem; text-align: center;" onclick="Mesa_activar(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero

                                        if($row_user['Tipo_Usuario'] ==  'Cajero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                        if($row_user['Tipo_Usuario'] ==  'Cocinero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" >
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                    }
                                ?>

                                    <div class="card-header"><?php echo $row['Estado']; ?></div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="card-title">Mesa <?php echo $row['ID_Mesa']; ?></h5>
                                                </div>
                                                <div class="col-6 d-flex">
                                                    <!--<span class="fas fa-bed fa-3x m-auto"></span>-->
                                                    <img src="https://img.icons8.com/ios-filled/50/000000/table.png"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            <?php }?>

                            </div>
                        </div>


                        <div class="tab-pane fade" id="floor3" role="tabpanel" aria-labelledby="floor3-tab">
                            <div class="row">


                                <?php
                                    $sql="SELECT * FROM MESA WHERE ESTADO = 'Pedido activo';";
                                    $result = mysqli_query($conection,$sql);
                                    while ($row=mysqli_fetch_assoc($result)) {
                                    ?>
       
                                <!-- Mesa -->
                                <!-- Dependiendo del tipo de usuario que le de click, abrira un modal u otro -->
                                <?php if($row_user['Tipo_Usuario'] ==  'Gerente')
                                    {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#editarmesa"style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" data-toggle="modal" data-target="#editarmesa" style="width: 14rem; text-align: center;" onclick="Mesa(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        }
                                ?>
                                
                                <?php 
                                    }
                                    else{


                                       if($row_user['Tipo_Usuario'] ==  'Mesero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" data-toggle="modal" data-target="#activar_mesa"style="width: 14rem; text-align: center;" onclick="Mesa_activar(<?php echo $row['ID_Mesa'];?> , '<?php echo $row['Estado'];?>')">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero

                                        if($row_user['Tipo_Usuario'] ==  'Cajero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;" onclick="window.location.href='mesas_activas.php?user=<?php echo $id;?>&mesa=<?php echo $row['ID_Mesa'];?>'">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                        if($row_user['Tipo_Usuario'] ==  'Cocinero')
                                        {
                                        $estado = $row['Estado'];
                                        switch ($estado) {
                                            case 'Activa':
                                              ?>
                                                <div type="button" class="card text-white bg-success m-3" style="width: 14rem; text-align: center;" >
                                            <?php
                                                break;
                                            case 'Pedido activo':
                                             ?>
                                                
                                                <div type="button" class="card text-white bg-warning m-3" style="width: 14rem; text-align: center;">
                                                
                                            <?php
                                                break;
                                            case 'Disponible':
                                            ?>
                                                
                                                <div type="button" class="card text-white bg-info m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                break;
                                            case 'No disponible':
                                            ?>
                                                <div type="button" class="card text-gray bg-light m-3" style="width: 14rem; text-align: center;">
                                            <?php
                                                
                                                break;        
                                            default:   
                                                break;
                                        } //Cierra Switch mesero
                                        } //Cierra if mesero


                                    }
                                ?>

                                    <div class="card-header"><?php echo $row['Estado']; ?></div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="card-title">Mesa <?php echo $row['ID_Mesa']; ?></h5>
                                                </div>
                                                <div class="col-6 d-flex">
                                                    <!--<span class="fas fa-bed fa-3x m-auto"></span>-->
                                                    <img src="https://img.icons8.com/ios-filled/50/000000/table.png"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            <?php }?>

                            </div>
                        </div>
                    </div>
                </div>
                      
                    <?php if($row_user['Tipo_Usuario'] ==  'Gerente'){?>
                <div class="row rounded-bottom" id="rooms-footer">
                    <div class="container-fluid d-flex">
                       <button type="button" class="btn btn-custom m-auto" data-toggle="modal" data-target="#agregarmesa">Agregar mesa</button> 
                    </div>
                </div>
                    <?php }?>

            </div>
            
            <!-- Modal Agregar mesa  -->
            <div class="modal fade" id="agregarmesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    
                    <div class="modal-header">
                    <h5 class="modal-title">Agregar Mesas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
               
                    

                    <div class="modal-body">
                        <div class="row pl-3">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputRoomNumber" class="col-sm-6 col-form-label">Cantidad</label>
                                    <div class="col-sm-6">
                                        <input type="number"  min="1" class="form-control" name="cantidad_de_mesas" placeholder="Numero" value="1">
                                    </div>
                                </div>  
                            </div>
                            <div class="col-6 d-flex ml-auto">
                                 <img src="https://img.icons8.com/ios-filled/50/000000/table.png"/>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="agregar_mesa" class="btn btn-custom">Agregar</button>
                    </div>

                    </form>
                </div>
                </div>
            </div>
            <!-- Modal Agregar mesa END-->
            
            <!-- Modal Editar Mesa -->
            
            <div class="modal fade" id="editarmesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header center">
                    <h5 class="modal-title" id="editRoomLabel"><div id="eMesa"></div>
                    	
                    </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" id="editMesa" name="Id_Mesa_Edit">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#EliminarMesa">Eliminar</button>
                        <button type="submit" name="modificar_mesa" class="btn btn-custom">Dar de Baja/Alta</button>
                        <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
                        
                    </div>

                    </form>
                </div>
                </div>
            </div>
            <!-- Modal Editar Mesa END-->

            <!-- Modal Activar Mesa -->
            

            <div class="modal fade" id="activar_mesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <input type="hidden" name="USER_ID" value="<?php echo $row_user['ID_Usuario'];?>">
                    <div class="modal-header center">
                    <h5 class="modal-title" id="editRoomLabel"><div id="PMesa"></div></h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" id="activarMesa" name="Id_Mesa" style="border:0;" readonly="readonly">
                        <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
                        <button type="submit" name="activar_mesa" class="btn btn-custom">Activar</button>
                    </div>

                    </form>
                </div>
                </div>
            </div>
            <!-- Modal Editar Mesa END-->


            <!-- Modal Eliminar Mesa -->
    <div class="modal fade" id="EliminarMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Desea Eliminar Mesa
                        <input type="text" id="Delete_ID" name="ID_Delete" style="border:0;" readonly="readonly"> ?
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_mesa" class="btn btn-danger">Si</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Delete Mesa END -->
            
        </div>
        <!-- Main Col END -->

    </div>

</body>
</html>