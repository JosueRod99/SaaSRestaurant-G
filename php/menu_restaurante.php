<!DOCTYPE html>
<html>
<head>
	<title></title>
		  <style type="text/css">
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
	<?php include("menu_side.php") ?>
	

	<div class="container ">
			<div class="col py-3" style="background-color: #dee3e1;">
                <center><font size="10"><p>Menú</p></font></center>

                <div class="row">
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1 " onclick="window.location.href='menu_restaurante_productos.php?user=<?php echo $id;?>&item=Bebida'"
                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/bebidas.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Bebidas</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
                    onclick="window.location.href='menu_restaurante_productos.php?user=<?php echo $id;?>&item=Entrada'" style="border-radius: 15px; ">
                        <img src="../images/dedotes.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Entradas</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='menu_restaurante_productos.php?user=<?php echo $id;?>&item=Alimento'"
                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/alimentos.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Alimentos</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='menu_restaurante_productos.php?user=<?php echo $id;?>&item=Postre'"
                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/postres.png" class="myImg" >
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Postres</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-4 d-flex justify-content-center">
            <div class="container myContMenu">
                <div class="row d-flex justify-content-center">
                    <button type="button m-1" onclick="window.location.href='menu_restaurante_productos.php?user=<?php echo $id;?>&item=Extra'"
                     class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
                        <img src="../images/extras.png" class="myImg">
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <h4>Extras</h4>
                </div>
            </div>
        </div>
    </div>
            
        </div>
       </div>
</body>
</html>