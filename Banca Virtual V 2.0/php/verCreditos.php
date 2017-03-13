<!DOCTYPE html>
<html>
	<head>
		
			<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">

		
		<title>nombre banco </title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body onload = "run()">
	<?php
									$choice = $_POST['myselect'];
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
								
	?>
		<header class = "animated bounceInLeft container-floud">
			<div class = " container row">
				<div class = "col-md-6">
						<a href="#" id = "logo">log</a>
				</div>
							<div class = "col-md-6 " >
								<div class = "der">
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
							<li><a href="verCreditos.php">Ver Tarjetas</a></li>
							<li><a href="creditos.php">Crear Credito</a></li>
							
					</ul>
				</li>
			</ul>
		</nav>
		<div class = "conteiner ">
		<section >
			<div class = "con animated fadeInDown">
				<form class="formu_crear" action = "verCreditos.php" method = "post">
					<ul>
						<li  class = "row">
							<label>Prestamo</label>
						
							<select name="myselect" id="myselect" onchange="this.form.submit()">
									
								<?php
								$sql = "SELECT idprestamos from prestamos where idcliente=".$_SESSION['usuarioEdit'].";";
								$resultado = mysql_query($sql);
								
								echo "<option value='0'></option>";
								while ($fila = mysql_fetch_assoc($resultado)) {
														echo "<option value =".$fila['idprestamos']." >".$fila['idprestamos']."</option>";
														}					
								
				
								
																?>	
							</select>
						<?php
								if(!$choice){
					?>	
				
					<?php
					
					
					
					}else {
						$sql3 = "SELECT * from prestamos where idprestamos = ".$choice.";";
						
		
					$resultado3 = mysql_query($sql3);
					$fila3 = mysql_fetch_assoc($resultado3);
					
					
					
					echo"
							</li>
						<li class = 'row'>
							<label>Saldo</label>
							<input class = 'text' type='text' readonly='readonly' name='text_type' value = '".$fila3['saldo']."'> 
						</li>
						<li class = 'row'>
							<label>Fecha Aprobacion</label>
							<input  class = 'text' type='text' readonly='readonly' name='text_Saldo' value = '".$fila3['fechaAprobacion']."'> 
						</li>
						<li class = 'row'>";
						
					
					}
					
					?>
				</form>
				
				
			</div>
		</section>
		</div>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>
