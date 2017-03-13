<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<title>nombre banco </title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body >
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

$sql = "SELECT concat(nombre, ' ' ,apellido) as clientes from cliente;";

$resultado = mysql_query($sql);
	
if (!$resultado) {
    echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    exit;
}

if (mysql_num_rows($resultado) == 0) {
    echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
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


		<div class = "container">
		<section >
			<div class="con animated fadeInDown">
				<form class="formu_crear" method = "post" action = "consignar.php">
					
						<ul  >
							<li class = "row">

								<label class = "col-md-6">Seleccione su cuenta</label>
								<select class="col-md-6 text" name = "cuentas" method = "post" action = "consignar.php">
									<?php
								$sql2 = "SELECT numeroCuenta from cuenta_cliente where idcliente=".$_SESSION['usuarioEdit'].";";
								$resultado2 = mysql_query($sql2);

								if(!$_POST['myselect']){
								echo "<option selected='selected' value='0'></option>";
								while ($fila = mysql_fetch_assoc($resultado2)) {
									echo "<option value = ".$fila['numeroCuenta'].">".$fila['numeroCuenta']."</option>";
									}
								}else {
									
									while ($fila = mysql_fetch_assoc($resultado2)) {
										if($fila['numeroCuenta'] != $choice){
										echo "<option value = ".$fila['numeroCuenta'].">".$fila['numeroCuenta']."</option>";
										}
										else{
											echo "<option selected='selected' value = ".$fila['numeroCuenta'].">".$fila['numeroCuenta']."</option>";
											}
									}
									
									
								}						
				
								
																?>	
								</select>
							</li>
							<li class = "row">
						<label class = "col-md-6">Cantidad</label>
						<input class="col-md-6 text" type="text" name = "cantidad" placeholder = "cantidad">
							</li>
							
						<li class = "row">	
							<div class "col-md-12" >
						<input class = "submit" type="submit" name ="botoncito" value=" Consignar "> 
						</div>
						</li>	
						<br>
						</ul>
				</form>
				
				<?php 
					
				if (isset($_POST['botoncito'])){	
				
				$cantidad=$_POST['cantidad'];
				$choice= $_POST['cuentas'];
				if($choice ==0 	or !$cantidad){
					
				echo '<script language="javascript">alert("Usted no lleno los campos en su totalidad");</script>';
	
						}else {
							if($cantidad>=0){
						$sql3 = "update cuenta set saldo=saldo+".$cantidad.";";
						$resultado = mysql_query($sql3);
						echo '<script language="javascript">alert("Su consignacion se realizo exitosamente ");</script>';

					}else{
						echo '<script language="javascript">alert("Usted ingreso en el campo de cantidad un valor negativo NO se pudo realizar su consignacion");</script>';
					}
					
			}
		}
			?>
				
			</div>
		</section>
		</div>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>

