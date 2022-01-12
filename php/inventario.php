<?php
 require_once('conexion.php');
 $conn=new Conexion();
 $conection = $conn->conectarse();


//Agregar inventario
if(isset($_POST['agregar_item']))
 {
  	$nombre = $_POST['nombre'];
  	$categoria = $_POST['categoria'];
  	$unidad = $_POST['unidad'];
  	$caducidad = $_POST['caducidad'];
  	$minimo = $_POST['minimo'];
  	$disponible = $_POST['disponible'];
  	$precio = $_POST['precio'];


  	$sql = "INSERT INTO INVENTARIO (NOMBRE, CATEGORIA, UNIDAD, PRECIO_ORIGINAL, RANGO_MIN, CANTIDAD_DISPONIBLE, FECHA_CADUCIDAD) VALUES ('$nombre', '$categoria', '$unidad', $precio, $minimo, $disponible, '$caducidad'); "; 

 	$result = mysqli_query($conection,$sql);
 	

 }

 //Editar inventario
if(isset($_POST['editar_item']))
 {
  	
  	$id = $_POST['id_item'];
  	$nombre = $_POST['nombre'];
  	$categoria = $_POST['categoria'];
  	$unidad = $_POST['unidad'];
  	$caducidad = $_POST['caducidad'];
  	$minimo = $_POST['minimo'];
  	$disponible = $_POST['disponible'];
  	$precio = $_POST['precio'];
  	$registro = getdate();
  	$registro_date = $registro['year']."-".$registro['mon']."-".$registro['mday'];
  	
  	//aqui comparar fechas para que no pueda ser menor xd
  	$sql = "UPDATE INVENTARIO SET NOMBRE = '$nombre', CATEGORIA = '$categoria', UNIDAD = '$unidad', PRECIO_ORIGINAL = $precio, RANGO_MIN = $minimo, CANTIDAD_DISPONIBLE = $disponible, FECHA_CADUCIDAD = '$caducidad' , FECHA_REGISTRO = '$registro_date' WHERE ID_ITEM = $id;";
  	
 	$result = mysqli_query($conection,$sql);
 	
 }

  //Eliminar inventario
if(isset($_POST['eliminar_item']))
 {
  	
  	$id = $_POST['ID_Delete'];
  	
  	$sql = "DELETE FROM INVENTARIO WHERE ID_ITEM = $id";
  	
 	$result = mysqli_query($conection,$sql);
 	
 }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		del_item = function(ID)
        {
        	$('#Delete_ID').val(ID);
        	$('#Delete_html').html('¿Eliminar inventario '+ID+'?'); 
        }

  	
        edit_item = function(ID, NAME, CAT, UNIT, PRICE, FEC_REC, FEC_CAD, MIN, AVAI)
        {
        	
        	$('#NOMBRE_ITEM').val(NAME);
        	$('#CAT_'+CAT).attr("checked", true);
        	$('#UNIDAD_'+UNIT).attr("checked", true);
        	$('#PRECIO_ITEM').val(PRICE);
        	$('#CADUCIDAD_ITEM').val(FEC_CAD);
        	$('#MINIMO_ITEM').val(MIN);
        	$('#DISPONIBLE_ITEM').val(AVAI);
        	$('#ID_ITEM').val(ID);
        	
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
	   	 		<th colspan="10"><b>Inventario</b></th>
	  			</tr>
	  		</thead>
	  	<thead class="thead-light">
	    <tr>
	      <th class="top">Nombre</th>
	      <th class="top">Categoría</th>
	      <th class="top">Unidad</th>
	      <th class="top" title="Precio al que este insumo está en el mercado por unidad de medida.">Precio</th>
	      <th class="top">Fecha Registro</th>
	      <th class="top">Fecha Caducidad</th>
	      <th class="top" title="Al llegar a esta cantidad, el sistema alertará que se está quedando sin suministros.">Rango Mínimo</th>
	      <th class="top">Cantidad Disponible</th>
	      <th class="top">Editar</th>
	      <th class="top">Eliminar</th>
	    </tr>
	  	</thead>
	  <?php 
  		//ID_USUARIO, TIPO_USUARIO, NOMBRE, APELLIDO_P, CREDENCIAL_USUARIO, CREDENCIAL_PASSWORD, TELEFONO, SALARIO
  		$sql = "SELECT * FROM INVENTARIO ORDER BY CATEGORIA;";

  		$result=mysqli_query($conection, $sql);
  
	    while ($row=mysqli_fetch_assoc($result)){ 
	      ?>
	      	
	        <tr style="height: 32.12px;"> 
	          </td>
	          <td ><?php echo $row['Nombre']; ?></td>
	          <td ><?php echo $row['Categoria']; ?></td>
	          <td ><?php echo $row['Unidad']; ?></td>
	          <td >$ <?php echo $row['Precio_Original']; ?></td>
	          <td ><?php echo $row['Fecha_Registro']; ?></td>
	          <td ><?php echo $row['Fecha_Caducidad']; ?></td>
	          <td title="Al llegar a esta cantidad, el sistema alertará que se está quedando sin suministros."><?php echo $row['Rango_min']; ?></td>
	          <td ><?php echo $row['Cantidad_disponible']; ?></td>
	          <td><span type="button" class="btn fas fa-edit" data-toggle="modal" data-target="#Editar" onclick="edit_item(<?php echo $row['ID_Item']; ?>,'<?php echo $row['Nombre']; ?>','<?php echo $row['Categoria']; ?>','<?php echo $row['Unidad']; ?>',<?php echo $row['Precio_Original']; ?>,'<?php echo $row['Fecha_Registro']; ?>','<?php echo $row['Fecha_Caducidad']; ?>',<?php echo $row['Rango_min']; ?>,<?php echo $row['Cantidad_disponible']; ?>)"></span></td>
              <td><span type="button" class="btn fas fa-trash-alt" data-toggle="modal" data-target="#Eliminar" onclick="del_item(<?php echo $row['ID_Item']; ?>)"></span></td>
	        </tr> 
	      <?php 
	    }
	    mysqli_free_result($result);
	    //mysqli_close($conection);

	  ?>
	</table>

	<div class="row rounded-bottom" >
                    <div class="container-fluid d-flex">
                       <button type="button" class="btn btn-custom m-auto" data-toggle="modal" data-target="#agregar">Agregar Inventario</button> 
                    </div>
    </div>

   

    <!-- Modal Add Item -->
    <form action="inventario.php?user=<?php echo $id;?>" method="post">
    	<div class="modal fade" id="agregar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
			
            <div class="modal-header">
            
                    <h5 class="modal-title">Agregar Inventario</h5>
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
					       <input type="text" class="form-control" name="nombre" required="" style="text-align: center;" placeholder="Ingrese el nombre">
					    </div>
					</div>
					

	                <label for="editRoomType" >Pertenece a</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Alimento">
						  <label class="form-check-label" for="inlineRadio1">Alimento</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="categoria" value="Bebida">
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
					<label for="editRoomType">Unidad</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="unidad" value="Gramos">
						  <label class="form-check-label" for="inlineRadio1">Gramos</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="unidad" value="Pieza">
						  <label class="form-check-label" for="inlineRadio2">Pieza</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required="" name="unidad" value="Otro"> 
						  <label class="form-check-label" for="inlineRadio3">Otro</label>
					</div>
               
               	<br>
	                <div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Precio</label>
					      <input type="text" class="form-control" required="" name="precio" placeholder="Precio por unidad" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Fecha Caducidad</label>
					      <input type="date" class="form-control" required="" name="caducidad" placeholder="Caducidad" style="text-align: center;">
					    </div>
					</div>

					<div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="inputEmail4">Rango Mínimo</label>
					      <input type="text" class="form-control" required="" name="minimo" placeholder="Rango mínimo disponible" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Cantidad Disponible</label>
					      <input type="text" class="form-control" required="" name="disponible" placeholder="Cantidad disponible" style="text-align: center;">
					    </div>
					</div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="agregar_item" class="btn btn-custom">Agregar</button>
            </div>

            
        </div></div>
        </div>
    </div>
</form>
    <!-- Modal Add Item END -->

    <!-- Modal Eliminar Item -->
    <div class="modal fade" id="Eliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
           <form action="inventario.php?user=<?php echo $id;?>" method="post">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><div id="Delete_html"></div></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                	Al eliminar este item del inventario, también eliminará todos los productos del menú en donde se encuentre involucrado.
                	
					      
					
                	
                </div>
                <div class="modal-footer">
                	<input type="hidden" id="Delete_ID" name="ID_Delete" >
                    <button type="button" class="btn btn-custom" data-dismiss="modal">No</button>
                    <button type="submit" name="eliminar_item" class="btn btn-danger">Si</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Delete Item END -->

    <!-- Modal Edit Item -->
    <div class="modal fade" id="Editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
			<form action="inventario.php?user=<?php echo $id;?>" method="post">
            <div class="modal-header">
            
                    <h5 class="modal-title">Editar Inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>


            <div class="modal-body">
              <div class="container" style="text-align: center;">
              
					<div class="form-row">
					    <div class="form-group col-md-3">
					    	<label for="inputPassword4">Id</label>
					       <input type="text"  class="form-control" id="ID_ITEM" name="id_item" style="border:0; text-align: center;" readonly="readonly" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-9">
					      <label for="inputPassword4">Nombre</label>
					       <input type="text" class="form-control" required id="NOMBRE_ITEM" required="" name="nombre" style="text-align: center;" placeholder="Ingrese el nombre">
					    </div>
					</div>
					

	                <label for="editRoomType" >Pertenece a</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio"  required="" id="CAT_Alimento" name="categoria" value="Alimento">
						  <label class="form-check-label" for="inlineRadio1">Alimento</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="CAT_Bebida" required="" name="categoria" value="Bebida">
						  <label class="form-check-label" for="inlineRadio2">Bebida</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="CAT_Entrada" required="" name="categoria" value="Entrada"> 
						  <label class="form-check-label" for="inlineRadio3">Entrada</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="CAT_Postre" required="" name="categoria" value="Postre" >
						  <label class="form-check-label" for="inlineRadio4">Postre</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="CAT_Extra" required="" name="categoria" value="Extra"> 
						  <label class="form-check-label" for="inlineRadio5">Extra</label>
					</div>

					<br><br>
					<label for="editRoomType">Unidad</label> <br>
	                <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="UNIDAD_Gramos" required="" name="unidad" value="Gramos">
						  <label class="form-check-label" for="inlineRadio1">Gramos</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="UNIDAD_Pieza" required="" name="unidad" value="Pieza">
						  <label class="form-check-label" for="inlineRadio2">Pieza</label>
					</div>
					<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" required id="UNIDAD_Otro" required="" id="UNIDAD_ITEM" name="unidad" value="Otro"> 
						  <label class="form-check-label" for="inlineRadio3">Otro</label>
					</div>
               <div>
               	<br>
	                <div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Precio</label>
					      <input type="text" class="form-control" required id="PRECIO_ITEM" required="" name="precio" placeholder="Precio por unidad" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Fecha Caducidad</label>
					      <input type="date" class="form-control" required id="CADUCIDAD_ITEM" required="" name="caducidad" placeholder="Caducidad" style="text-align: center;">
					    </div>
					</div>

					<div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="inputEmail4">Rango Mínimo</label>
					      <input type="text" class="form-control" required id="MINIMO_ITEM" required="" name="minimo" placeholder="Rango mínimo disponible" style="text-align: center;">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPassword4">Cantidad Disponible</label>
					      <input type="text" class="form-control" required id="DISPONIBLE_ITEM" required="" name="disponible" placeholder="Cantidad disponible" style="text-align: center;">
					    </div>
					</div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="editar_item"class="btn btn-custom">Editar</button>
            </div>

            </form>
        </div></div>
        </div>
    </div>
    <!-- Modal Edit Item END -->


</body>
</html>