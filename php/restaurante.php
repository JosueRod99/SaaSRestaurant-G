<!DOCTYPE html>
<html>
<head>
	<title></title>
		  <style type="text/css">
	  	.card:hover{
     			transform: scale(1.05);
  				box-shadow: 0 10px 20px 
  				rgba(0,0,0,.12), 0 4px 8px 
  				rgba(0,0,0,.06);
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
	<div class="container x">
			<div class="col py-3" style="background-color: #dee3e1;">
                <center><font size="10"><p>Restaurante</p></font></center>
				<div class="row justify-content-center">
                <?php if($row_user['Tipo_Usuario']!= 'NULL'){?>
                
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1 " onclick="window.location.href='mesas.php?user=<?php echo $id;?>'"
			                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
			                        <img src="../images/mesas.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Mesas</h4>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
			                    onclick="window.location.href='pedidos_activos.php?user=<?php echo $id;?>'" style="border-radius: 15px; ">
			                        <img src="../images/pedidos_activos.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Pedidos Activos</h4>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" onclick="window.location.href='menu_restaurante.php?user=<?php echo $id;?>'"
			                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
			                        <img src="../images/menu.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Menu</h4>
			                </div>
			            </div>
			        </div>
			    	<?php }?>
			        

			        <?php if($row_user['Tipo_Usuario']== 'NULL'){?>

			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
			                    onclick="window.location.href='pedidos_activos_u.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>'" style="border-radius: 15px; ">
			                        <img src="../images/pedidos_activos.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Pedidos Activos</h4>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" onclick="window.location.href='mesas_activas_u.php?user=<?php echo $id;?>&cliente=<?php echo $id_cliente;?>&mesa=<?php echo $row_pedido['ID_Mesa'];?>'"
			                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
			                        <img src="../images/menu.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Menu</h4>
			                </div>
			            </div>
			        </div>
			    	<?php }?>
			        
			    </div>
            
        </div>
       </div>

</body>
</html>