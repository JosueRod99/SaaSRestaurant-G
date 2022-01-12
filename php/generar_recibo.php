<?php 
require_once('conexion.php');
$conn=new Conexion();
$conection = $conn->conectarse();
$id_pedido = $_GET['id'];

	require('../PDF/fpdf.php');

		class PDF extends FPDF
	{

	}


	

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);

	$pdf->Cell(60);

	$sql = "SELECT * FROM REST_INFO;";
	$result = mysqli_query($conection,$sql);
	while ($row=$result->fetch_assoc()) {
		$pdf->Cell(70,10,utf8_decode($row['Nombre']),0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60);
		$pdf->Cell(70,10,utf8_decode($row['Calle'])." ".utf8_decode($row['Numero']),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(60);
		$pdf->Cell(70,10,utf8_decode($row['Ciudad']).", ".utf8_decode($row['Estado']).", ".utf8_decode($row['Pais']),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(60);
		$pdf->Cell(70,10,utf8_decode("Teléfono: ").$row['Telefono'],0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(60);
		$pdf->Cell(70,10,utf8_decode("Correo: ").$row['Email'],0,0,'C');
	}


	$sql = "SELECT * FROM PEDIDO_MESA WHERE ID_PEDIDO = $id_pedido;";
	$result = mysqli_query($conection,$sql);
	while ($row=$result->fetch_assoc()) {

		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(50,10,"Fecha: ".$row['Fecha'],0,0,'C');
		$pdf->Cell(50,10,"Hora: ".$row['Hora'],0,0,'C');
		$pdf->Cell(50,10,"Mesa: ".$row['ID_Mesa'],0,0,'C');
		$pdf->Cell(50,10,"Orden: ".$row['Orden'],0,0,'C');


	}

	$pdf->SetFont('Arial','B',16);
	$pdf->Ln(10);
	$pdf->Cell(10,10,'ID',1,0,'C',0);
    $pdf->Cell(90,10,'Nombre',1,0,'C',0);
    $pdf->Cell(30,10,'Cantidad',1,0,'C',0);
	$pdf->Cell(30,10,'Precio',1,0,'C',0);
	$pdf->Cell(30,10,'Total',1,1,'C',0);

	$pdf->SetFont('Arial','',10);

	$sql= "SELECT * FROM PEDIDO WHERE ID_PEDIDO = $id_pedido;";
	$result = mysqli_query($conection,$sql);

	while ($row=$result->fetch_assoc()) {
		$pdf->Cell(10,10,$row['ID_Pedido_item'],1,0,'C',0);
	    $pdf->Cell(90,10,$row['Nombre_producto'],1,0,'C',0);
	    $pdf->Cell(30,10,$row['Cantidad'],1,0,'C',0);
		$pdf->Cell(30,10,"$ ".$row['Precio'],1,0,'C',0);
		$pdf->Cell(30,10,"$ ".$row['Total'],1,1,'C',0);

	} 
	$sql = "SELECT USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_CAJERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
	$result = mysqli_query($conection,$sql);
	while ($row=$result->fetch_assoc()) {
		$pdf->Cell(130,10,"Cajero: ".$row['NOMBRE']." ".$row['APELLIDO_P'],1,0,'C',0);
		$pdf->Cell(60,10,"Total",1,1,'C',0);
	}


	$sql = "SELECT PEDIDO_MESA.TOTAL, USUARIO.NOMBRE, USUARIO.APELLIDO_P FROM PEDIDO_MESA, USUARIO WHERE USUARIO.ID_USUARIO = PEDIDO_MESA.ID_USUARIO_MESERO AND PEDIDO_MESA.ID_PEDIDO = $id_pedido;";
	$result = mysqli_query($conection,$sql);
	while ($row=$result->fetch_assoc()) {
		$pdf->Cell(130,10,"Mesero: ".$row['NOMBRE']." ".$row['APELLIDO_P'],1,0,'C',0);
		$pdf->Cell(60,10,"$ ".$row['TOTAL'],1,0,'C',0);
	}

		

		$pdf->Output();
	/*Aqui TERMINA el codigo para el PDF*/
 
 
 ?>