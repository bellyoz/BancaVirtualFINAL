<!DOCTYPE html>
<html>
	<head>
		
			
			<link rel="stylesheet" type="text/css" href="../UI/css/styleban.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style_menu.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/fonts.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/animate.css">
		<title>nombre banco </title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body >
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
				<li><a href=""><span class = "color"><i class = "icon icon-user"></i></span>Cuentas		</a>
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
		<div class = "contenedor ">
		<section >
			<div class = "con animated fadeInDown">
				<form class="formu_crear" action = "modificar.php" method = "post">
					<ul>
						<li>
							<label>cuenta</label>
						
							<select name="myselect" id="myselect" onchange="this.form.submit()">
									
								<?php
								$sql2 = "SELECT numeroCuenta from cuenta_cliente where idcliente=".$_SESSION['usuarioEdit'].";";
								$resultado2 = mysql_query($sql2);

								if(!$_POST['myselect']){
								echo "<option value='0'></option>";
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
						<?php
								if(!$_POST['myselect']){
					?>	
				
					<?php
					
					
					
					}else {
						$sql3 = "SELECT * from cuenta where numeroCuenta = ".$choice.";";
		
					$resultado3 = mysql_query($sql3);
					$fila3 = mysql_fetch_assoc($resultado3);
					
					echo"
							</li>";
					if($fila3['tipo'] == 'Cuenta ahorros'){
					echo "
						<li>
							<label>Tipo</label>
							
									<select name= 'tipo'>
											
							<option selected='selected' value = 'Cuenta ahorros'>Cuenta ahorros</option>
							<option value = 'Cuenta corriente'>Cuenta corriente</option>
													
				
								
																?>	
							</select> 
						</li>";}
						else{
										echo "
						<li>
							<label>Tipo</label>
							
									<select name= 'tipo'>
											
							<option value = 'Cuenta ahorros'>Cuenta ahorros</option>
							<option selected = 'selected' value = 'Cuenta corriente'>Cuenta corriente</option>
													
				
								
																?>	
							</select> 
						
						
						
						";
						}
						echo "
						
							<li>
							<label>Saldo</label>
							<input  class = 'text' type='text' name='text_Saldo' value = '".$fila3['saldo']."'> 
						</li>";
							
							
						
							if($fila3['activo'] == 0 ){
						echo "
							<li>
							<label>Activo</label>
							<select name = 'activo'>
											
							<option selected='selected' value = '0'>Activo</option>
							<option value = '1'>Inactivo</option>
																
							</select>
							</li>
					</ul>";}
					else
					{
						echo "
							<li>
							<label>Activo</label>
							<select name = 'activo'>
											
							<option  value = '0'>Activo</option>
							<option selected='selected' value = '1'>Inactivo</option>
																
							</select>
							</li>
					</ul>";
					}
						
					echo "<input class = 'submit dow' type = 'submit' value = 'Modificar' name = 'botoncito1'> </input>";
					
					}
					
					?>
				</form>
				<?php
				if (isset($_POST['botoncito1'])){	
					if(!$_POST['text_Saldo'] and $_POST['text_Saldo']!=0	 ){
								echo '<script language="javascript">alert("Usted no lleno los campos en su totalidad");</script>';
				}else
					if($_POST['text_Saldo']>=0){
						$sql3 = "UPDATE cuenta set tipo = '".$_POST['tipo']."' , activo = " .$_POST['activo']. ", saldo = " . $_POST['text_Saldo']." 
						where numeroCuenta = ".$_POST['myselect'] ." ;";
					$resultado3 = mysql_query($sql3);
					echo '<script language="javascript">alert("Su Cuenta ha sido modificada correctamente.");</script>';
					
					}else{
						echo '<script language="javascript">alert("Su Cuenta No se puede modificar con saldo negativo.");</script>';
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
