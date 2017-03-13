<!DOCUMENT html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style2.css">
		<script type="text/javascript" src ="../UI/js/javascript.js"></script>
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec2.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec2.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="../UI/css/bootstrap-3.3.4-dist//js/bootstrap.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<title>IndexCliente</title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body onload = "run()">
	



		<header >
		<a   href="../"><img width = "150" src = "pictures/NombreLOGO.png"></a>
			<a href="index.php" class = "button" id = "Salir">Salir</a>	
		</header>
	
		<section >

			<div class = "recuperar">
				<h2>Agregar Servicios</h2>
				<br>
				<form  action="AgregarServicio.php" method = "post">
				<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>	
							 <input name="concepto" class = "form-control" type = "text" placeholder="concepto",required>
					    </div>
					</div>
			
                <div class="panel-group" id="acor" role="tablist">
                        	<div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head1">
	                               <h4 class="panel-title">
	                                 <a href="#coll" data-toggle="collapse" data-parent="#acor"> 
	                                 Seleccione la fecha limite
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll" class="panel-collapse collapse">
	                               <div class="panel-body ">

	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="año" class="form-control">
													<option>2015</option>
						                             <option>1016</option>
				                                </select>
				                              </div>
			                              </div>

			                              <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="mes" class="form-control">
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
													<option>5</option>
													<option>6</option>
													<option>7</option>
													<option>8</option>
													<option>9</option>
													<option>10</option>
													<option>11</option>
													<option>12</option>
				                                </select>
				                              </div>
			                              </div>

			                              <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="dia" class="form-control">
										    		<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
													<option>5</option>
													<option>6</option>
													<option>7</option>
													<option>8</option>
													<option>9</option>
						                            <option>10</option>
				                                </select>
				                              </div>
			                              </div>

			                            </div>
                                   </div> 
                        	</div> 	
             <br>
                <div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>	
							 <input name="VAP" class = "form-control" type = "text" placeholder="valor a pagar"required>
					    </div>
					</div>
					
				<center>
				<input name="agregarServicio" type="submit" value=" Agregar " class="btn btn-success">
				</center>
				</form>
				<br>
				<center>
					<a class = "btn btn-success"href = "ClienteServicio.php">Regresar</a>
				</center>
				
			</div>
		</section>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
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
 $concepto=$_POST['concepto'];
 $ano=$_POST['año'];
 $mes=$_POST['mes'];
 $dia=$_POST['dia'];
 $vap=$_POST['VAP'];
 $fechaLimite=$ano."-".$mes."-".$dia;



$sql = "call aprobarServicio(".$_SESSION['id'].",".$vap.",'".$concepto."','".$fechaLimite."');";

$resultado = mysql_query($sql);
				if($mes){
				if (!$resultado) {
					echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
					echo "<br> Con cuero :" . $sql;
					exit;
				}
				else
				echo '<script language="javascript">alert("Su servicio se creo correctamente");</script>'; 
				echo "<script>location.href='ClienteServicio.php'</script>";
				}
// Mientras exista una fila de datos, colocar esa fila en $fila como un array asociativo
// Nota: Si solo espera una fila, no hay necesidad de usar un bucle
// Nota: Si coloca extract($fila); dentro del siguiente bucle,
//       estará creando $id_usuario, $nombre_completo, y $estatus_usuario


?>
	</body>
</html>
