<html>
<head>
<meta charset = "UTF-8">
</head>

<?php
//echo "Hola Mundo";


$conexión = mysql_connect("localhost", "root", "1qa2w3ed");
$username=$_POST['userName'];
$password1=$_POST['password'];

if (!$conexión) {
    echo "No pudo conectarse a la BD: " . mysql_error();
    exit;
}

if (!mysql_select_db("proyecto")) {
    echo "No ha sido posible seleccionar la BD: " . mysql_error();
    exit;
}

$sql = "select idcliente, claveInternet from cliente where userName = '".$username."';";
$resultado = mysql_query($sql);
$datos = mysql_fetch_assoc($resultado);

$id = $datos['idcliente'];
$clave2 = $datos['claveInternet'];


$sql2 = "select verificarClave(".$id.",'".$password1."');";
$resultado2 = mysql_query($sql2);
$datos2 = mysql_fetch_assoc($resultado2);








if (!$resultado) {
    echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    exit;
}



// Mientras exista una fila de datos, colocar esa fila en $fila como un array asociativo
// Nota: Si solo espera una fila, no hay necesidad de usar un bucle
// Nota: Si coloca extract($fila); dentro del siguiente bucle,
//       estará creando $id_usuario, $nombre_completo, y $estatus_usuario
//while ($fila = mysql_fetch_assoc($resultado)) {
//    echo $fila["verificarClave2(".$id.",'".$password1."')"];
//}




$variable;
foreach($datos2 as $x => $x_value) {
    $variable = $x_value;
}
if($variable == 1){
	session_start();
		
		$_SESSION['id'] = $id;	
			
		$_SESSION['usuario'] = $nombre['nombre'];

		$_SESSION['clave2'] = $clave2;
		
		
		if($id ==1){
				echo "
			<html>
				<head>
				<meta http-equiv= 'REFRESH' content = '0; url= adminIndex.php'>
					<script>
						alert('Bienvenido".$id."');
					</script>
					
					
				</head>
			
			
			</html>
		";
		
		}
		else{
		echo "
			<html>
				<head>
				<meta http-equiv= 'REFRESH' content = '0; url=IndexCliente.php'>
					<script>
						alert('Bienvenido".$id."');
					</script>
					
					
				</head>
			
			
			</html>
		";
	}
	}
else{
	echo "
			<html>
				<head>
				<meta http-equiv= 'REFRESH' content = '0; url= ../'>

					<script>
					alert('No existe ".$username." o ha digitado mal su contraseña');
					</script>
					
					
				</head>
			
			
			</html>
		";
	}	

?>
</html>

