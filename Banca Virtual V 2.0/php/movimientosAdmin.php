<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<title>nombre banco </title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body >
		<?php
//echo "Hola Mundo";
session_start();
if($_POST['choiceClient'])
$_SESSION['usuarioEdit'] = $_POST['choiceClient'];

$conexión = mysql_connect("localhost", "root", "1qa2w3ed");

if (!$conexión) {
    echo "No pudo conectarse a la BD: " . mysql_error();
    exit;
}

if (!mysql_select_db("proyecto")) {
    echo "No ha sido posible seleccionar la BD: " . mysql_error();
    exit;
}

$sql = "SELECT * from cuenta_cliente where idcliente=".$_SESSION['usuarioEdit'].";";

$resultado = mysql_query($sql);
	
if (!$resultado) {
    echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    exit;
}


// Mientras exista una fila de datos, colocar esa fila en $fila como un array asociativo
// Nota: Si solo espera una fila, no hay necesidad de usar un bucle
// Nota: Si coloca extract($fila); dentro del siguiente bucle,
//       estará creando $id_usuario, $nombre_completo, y $estatus_usuario



?>

	
	
	<header class = "animated bounceInLeft container-floud">
			<div class = " container row">
				<div class = "col-md-6">
						<a href="#" id = "logo">log</a>
				</div>
							<div class = "col-md-6 " >
								<div class = "der"
				<p>Bienvenido <?php
				echo $_SESSION['usuario'];
				?></p>
				<p>Editando Cliente <?php echo $_SESSION['usuarioEdit'];?></p>
				<p>Ultima conexion  DD-MM-AAAA</p>
				<a href = "cerrarSesion.php" class ="btn btn-default" >Cerrar sesion</a>	
				</div>
							</div>
				
			</div>
		</header>

		<nav class = "animated bounceInRight">
			
			<ul>
				<li><a href="movimientosAdmin.php"><span class = "color"><i class = "icon icon-database"></i></span>Movimientos</a></li>
				<li><a href="crear_tarjeta.php"><span class = "color"><i class = "icon icon-credit-card"></i></span>Crear tarjeta</a>
					<ul>
							<li><a href="verTarjetas.php">Ver Tarjetas</a></li>
							<li><a href="crear_tarjeta.php">Crear Tarjeta</a></li>
							
						</ul>
				</li>
				<li><a href=""><span class = "color"><i class = "icon icon-user"></i></span>Cuentas</a>
						<ul>
							<li><a href="crear.php">Crear</a></li>
							<li><a href="verCuenta.php">Ver</a></li>
							<li><a href="modificar.php">Modificar</a></li>
							<li><a href="consignar.php">Consignar</a></li>
						</ul>
				</li>
				<li><a href=""><span class = "color"><i class = "icon icon-coin-euro"></i></span>Creditos</a>
					<ul>
							<li><a href="verCreditos.php">Ver Creditos</a></li>
							<li><a href="creditos.php">Crear Credito</a></li>
							
					</ul>
				</li>
			</ul>
		</nav>
		<div class = "contenedor ">
		<section >
			<div class = "con animated fadeInUp table">
				<h1>Movimientos de Cuentas</h1>
				<div class="table-responsive">
						<table class = "table table-striped table-bordered table-hover">
							<tr>
								<th>Cuenta</th>
								<th>Concepto</th> 
								<th>Saldo Anterior</th>
								<th>Monto</th>
								<th>Cuenta Origen</th>
								<th>Cuenta Destino</th>
							</tr>
							<?php
								
							
								while ($fila = mysql_fetch_assoc($resultado)) {
								$sql1 = "SELECT * from logCuenta where numeroCuenta=".$fila['numeroCuenta'].";";
								$resultado1 = mysql_query($sql1);
								echo "<tr>";
								while ($fila1 = mysql_fetch_assoc($resultado1)) {
									echo "<td>".$fila1['numeroCuenta']."</td>";
									echo "<td>".$fila1['concepto']."</td>";
									echo "<td>".$fila1['saldoAnterior']."</td>";
									echo "<td>".$fila1['monto']."</td>";
									echo "<td>".$fila1['cuentaOrigen']."</td>";
									echo "<td>".$fila1['cuentaDestino']."</td>";
									echo"</tr>";
									}
								
							}
						?>
						
						</table>
				</div>
				<h1>Movimientos de tarjetas</h1>
				<div class="table-responsive">
					<table class = "table table-striped table-bordered table-hover">
						<tr>
							<th>Tajeto No.</th>
							<th>Saldo Anterior</th> 
							<th>Monto</th>
							<th>Fecha</th>
						</tr>
						
						<?php
							
							$sql1 = "select t2.idtarjeta, t2.saldoAnterior, t2.monto, t2.fecha  from tarjeta , logTarjeta as t2 
							where tarjeta.idCliente = " .$_SESSION['usuarioEdit']. " and tarjeta.idtarjeta = t2.idtarjeta;";
							$resultado1 = mysql_query($sql1);
							echo "<tr>";
							while ($fila1 = mysql_fetch_assoc($resultado1)) {
								echo "<td>".$fila1['idtarjeta']."</td>";
								echo "<td>".$fila1['saldoAnterior']."</td>";
								echo "<td>".$fila1['monto']."</td>";
								echo "<td>".$fila1['fecha']."</td>";
								echo"</tr>";
								}
							
						
						
					?>
	 				
						
						
					</table >
				</div>
				<h1>Movimientos de pagos de servicios</h1>
				<div class="table-responsive">
				<table class = "table table-striped table-bordered table-hover">
					<tr>
						<th>Servicio</th>
						<th>Monto</th> 
						<th>Fecha</th>
					</tr>
					<?php
					$sql1 = "select t1.concepto , t2.monto, t2.fecha  from servicios as t1, logServicios as t2 
					where t1.idservicios = t2.idservicios and t1.idcliente = " .$_SESSION['usuarioEdit']. " ;";
						$resultado1 = mysql_query($sql1);
						echo "<tr>";
						while ($fila1 = mysql_fetch_assoc($resultado1)) {
							echo "<td>".$fila1['concepto']."</td>";
							echo "<td>".$fila1['monto']."</td>";
							echo "<td>".$fila1['fecha']."</td>";
							echo"</tr>";
							}
						?>
				
				</table>
				</div>
			</div>
		</section>
		</div>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>
