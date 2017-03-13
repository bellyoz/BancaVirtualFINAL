<!DOCUMENT html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style2.css">
		<script type="text/javascript" src ="../UI/js/javascript.js"></script>
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec2.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="../UI/css/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="../UI/css/bootstrap-3.3.4-dist//js/bootstrap.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="../UI/js/bootstrap.min.js"></script>
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

	$sql = "SELECT idtarjeta from tarjeta where idcliente=".$_SESSION['id'].";";
	

	$resultado = mysql_query($sql);
	
	if (!$resultado) {
    echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    exit;
	}

	

	$sql2 = "SELECT numeroCuenta from cuenta_cliente where idcliente=".$_SESSION['id'].";";
	

	$resultado2 = mysql_query($sql2);
	
	if (!$resultado2) {
    echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    exit;
	}

	

	// Mientras exista una fila de datos, colocar esa fila en $fila como un array asociativo
	// Nota: Si solo espera una fila, no hay necesidad de usar un bucle
	// Nota: Si coloca extract($fila); dentro del siguiente bucle,
	//       estará creando $id_usuario, $nombre_completo, y $estatus_usuario

	?>
		<header >
			<a href="#" id = "logo">log</a>
			<a href="index.php" class = "button" id = "Salir">Salir</a>	
		</header>
	
		<section >
			<div class = "recuperar">
				<h2>Pagos de tarjeta</h2>
				<br>
				<form action ="PagosTarjeta.php" method="post">
                <div class="panel-group" id="acor" role="tablist">
                        	<div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head1">
	                               <h4 class="panel-title">
	                                 <a href="#coll" data-toggle="collapse" data-parent="#acor"> 
	                                 Seleccione la Tarjeta que desea pagar
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll" class="panel-collapse collapse">
	                               <div class="panel-body ">
	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="opTarjeta" class="form-control">
													<?php
													while ($fila = mysql_fetch_assoc($resultado)) {
														echo "<option value =".$fila['idtarjeta']." >".$fila['idtarjeta']."</option>";
														}
													?>
				                                </select>
				                              </div>
			                              </div>
			                            </div>
                                   </div> 
                        	</div> 	
				    <div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head2">
	                               <h4 class="panel-title">
	                                 <a href="#coll2" data-toggle="collapse" data-parent="#acor"> 
	                                 Seleccione la Cuenta con que desea pagar
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll2" class="panel-collapse collapse">
	                               <div class="panel-body ">
	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="opCuenta2" class="form-control">
													<?php
														while ($fila = mysql_fetch_assoc($resultado2)) {
																
															echo "<option value = ".$fila['numeroCuenta'].">".$fila['numeroCuenta']."</option>";
													
															}
														?>
										    	</select>
			                             </div>
			                          </div> 
			                        </div>
                                 </div> 
                               </div>  
                             </div>

				       <div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>	
							 <input name="VAP3" class = "form-control" type = "text" placeholder="valor a pagar"required>
					    </div>
					</div>
				<center>
				
				
<center>
					<a href="#sx"  class="btn btn-success" data-toggle="modal"> Pagar</a>	
				</center>
				<div class="modal fade" id='sx'>
                               <div class="modal-dialog">
                               <div class="modal-content">
                               	 <div class="modal-header">
                               	 	<h2 class="modal-title">Confirmar pago</h2>
                               	 	
                               	 </div>
                               	 <div class="modal-body">
                                  <p>Ingresa tu segunda clave para confirmar el pago.</p>
                                    	<div class="form-group">
									<div class="input-group">
									<div class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></div>
									<input name="password2"  class = "form-control" type = "password" placeholder="Segunda clave:"required>
									</div>
									</div >
					<center><button name ="pagarTarjeta" type="submit" class="btn btn-primary" >Aceptar</button></center>
                               	 </div>
                               	 
				
				</center>
				</form>	
				 <br>
				<center>
				 <input type="submit" value="Regresar" class="btn btn-success" onclick="window.location.href='ClienteTarjeta.php'">	
				</center>
			</div>
			<?php
				
				if (isset($_POST['pagarTarjeta'])){
				$id=$_SESSION['id'];
				$pass=$_POST['password2'];
				
				
				$sql20 = "select verificarClave2(".$id.",'".$pass."');";
				$resultado20 = mysql_query($sql20);
				$datos20 = mysql_fetch_assoc($resultado20);
				
				foreach($datos20 as $x => $x_value) {
				$variable20 = $x_value;
				}
				
				if($variable20 == 1){	
			    $idTarjeta=$_POST['opTarjeta'];
				$fuente="'cuenta'";
				$idfuente=$_POST['opCuenta2'];
				$vap3=$_POST['VAP3'];
			
				if($vap3>=0 ){
				$sql = "call pagarTarjeta(".$idTarjeta.",".$fuente.",".$idfuente.",".$vap3.");";
				$resultado = mysql_query($sql);
				if($idTarjeta){
				if (!$resultado) {
					echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
					echo "<br> Con cuero :" . $sql;
					exit;
				}
				else
				echo '<script language="javascript">alert("Su Tarjeta se pago correctamente");</script>'; 
				echo "<script>location.href='ClienteTarjeta.php'</script>";
				}
			}else{
				echo '<script language="javascript">alert("No puede ingresar un monto negativo");</script>'; 
				}
			}else{
				echo '<script language="javascript">alert("Su clave de internet es incorrecta");</script>'; 

					}
		}
		
		
		
				?>
		</section>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>
	
