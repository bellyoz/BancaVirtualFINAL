<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset = "UTF-8">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style2.css">
		
		<link rel="stylesheet" type="text/css" href="../UI/css/style_slide.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec2.css">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="../UI/css/bootstrap-3.3.4-dist//js/bootstrap.min.js"></script>
		<script type="text/javascript" src ="../UI/js/javascript.js"></script>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
			<!-- nuevos scropts agregados-->
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<title>nombre</title>
		<script src="../UI/js/jquery.slides.js"></script>
		
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
		
	</head>
	<body onload = "run()">
		<header class = "container-floud">
			<div class = " container ">
				<div class = "col-xs-6 col-sm-6 col-md-6">
				<a   href="#">logo</a>
				</div>
				<div class = "col-xs-6 col-sm-6 col-md-6">
					<a class  = "button" id = "login-button" href="#" >Login</a>
					<span >
			
				<div id = "login"  >
					<div class="triangulo_sup"></div>
					<form class = "letra" action = "validarUsuario.php" method = "post"> 
						<label>Username</label>
						<input type = "text" class = "text" name = "username" placeholder = "Username">
						<label>Password</label>
						<input type = "password" class = "text" name = "password" placeholder = "password">
						<a href="log.html"><label>¿olvido su contraseña?</label></a>
						<center><input class="submit button-choice" type = "submit" name = "button-log" value="login" ></center>
					</form>
				</div>
			</span>
				</div>
			</div>
			

		</header>
	<section >

			<div class = "recuperar">
				<h1 >Registro</h1>
				<br>
				<form method="post" action="Registro.php" >
					<!-- has-success = cambia el color de un campo de texto   -->
					<div class="form-group ">
					<div class="input-group">
					<div class="input-group-addon">N</div>	
					<input name="nombre" class = "form-control" type = "text" placeholder="nombre:">
					</div>
					</div>


					<div class="form-group">
					<div class="input-group">
					<div class="input-group-addon" >A</div>	
					<input name="apellido" class = "form-control" type = "text" placeholder="apellido:">
					</div>
					</div>

					<div class="form-group ">
					<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>	
					 <input name="password1"  class = "form-control" type = "password" placeholder="Clave ">
					 </div>
					</div>

					<div class="form-group">
					<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></div>
					<input name="password2"  class = "form-control" type = "password" placeholder="Clave Internet">
					</div>
					</div >

					<div class="form-group ">
						<div class="input-group">
						<div class="input-group-addon ">@</div>
						<input name="correo" class = "form-control" type = "text" placeholder="Correo:">
					</div>
				    </div>
                    
                        <!-- collapse-acodion-->

                        <div class="panel-group" id="acor" role="tablist">
                        	<div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head1">
	                               <h4 class="panel-title">
	                                 <a href="#coll" data-toggle="collapse" data-parent="#acor"> 
	                                 1. Pregunta de recordacion
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll" class="panel-collapse collapse">
	                               <div class="panel-body ">
	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="pregunta1" class="form-control">
										    	<?php
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
										    	$sql = "select * from preguntas;";
										    	
										    	$resultado = mysql_query($sql);
										    	while ($fila = mysql_fetch_assoc($resultado)) {
													echo "<option value = ".$fila['idpreguntas'].">".$fila['pregunta']."</option>";
													}
													echo"</select><br><br>";
												
										    	
										    	?>
										    	</select>
			                             </div>
			                          </div>

				                         <div class="form-group ">
										<div class="input-group">
										<div class="input-group-addon "><span class="glyphicon glyphicon-pencil"></span></div>
										<input name="respuesta1" class = "form-control" type = "text" placeholder="Primera respuesta:">
										</div>
								    	</div>

	                               </div>
                              </div> 
                        	</div>


                            <div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head2">
	                               <h4 class="panel-title">
	                                 <a href="#coll2" data-toggle="collapse" data-parent="#acor"> 
	                                 2. Pregunta de recordacion
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll2" class="panel-collapse collapse">
	                               <div class="panel-body ">
	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="pregunta2" class="form-control">
													<?php
													$sql = "select * from preguntas;";
													$resultado = mysql_query($sql);
										    		while ($fila = mysql_fetch_assoc($resultado)) {
													echo "<option value = ".$fila['idpreguntas'].">".$fila['pregunta']."</option>";
													}
													echo"</select><br><br>";
										    	?>
										    	</select>
			                             </div>
			                          </div>

				                         <div class="form-group ">
										<div class="input-group">
										<div class="input-group-addon "><span class="glyphicon glyphicon-pencil"></span></div>
										<input name="respuesta2" class = "form-control" type = "text" placeholder="Segunda respuesta:">
										</div>
								    	</div>

	                               </div>
                              </div> 
                        	</div>  


                        </div>
				    
                        	  
				    	

				    
					 <center><button name="botoncito" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-record"></span>  Crear</button></center>
				</form>
			</div>
			<?php
    if (isset($_POST['botoncito'])){

	 $nombre=$_POST['nombre'];
	 $apellido=$_POST['apellido'];
	 $password1=$_POST['password1'];
	 $password2=$_POST['password2'];
	 $correo=$_POST['correo'];
	 $pregunta1=$_POST['pregunta1'];
	 $respuesta1=$_POST['respuesta1'];
	 $pregunta2=$_POST['pregunta2'];
	 $respuesta2=$_POST['respuesta2'];

	 //if ($nombre && $apellido && $password1 && $password2 && $correo && $pregunta1 && $respuesta1 && $pregunta2 && $respuesta2){
	 
	$sql="call insertarCliente('".$nombre."','".$apellido."','".$password1."','".$password2."','".$correo."',".$pregunta1.",'".$respuesta1."',".$pregunta2.",'".$respuesta2."');";

	$resultado = mysql_query($sql);
					if (!$resultado) {
						echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
						echo "<br> Con cuero :" . $sql;
						exit;
					}
					else{
					echo '<script language="javascript">alert("Su servicio se creo correctamente");</script>'; 
					echo "<script>location.href='../'</script>";
					}
	// Mientras exista una fila de datos, colocar esa fila en $fila como un array asociativo
	// Nota: Si solo espera una fila, no hay necesidad de usar un bucle
	// Nota: Si coloca extract($fila); dentro del siguiente bucle,
	// estará creando $id_usuario, $nombre_completo, y $estatus_usuario
//}
}

?>

			
		</section>
	<footer >
		
		sadasd
	</footer>
	
		
	</body>
</html>
