<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<script type="text/javascript" src = "../UI/js/animation.js"></script>
		
		<title>nombre banco </title>
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
							<li><a  href="crear.php">Crear</a></li>
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

		<div class = "container ">
		<section >
			<div class = "con animated fadeInDown container">
				<form class="formu_crear"  action = "crear_tarjeta.php" method = "post">
					<div class = "row">

						
							<div class = "col-xs-12 col-sm-4 col-md-2 ">
								
								<label>Cupo</label>
							</div>
							<div  class = "col-xs-12 col-sm-4 col-md-2 ">
								<input class = "text"type="text" name = "cupo" placeholder = "titular">
							</div>
							<div class = "col-xs-12 col-sm-4 col-md-6 ">
							<input name="botoncito" class = "submit margin-left"type="submit" value="Crear">
							</div>
							
					</div>
				</form>
				<?php 
				if (isset($_POST['botoncito'])){
			$cupo = $_POST['cupo'];
			if($cupo){
				if($cupo>0){
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

				$sql = "call aprobarTarjeta (" .$_SESSION['usuarioEdit'] . ",". $cupo . ");";

				$resultado = mysql_query($sql);
				echo '<script language="javascript">alert("Su tarjeta se creo exitosamente");</script>';

					
				if (!$resultado) {
					echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
					echo "<br> Con cuero :" . $sql;
					exit;
				}
				else
				echo "Se ha creado exitosamente la tarjeta con cupo " . $cupo;
			}else{
				echo '<script language="javascript">alert("Su cupo es negativo, su tarjeta no se ha podido crear");</script>';
			}
			}else{
				echo '<script language="javascript">alert("usted no lleno todos los campos en su totalidad");</script>';
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
