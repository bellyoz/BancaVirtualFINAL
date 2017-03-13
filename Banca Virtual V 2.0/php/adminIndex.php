<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<script type="text/javascript" src = "../UI/js/animation.js"></script>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<title>nombre banco </title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body  onload = "run()">
		
	
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

	
	
		<header class = "container-floud">
			<div class = " container row">
				<div class = "col-md-6">
						<a href="#" id = "logo">log</a>
				</div>
							<div class = "col-md-6 " >
								<div class = "der">
							<p>Bienvenido <?php
							echo $_SESSION['usuario'];
							?>

							</p>
							<p>Ultima conexion  DD-MM-AAAA</p>
							<a href = "cerrarSesion.php" class ="btn btn-default" >Cerrar sesion</a>
							</div>
							</div>
				
			</div>
		</header>
		<nav class = "container-floud">
			
		</nav>
		<div class = "container ">
		<section >
		
				<div class = "con animated fadeInUp">
						<form  action = "movimientosAdmin.php" method = "post">
							<div class = "row">
								
							<div class = "col-xs-12 col-sm-3 col-md-3" >
							<h1 class=" textype">Cliente</h1>
							</div>
							<div class = "col-xs-12 col-sm-3 col-md-3" >
								<select  id = "choice" name = "choiceClient">
								<?php
								session_destroy();
								$contador = 1;
								while ($fila = mysql_fetch_assoc($resultado)) {
								if($contador >1)
								echo "<option value = '".$contador."'>".$fila['clientes']."</option>";
								$contador = $contador + 1;
							}
								?>
				}			
								</select>
								</div>
								<div class = "col-xs-12 col-sm-6 col-md-6" >				
								<input class = " submit button-choice" type = "submit" value = "Seleccionar Cliente"></button>
								</div>
								
							</div>
						</form>
				
			</div>
		</section>
		</div>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>


