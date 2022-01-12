<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();
 $id = $_GET['user'];


 $sql="SELECT * FROM USUARIO WHERE ID_USUARIO = $id ";
 $result = mysqli_query($conection,$sql);
 $row_user = mysqli_fetch_assoc($result);
 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	  
	  <script type="text/javascript">

	  </script>

	  <style type="text/css">
	  	.button:hover{
     transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}	
.myContMenu
        {
           width: 250px; 
        }
        .myBtnMenu
        {
            background-color: gray;
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

	<?php include("menu_top.php") ?>

	<?php if($row_user['Tipo_Usuario']!= 'NULL'){include("menu_side.php");} ?>
	<!-- MAIN -->
	<div class="container x">
			<div class="col py-3" style="background-color: #dee3e1;">
                <center><font size="10"><p>Bienvenido </p><?php if($row_user['Tipo_Usuario'] ==  'NULL'){ echo "Su mesa asignada es la número ".$row_pedido['ID_Mesa'];}?></font></center>
            
                <div class="row">
        <?php if($row_user['Tipo_Usuario'] ==  'Gerente'){ ?>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1 " onclick="window.location.href='registros.php?user=<?php echo $id;?>'"
                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/registros.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Registros</h4>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if( $row_user['Tipo_Usuario'] !=  'NULL'){?>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
                    onclick="window.location.href='restaurante.php?user=<?php echo $id;?>'" style="border-radius: 15px; ">
                        <img src="../images/restaurante.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Restaurante</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='utilidades.php?user=<?php echo $id;?>'"
                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/utilidades.png" class="myImg" >
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Utilidades</h4>
                </div>
            </div>
        </div>
        <?php }?>

        <?php if( $row_user['Tipo_Usuario'] ==  'NULL'){?>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
                    onclick="window.location.href='restaurante.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>'" style="border-radius: 15px; ">
                        <img src="../images/restaurante.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Restaurante</h4>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if($row_user['Tipo_Usuario'] ==  'Gerente'){ ?>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='comentarios.php?user=<?php echo $id;?>'"
                     class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/comentarios.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Reseñas</h4>
                </div>
            </div>
        </div>
        <?php }?>

        <?php if($row_user['Tipo_Usuario'] ==  'NULL'){ ?>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='comentarios.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>'"
                     class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/comentarios.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Reseñas</h4>
                </div>
            </div>
        </div>
        <?php }?>

    </div>
</div>
</div>

</body>
</html>