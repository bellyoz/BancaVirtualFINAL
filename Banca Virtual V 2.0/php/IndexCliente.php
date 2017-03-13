<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style2.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<script type="text/javascript" src ="../UI/js/javascript.js"></script>
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec2.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<title>IndexCliente</title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body onload = "run()">
		<?php
		//echo "Hola Mundo";
		session_start();

		$conexión = mysql_connect("localhost", "root", "1qa2w3ed");



		if (!$conexión) {
    	echo "No pudo conectarse a la BD: " . mysql_error();
    	exit;
		}

		if (!mysql_select_db("proyecto")) {
    	echo "No ha sido posible seleccionar la BD: " . mysql_error();
    	exit;
		}

		$sql = "SELECT * from cuenta_cliente where idcliente=".$_SESSION['id'].";";

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
	
		<header class = "animated bounceInLeft">
			<a href="#" id = "logo">log</a>
			<a href="index.php" class = "button" id = "Salir">Salir</a>	
		</header>

       <nav class = "animated bounceInRight">
			<ul>
				<li><a href="IndexCliente.php"><span class = "color"><i class = "icon icon-database"></i></span>Cuentas</a></li>
				<li><a href="ClienteTarjeta.php"><span class = "color"><i class = "icon icon-credit-card"></i></span>Tarjetas</a></li>
				<li><a href="ClientePrestamo.php"><span class = "color"><i class = "icon icon-user"></i></span>Prestamos</a><li>
				<li><a href="ClienteServicio.php"><span class = "color"><i class = "icon icon-coin-euro"></i></span>Servicios</a></li>
				<li><a href="transferencia.php"><span class = "color"><i class = "icon icon-coin-euro"></i></span>Transferencias</a></li>
				<li><a href="ClienteResumen.php"><span class = "color"><i class = "icon icon-coin-euro"></i></span>Resumen</a></li>
			</ul>
		</nav>

		
		<section >

			<div class="recuperar con animated zoomIn" id="tc">
				<div class="table-responsive">
					  <div class="panel panel-default">
					     <div class="panel-heading"><h2>Informacion de la cuenta<h2></div>
                        <table class="table table-striped table-bordered table-hover" >
		                       <tr>
			                    <th>Cuenta</th>
			                    <th>Saldo</th>
			                    <th>N° de cuenta</th>
			                    <th>Titular</th>
		                     </tr>
		                     <tr> 	
		  					<?php
								while ($fila = mysql_fetch_assoc($resultado)) {
								$sql1 = "SELECT * from cuenta where numeroCuenta=".$fila['numeroCuenta'].";";
								$resultado1 = mysql_query($sql1);
								echo "<tr>";
								while ($fila1 = mysql_fetch_assoc($resultado1)) {
									echo "<td>".$fila1['tipo']."</td>";
									echo "<td>".$fila1['saldo']."</td>";
									echo "<td>".$fila1['numeroCuenta']."</td>";
									echo "<td>".$fila1['titular']."</td>";
									}
								echo"</tr>";
							}
						?>
		 				</tr>
				 		</table>
				 	</div>
				</div>
			</div>
		</section>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>
