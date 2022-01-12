<?php
require_once('conexion.php');
$conn=new Conexion();
$conection = $conn->conectarse();

$tipo = $_GET['item'];


// Agregar item al menu 
if(isset($_POST['agregar_menu']))
 {
  	
	$nombre = $_POST['Nombre'];
	$precio = $_POST['Precio_publico'];
	$Max_menu = 0;
	$porcion = 0;

  	$sql="SELECT MAX(ID_ITEM_MENU) as Max_menu from Menu;";
 	$result = mysqli_query($conection,$sql);
 	$row=mysqli_fetch_assoc($result);
 	
 	if(is_null($row['Max_menu'])){$Max_menu = 0;}
 		else{$Max_menu = $row['Max_menu'] + 1; }

 	mysqli_free_result($result);


	if(!empty($_POST['lista_origen'])&&!empty($_POST['lista_porcion']))
	{
		$i=0;
		foreach($_POST['lista_origen'] as $selected)
		{	$porcion = $_POST['lista_porcion'][$i];

			$sql="INSERT INTO MENU (ID_ITEM_MENU, NOMBRE, ORIGEN, PORCION, PRECIO_PUBLICO) VALUES ($Max_menu, '$nombre', $selected, $porcion , $precio);";
 			$result = mysqli_query($conection,$sql);
			$i++;
			$porcion = 0;

		}
	}
 }

 // Agregar ingrediente al item 
if(isset($_POST['agregar_ingrediente']))
 {
  	
	$nombre = $_POST['Nombre'];
	$precio = $_POST['Precio_publico'];
	$Max_menu = $_POST['id_add'];
	$porcion = 0;
	$Array_identificadores = array();

	$sql="SELECT INVENTARIO.ID_ITEM FROM INVENTARIO, MENU WHERE ID_ITEM_MENU = $Max_menu AND INVENTARIO.ID_ITEM = MENU.ORIGEN AND CATEGORIA = '$tipo';";
	$result = mysqli_query($conection,$sql);

	while ($row=mysqli_fetch_assoc($result))
		{ 
			array_push($Array_identificadores, intval($row['ID_ITEM']));
			
		}
	
	

	if(!empty($_POST['lista_origen_add'])&&!empty($_POST['lista_porcion_add']))
	{
		$i=0;
		foreach($_POST['lista_origen_add'] as $selected)
		{	$porcion = $_POST['lista_porcion_add'][$i];

			if(in_array($selected, $Array_identificadores))
				{
					$sql = "UPDATE MENU SET PORCION = $porcion WHERE ID_ITEM_MENU = $Max_menu AND ORIGEN = $selected;";
					$result = mysqli_query($conection,$sql);
					$i++;
				}
			else
			{
			$sql="INSERT INTO MENU (ID_ITEM_MENU, NOMBRE, ORIGEN, PORCION, PRECIO_PUBLICO) VALUES ($Max_menu, '$nombre', $selected, $porcion , $precio);";
 			$result = mysqli_query($conection,$sql);
			$i++;
			$porcion = 0;
			}
			

		}
	}

	$sql = "UPDATE MENU SET PRECIO_PUBLICO = $precio WHERE ID_ITEM_MENU = $Max_menu";
	$result = mysqli_query($conection,$sql);

 }

   //Eliminar item menu
if(isset($_POST['eliminar_item']))
 {
  	
  	$id = $_POST['ID_Delete'];
  	$id_origen = $_POST['ID_Delete_item'];
  	
  	$sql = "DELETE FROM MENU WHERE ID_ITEM_MENU = $id AND ORIGEN = $id_origen";
 	$result = mysqli_query($conection,$sql);
 	
 }

 //Editar item menu 
 if(isset($_POST['editar_item']))
 {
 	$id = $_POST['ID_Edit'];
  	$id_origen = $_POST['ID_Edit_item'];
  	$porcion = $_POST['porcion_edit'];
  	$sql = "UPDATE MENU SET PORCION = $porcion WHERE ID_ITEM_MENU = $id AND ORIGEN = $id_origen";
  	$result = mysqli_query($conection,$sql);
 }


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		 div.Ingredientes {
                margin:5px;
                padding:5px;
                width: 500px;
                height: 110px;
                overflow: auto;
                text-align:justify;
            }
	</style>
	<script type="text/javascript">
	  	function Activar_porcion(k)
	  	{
   			var checkbox = document.getElementById("Origen_"+k);
   			var input = document.getElementById("Porcion_"+k);
		   if(checkbox.checked)
		   {
		   	  input.disabled=false;   	  
		   }
		    else
		   {
		   	  input.value="NULL";
		      input.disabled=true;
		   }
			
		}

		function Activar_porcion_add(k)
	  	{
   			var checkbox = document.getElementById("Origen_add_"+k);
   			var input = document.getElementById("Porcion_add_"+k);
		   if(checkbox.checked)
		   {
		   	  input.disabled=false;   	  
		   }
		    else
		   {
		   	  input.value="NULL";
		      input.disabled=true;
		   }
			
		}

		del_item = function(ID,ORIGEN,NAME,ITEM_NAME )
        {
        	$('#Delete_ID_menu').val(ID);
        	$('#Delete_ID_item').val(ORIGEN);
        	$('#Nombre_Del').html('¿Eliminar el ingrediente -'+ITEM_NAME+'- de '+NAME+'?');

        }
        edit_item = function(ID,ORIGEN,NAME,ITEM_NAME,PORTION,UNIT)
        {
        	
        	$('#Edit_ID_menu').val(ID);
        	$('#Edit_ID_item').val(ORIGEN);
        	$('#Nombre_Edit').html('¿Editar el ingrediente -'+ITEM_NAME+'- de '+NAME+'?');
        	$('#Porcion_Edit').val(PORTION);

        }

        add_item = function(ID, PRICE, NAME)
        {
        	$('#ID_add').val(ID);
        	$('#Precio_Pub').val(PRICE);
        	$('#Nombre_add').val(NAME);
        	
        	
        }

	  </script>
</head>
<body>
	<?php include("menu_top.php") ?>
	<?php include("menu_side.php") ?>
	
	<div class="col py-3" style="background-color: #dee3e1;">
	<div  class="container">


		<table class="table table-hover" style="text-align: center;">
       		<thead class="thead-dark">
	  			<tr>
	   	 		<th colspan="10"><b>Registro de <?php echo $tipo;?> en el Menú</b></th>
	  			</tr>
	  		</thead>
	  	<thead class="thead-light">
	    <tr>
	      <th class="top">Nombre</th>
	      <th class="top" title="Este registro esta compuesto de los siguientes productos.">Ingredientes</th>
	      <th class="top">Precio Original</th>
	      <th class="top">Precio Público</th>
	      <?php if($row_user['Tipo_Usuario'] ==  'Gerente'){?>
	      <th class="top">Editar</th>
	      <th class="top">Eliminar</th>
	  		<?php }?>
	    </tr>
	  	</thead>
	  <?php 
	  	$Flag_first = True;
  		$temp = 0;
  		$precio = 0;
  		$nombre='';
  		$Flag_first_p = True;

  		$temp_p = 0;
  		$Flag_global = False;
  		$sql = "SELECT MENU.ID_ITEM_MENU, MENU.NOMBRE as NOMBRE_MENU, MENU.PORCION, INVENTARIO.UNIDAD, INVENTARIO.ID_ITEM, INVENTARIO.NOMBRE AS INVENTARIO_NOMBRE, INVENTARIO.PRECIO_ORIGINAL, MENU.PRECIO_PUBLICO, INVENTARIO.CATEGORIA, MENU.ORIGEN FROM MENU, INVENTARIO WHERE MENU.ORIGEN = INVENTARIO.ID_ITEM AND INVENTARIO.CATEGORIA = '$tipo' ORDER BY MENU.ID_ITEM_MENU ASC;";
  		
		$result = mysqli_query($conection,$sql);
	    while ($row=mysqli_fetch_assoc($result)){ 
	      	if($temp != $row['ID_ITEM_MENU'])
	      	{
	      		$Flag_first = True;
	      		$Flag_first_p = True;
	      	
	      	if($Flag_global){
	      	if($row_user['Tipo_Usuario'] ==  'Gerente'){?>
	      	<tr>
	     		<td colspan="6" style="text-align: right; border-bottom: solid 1px;"> Agregar ingrediente <span type="button" class="btn fas fa-plus" data-toggle="modal" data-target="#Add_item_menu" onclick="add_item(<?php echo $temp;?>,<?php echo $precio;?>,'<?php echo $nombre;?>')"></span>
	     		</td>
		  	</tr>

	      	<?php
	      	}
	      	
	      }
	      }
	      ?>
	      	
	        <tr style="height: 32.12px;"> 
	          
	          <?php if($Flag_first)
	          {?>
	          	<td><?php echo $row['NOMBRE_MENU']; ?></td>
	          <?php
	          	$Flag_first = False;
	          	$temp = $row['ID_ITEM_MENU'];
	          	$precio = $row['PRECIO_PUBLICO'];
	          	$nombre = $row['NOMBRE_MENU'];
	          } 
	          elseif(!$Flag_first)
	          {?>
	          	<td></td>
	          <?php }
	          ?>
	          
	          <td ><?php echo $row['PORCION']." ".$row['UNIDAD'].", ".$row['INVENTARIO_NOMBRE']."."; ?></td>
	          <td >$ <?php echo $row['PRECIO_ORIGINAL']; ?></td>

	          <?php if($Flag_first_p)
	          {?>
	          	<td ><?php echo "$ ".$row['PRECIO_PUBLICO']; ?></td>
	          <?php
	          	$Flag_first_p = False;
	          	$Flag_empty = True;
	          } 
	          elseif(!$Flag_first_p)
	          {?>
	          	<td></td>
	          <?php }
	           if($row_user['Tipo_Usuario'] ==  'Gerente'){?>
	          <td>
	          	<span type="button" class="btn fas fa-edit" data-toggle="modal" data-target="#Editar" onclick="edit_item(<?php echo $row['ID_ITEM_MENU'].",".$row['ORIGEN']; ?>,'<?php echo $row['NOMBRE_MENU']; ?>','<?php echo $row['INVENTARIO_NOMBRE']; ?>',<?php echo $row['PORCION'];?>,'<?php echo $row['UNIDAD'];?>')"></span>
	          </td>
              <td>
              	<span type="button" class="btn fas fa-trash-alt" data-toggle="modal" data-target="#Eliminar" onclick="del_item(<?php echo $row['ID_ITEM_MENU'].",".$row['ORIGEN']; ?>,'<?php echo $row['NOMBRE_MENU']; ?>','<?php echo $row['INVENTARIO_NOMBRE']; ?>')"></span>
              </td>
	        </tr>

	      <?php
	       $Flag_global = True;
	    }}
		//mysqli_free_result($result);
	    //mysqli_close($conection);

	  ?>
	  <?php

			
	  if($row_user['Tipo_Usuario'] ==  'Gerente' and mysqli_num_rows($result) != 0 ){?>
	  <tr>
	     		<td colspan="6" style="text-align: right; border-bottom: solid 1px;"> Agregar ingrediente <span type="button" class="btn fas fa-plus" data-toggle="modal" data-target="#Add_item_menu" onclick="add_item(<?php echo $temp;?>,<?php echo $precio;?>,'<?php echo $nombre;?>')"></span>
	     		</td>
		</tr>
	<?php }
	?>
	</table>
	<?php if($row_user['Tipo_Usuario'] ==  'Gerente'){?>
	<div style="display: flex; align-items: center; justify-content: center;">
		<div class="row " >
	                    <div class="container-fluid d-flex ">
	                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Agregar producto al Menú</button>
	                    </div>
	    </div>
	</div>
	<?php }?>






    </div>
</div>


<!-- Modal Add Item -->
    <form action="menu_restaurante_productos.php?user=<?php echo $id;?>&item=<?php echo $tipo;?>" method="post">
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  			

    <div class="modal-content ">
      	<div class="modal-header">
            <h5 class="modal-title">Agregar producto al menú</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


        <div class="modal-body">
              <div class="container" style="text-align: center;">
              
					<div class="form-row">
					    <div class="form-group col-md-3">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Nombre</label>
					       <input type="text" class="form-control" name="Nombre" required="" style="text-align: center;" placeholder="Ingrese el nombre">
					    </div>
					</div>
					

	                <label for="editRoomType" >Pertenece a</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Alimento" onclick="Categoria('Alimento')">
						  <label class="form-check-label" for="inlineRadio1">Alimento</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Bebida" >
						  <label class="form-check-label" for="inlineRadio2">Bebida</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Entrada"> 
						  <label class="form-check-label" for="inlineRadio3">Entrada</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Postre" >
						  <label class="form-check-label" for="inlineRadio4">Postre</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Extra"> 
						  <label class="form-check-label" for="inlineRadio5">Extra</label>
					</div>

					
               
               	<br><br>
               	

	                <div class="form-row">
	                	<div class="form-group col-md-2">
	                	</div>
					    <div class="form-group col-md-8">
					    	<div class="form-row">
							    <div class="form-group col-md-2">
							    </div>
							    <div class="form-group col-md-4">
							      <label for="inputPassword4">Ingrediente</label>  
							    </div>
							    <div class="form-group col-md-4">
							      <label for="inputPassword4">Porción</label>  
							    </div>
							</div>

					       <div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 200px; overflow-y: scroll;">
					       	<table >
					    			

					    	<?php


								$sql="SELECT * FROM INVENTARIO WHERE CATEGORIA = '$tipo' ORDER BY CATEGORIA; ";
						 		$result = mysqli_query($conection,$sql);
							    while ($row=mysqli_fetch_assoc($result)) {
							      ?><tr><td style="width: 61%">
						          	<input type="checkbox" name="lista_origen[]" id="Origen_<?php echo $row['ID_Item']; ?>" onclick="Activar_porcion(<?php echo $row['ID_Item']; ?>)" value="<?php echo $row['ID_Item']; ?>">&nbsp<?php echo $row['Nombre']; ?>
						          </td>
						          <td>
						          	<input type="number" name="lista_porcion[]" id="Porcion_<?php echo $row['ID_Item']; ?>" disabled="disabled" class="form-control form-control" style="text-align: center;" placeholder="Ingrese la porcion."> 
						          </td>
						          </tr>
						          <?php 
							    }
							    //mysqli_free_result($result);

							    //mysqli_close($conection);
							  	?>
							  </table>
							</div>

					       

					    </div>
					   
					</div>

					<div class="form-row">
					    <div class="form-group col-md-3">
					      
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Precio al Público</label>
					      <input type="text" class="form-control" required="" name="Precio_publico" placeholder="Ingrese el precio." style="text-align: center;">
					    </div>
					</div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="agregar_menu" class="btn btn-custom">Agregar</button>
            </div>


    </div>
  </div>
</div>
</form>
<!-- Modal Add Item END -->


<!-- Modal Add Item MENU-->
    <form action="menu_restaurante_productos.php?user=<?php echo $id;?>&item=<?php echo $tipo;?>" method="post">
<div class="modal fade bd-example-modal-lg" id="Add_item_menu" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  			

    <div class="modal-content ">
      	<div class="modal-header">
            <h5 class="modal-title">Agregar ingrediente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


        <div class="modal-body">
              <div class="container" style="text-align: center;">


	                <div class="form-row">
	                	<div class="form-group col-md-2">
	                	</div>
					    <div class="form-group col-md-8">
					    	<div class="form-row">
							    <div class="form-group col-md-2">
							    </div>
							    <div class="form-group col-md-4">
							      <label for="inputPassword4">Ingrediente</label>  
							    </div>
							    <div class="form-group col-md-4">
							      <label for="inputPassword4">Porción</label>  
							    </div>
							</div>
					       <div class="container data-mdb-perfect-scrollbar='true'" style="text-align: left; height: 200px; overflow-y: scroll;">
					       	<table >
					    		
					    	<?php
					    		
								$sql="SELECT * FROM INVENTARIO WHERE CATEGORIA = '$tipo' ORDER BY CATEGORIA; ";
								
						 		$result = mysqli_query($conection,$sql);
							    while ($row=mysqli_fetch_assoc($result)) {
							      ?><tr><td style="width: 61%">
						          	<input type="checkbox" name="lista_origen_add[]" id="Origen_add_<?php echo $row['ID_Item']; ?>" onclick="Activar_porcion_add(<?php echo $row['ID_Item']; ?>)" value="<?php echo $row['ID_Item']; ?>">&nbsp<?php echo $row['Nombre']; ?>
						          </td>
						          <td>
						          	<input type="number" name="lista_porcion_add[]" id="Porcion_add_<?php echo $row['ID_Item']; ?>" disabled="disabled" class="form-control form-control" style="text-align: center;" placeholder="Ingrese la porcion."> 
						          </td>
						          </tr>
						          <?php 
							    }
							    //mysqli_free_result($result);

							    //mysqli_close($conection);
							  	?>
							  </table>
							</div>

					       

					    </div>
					   
					</div>

					<div class="form-row">
					    <div class="form-group col-md-3">
					      
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Precio al Público</label>
					      <input type="text" class="form-control" required="" id="Precio_Pub" name="Precio_publico" placeholder="Ingrese el precio." style="text-align: center;">
					    </div>
					</div>
            	</div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="ID_add" name="id_add">
            	<input type="hidden" id="Nombre_add" name="Nombre">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="agregar_ingrediente" class="btn btn-custom">Agregar</button>
            </div>


    </div>
  </div>
</div>
</form>
<!-- Modal Add Item MENU END -->


<!-- Modal Eliminar Item -->
<form action="menu_restaurante_productos.php?user=<?php echo $id;?>&item=<?php echo $tipo;?>" method="post">
    <div class="modal fade" id="Eliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><div id="Nombre_Del"></div></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                	<input type="hidden" id="Delete_ID_menu" name="ID_Delete">
                	<input type="hidden" id="Delete_ID_item" name="ID_Delete_item">  
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_item" class="btn btn-danger">Eliminar</button>
                </div>
                </div>
           
        </div>
    </div> 
</div></div>
</form>
    <!-- Modal Delete Item END -->


<!-- Modal Editar Item -->
<form action="menu_restaurante_productos.php?user=<?php echo $id;?>&item=<?php echo $tipo;?>" method="post">
    <div class="modal fade" id="Editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><div id="Nombre_Edit"></div></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-row text-center">
                		<div class="form-group col-md-2"> 
					   
					    </div>
					    <div class="form-group col-md-4"> 
					    	<label>Porción</label>  
					    </div>
					    <div class="form-group col-md-5">
					     	<input type="number" name="porcion_edit" id="Porcion_Edit" class="form-control" style="text-align: center;" placeholder="Ingrese la porcion." required="required">
					    </div>
					</div>
                </div>
                <div class="modal-footer">
                	<input type="hidden" id="Edit_ID_menu" name="ID_Edit">
                	<input type="hidden" id="Edit_ID_item" name="ID_Edit_item">  
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="editar_item" class="btn btn-custom">Editar</button>
                </div>
                </div>
           
        </div>
    </div> 
</div></div>
    <!-- Modal Editar Item END -->

</form>
</body>
</html>