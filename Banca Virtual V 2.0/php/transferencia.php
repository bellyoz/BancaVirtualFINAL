<!DOCUMENT html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
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

			$sql1 = "SELECT * from servicios where idcliente=".$_SESSION['id'].";";
			

			$resultado1 = mysql_query($sql1);
	
			if (!$resultado1) {
    		echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
    		exit;
			}

			

			$sql = "SELECT numeroCuenta from cuenta_cliente where idcliente=".$_SESSION['id'].";";
			
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

			<div class = "recuperar con animated zoomIn">

				<form method="post" action="transferencia.php">
				<h2>Tranferir plata</h2><br>
                 <div class="panel-group" id="acor" role="tablist">
                        	<div class="panel panel-default">
                               <div class="panel-heading" role="tab" id="head1">
	                               <h4 class="panel-title">
	                                 <a href="#coll" data-toggle="collapse" data-parent="#acor"> 
	                                 Cuenta de origen
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll" class="panel-collapse collapse">
	                               <div class="panel-body ">
	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<select name="opCuenta" class="form-control">
													<?php
								                		echo "<option value ='0'> </option>";
														while ($fila = mysql_fetch_assoc($resultado)) {
															if($fila ['numeroCuenta']!= $_POST['opCuenta'] )
															echo "<option value =".$fila['numeroCuenta']." >".$fila['numeroCuenta']."</option>";
															else
															echo "<option selected='selected' value =".$fila['numeroCuenta']." >".$fila['numeroCuenta']."</option>";
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
	                                 Cuenta de destino
	                                </a>
	                               </h4>
                               </div>
                               <div id="coll2" class="panel-collapse collapse">
	                               <div class="panel-body ">

	                                  <div class="form-group ">
			                        	  <div class="input-group">
									      <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										    	<input name="NCD" class = "form-control" type = "text" placeholder="N° de la cuenta"required>
			                             </div>
			                          </div>
			                          <center>
                                       <input name="botoncito" class="btn btn-primary" type="submit" value="Aceptar">
			                          </center>
			                        </div>
                                 </div> 
                               </div>  
                             </div>	
				<?php
					if (isset($_POST['botoncito']))
					{
						$titular=$_POST['NCD'];
						if($titular){
						
						$sql1 = "SELECT * from cuenta where numeroCuenta=".$titular.";";
			
						$resultado1 = mysql_query($sql1);
						$fila1 = mysql_fetch_assoc($resultado1);	
	
						if (!$fila1) {
                             echo "
							<div class='form-group'>
			                        	  <div class='input-group'>
									      <div class='input-group-addon ''><span class='glyphicon glyphicon-list-alt'></span></div>	
										    	<input name='cu' readonly='readonly' class = 'form-control' type = 'text' placeholder='la Cuenta no existe'>
			                             </div>
			                          </div>";
    					//echo "Cuenta de destino <input name='cu' readonly='readonly' type='text' value= 'Cuenta No Existe'><br>";
				
						}else{
                             echo "
							<div class='form-group'>
			                        	  <div class='input-group'>
									      <div class='input-group-addon ''><span class='glyphicon glyphicon-list-alt'></span></div>	
										    	<input name='cu' readonly='readonly' class = 'form-control' type = 'text' value= "."'".$titular."'"." >
			                             </div>
			                          </div>";

			                   echo "
							<div class='form-group'>
			                        	  <div class='input-group'>
									      <div class='input-group-addon ''><span class='glyphicon glyphicon-list-alt'></span></div>	
										    	<input name='ti' readonly='readonly' class = 'form-control' type = 'text' value= "."'".$fila1['titular']."'"." >
			                             </div>
			                          </div>";        

						//echo "Cuenta de destino <input name='cu' readonly='readonly' type='text' value= "."'".$titular."'"."><br>";
						//echo "Titular <input name='ti' readonly='readonly' type='text' value= "."'".$fila1['titular']."'"."><br>";
						}
					}
				}
				?>
				
									<div class="form-group ">
			                          <div class="input-group">
									     <div class="input-group-addon "><span class="glyphicon glyphicon-list-alt"></span></div>	
										   <input name="mo" class = "form-control" type = "text" placeholder="Monto" required>
			                             </div>
			                          </div>
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
					<center><button name ="submit" type="submit" class="btn btn-primary" >Aceptar</button></center>
                               	 </div>
			                          </center>
									</form>
			</div>
			<?php
				if(isset($_POST['submit'])){
					
				$id=$_SESSION['id'];
				$pass=$_POST['password2'];
				
				
				$sql20 = "select verificarClave2(".$id.",'".$pass."');";
				$resultado20 = mysql_query($sql20);
				$datos20 = mysql_fetch_assoc($resultado20);
				
				foreach($datos20 as $x => $x_value) {
				$variable20 = $x_value;
				}
				
				if($variable20 == 1){	
			
				if($_POST['opCuenta'] && $_POST['ti'] && $_POST['mo']>0){
				$origen=$_POST['opCuenta'];
				$destino=$_POST['cu'];
				$titular1=$_POST['ti'];
				$monto=$_POST['mo'];

				
					$sql3 = "call transferencia(".$origen.",".$destino.",".$monto.");";
				$resultado3 = mysql_query($sql3);
				echo $sql3;

				
				if (!$resultado3) {
					echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
					echo "<br> Con cuero :" . $sql3;
					exit;
				}
				else{
				echo '<script language="javascript">alert("Su transferencia se realizo con exito");</script>';	
				 
				echo "<script>location.href='IndexCliente.php'</script>";
				}
			
				
			
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
