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
	<?php include("menu_side.php") ?>
	
	<div class="container x" >
			<div class="col py-3" style="background-color: #dee3e1;">
                <center><font size="10"><p>Registros</p></font></center>
				<div class="row justify-content-center">
                
                
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1 " onclick="window.location.href='personal.php?user=<?php echo $id;?>'"
			                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
			                        <img src="../images/personal.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Personal</h4>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" class="btn btn-primary myBtnMenu"  
			                    onclick="window.location.href='inventario.php?user=<?php echo $id;?>'" style="border-radius: 15px; ">
			                        <img src="../images/inventario.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex justify-content-center">
			                    <h4>Inventarios</h4>
			                </div>
			            </div>
			        </div>

			        <div class="col-md-3 m-4 d-flex justify-content-center">
			            <div class="container myContMenu">
			                <div class="row d-flex justify-content-center">
			                    <button type="button m-1" onclick="window.location.href='restinfo.php?user=<?php echo $id;?>'"
			                    class="btn btn-primary myBtnMenu" style="border-radius: 15px; ">
			                        <img src="../images/inforest.png" class="myImg">
			                    </button>
			                </div>
			                <div class="row d-flex text-center">
			                    <h4>Información del restaurante</h4>
			                </div>
			            </div>
			        </div>
			    </div>
            
        </div>
       </div>

	
</body>
</html>