<!DOCUMENT html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
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
			
			$sql2 = "SELECT numeroCuenta from cuenta_cliente where idcliente=".$_SESSION['id'].";";
		

			$resultado2 = mysql_query($sql2);
	
			$sql3 = "SELECT idtarjeta from tarjeta where idcliente=".$_SESSION['id'].";";
		

			$resultado3 = mysql_query($sql3);
		
			

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

			<div class= "recuperar">
				<h2>Pagar Servicios</h2>
				<br>
			
				<form action="PagarServicio.php" method="post">
				Servicio : 
                <select name="opServicio">
						<?php
						while ($fila1 = mysql_fetch_assoc($resultado1)) {
							if($fila1['valor']>0){
							if($fila1 ['idservicios']!= $_POST['opServicio'] )
							echo "<option value =".$fila1['idservicios']." >".$fila1['concepto']."</option>";
							else
							echo "<option selected='selected' value =".$fila1['idservicios']." >".$fila1['concepto']."</option>";
								
							}
						}
						?>
				</select><br><br>
				Seleccione el medio de pago : 
						<?php
						echo "<select name='myselect' id'myselect' onchange = 'this.form.submit()'>";
							
							if($_POST['myselect']==1){
								echo "
							<option value = 0> </option>
						
							<option selected='selected' value = 1> Cuenta</option>
						
							<option value = 2> Tarjeta</option>";
							}
							else if($_POST['myselect']==2){
										echo "<option value = 0> </option>
						
							<option  value = 1> Cuenta</option>
						
							<option selected='selected' value = 2> Tarjeta</option>";
								}else{
										echo "<option selected='selected' value = 0> </option>
						
							<option  value = 1> Cuenta</option>
						
							<option  value = 2> Tarjeta</option>";
								}
									
						?>
						</select>
						
								<?php
		
								
							
								if($_POST['myselect']){
									if($_POST['myselect'] == 1){
									echo "			<br><br>	
							Seleccione la Cuenta con que desea pagar : 
							<select name='opCuenta3'>";
									
									while ($fila = mysql_fetch_assoc($resultado2)) {
										echo "<option value = ".$fila['numeroCuenta'].">".$fila['numeroCuenta']."</option>";
										}
									
							echo"</select><br><br>
							<center>
							<center>
					<a href='#sx'  class='btn btn-success' data-toggle='modal'> Pagar Servicio</a>	
				</center>
				<div class='modal fade' id='sx'>
                               <div class='modal-dialog'>
                               <div class='modal-content'>
                               	 <div class='modal-header'>
                               	 	<h2 class='modal-title'>Confirmar pago</h2>
                               	 	
                               	 </div>
                               	 <div class='modal-body'>
                                  <p>Ingresa tu segunda clave para confirmar el pago.</p>
                                    	<div class='form-group'>
									<div class='input-group'>
									<div class='input-group-addon'><span class='glyphicon glyphicon-asterisk'></div>
									<input name='password2'  class = 'form-control' type = 'password' placeholder='Segunda clave:'required>
									</div>
									</div >
					<center><button name ='botoncito' type='submit' class='btn btn-primary' >Aceptar</button></center>
                               	 </div>	
							</center>";
						}else{
							echo "			<br><br>	
							Seleccione la Tarjeta con que desea pagar : 
							<select name='opCuenta3'>";
									
									while ($fila3 = mysql_fetch_assoc($resultado3)) {
										echo "<option value = ".$fila3['idtarjeta'].">".$fila3['idtarjeta']."</option>";
										}
									
							echo"</select><br><br>
							<center>
							<center>
					<a href='#sx'  class='btn btn-success' data-toggle='modal'> Pagar Servicio</a>	
				</center>
				<div class='modal fade' id='sx'>
                               <div class='modal-dialog'>
                               <div class='modal-content'>
                               	 <div class='modal-header'>
                               	 	<h2 class='modal-title'>Confirmar pago</h2>
                               	 	
                               	 </div>
                               	 <div class='modal-body'>
                                  <p>Ingresa tu segunda clave para confirmar el pago.</p>
                                    	<div class='form-group'>
									<div class='input-group'>
									<div class='input-group-addon'><span class='glyphicon glyphicon-asterisk'></div>
									<input name='password2'  class = 'form-control' type = 'password' placeholder='Segunda clave:'required>
									</div>
									</div >
					<center><button name ='botoncito' type='submit' class='btn btn-primary' >Aceptar</button></center>
                               	 </div>	
							</center>";
							
							
							}
									
								}				
				
																?>				
					
				</form>	
				<br>
				<center>
				<input type="submit"  value=" Volver " class="btn btn-success" onclick="window.location.href='ClienteServicio.php'">
				</center>
			</div>
		<?php
		$idServicios=$_POST['opServicio'];
		if (isset($_POST['botoncito']))
		{

				$id=$_SESSION['id'];
				$pass=$_POST['password2'];
				
				
				$sql20 = "select verificarClave2(".$id.",'".$pass."');";
				$resultado20 = mysql_query($sql20);
				$datos20 = mysql_fetch_assoc($resultado20);
				
				foreach($datos20 as $x => $x_value) {
				$variable20 = $x_value;
				}
				
				if($variable20 == 1){	
				if($_POST['opCuenta3'] ) {
		
				if($_POST['myselect']==1){
				$fuente= "'cuenta'";
				}
				else{
				$fuente= "'tarjeta'";
				}
				$idfuente=$_POST['opCuenta3'];
				$sql3 = "call pagarServicio(".$idServicios.",".$fuente.",".$idfuente.");";
				$resultado3 = mysql_query($sql3);
				echo $sql3;

				if($idServicios){	
				if (!$resultado3) {
					echo "No se pudo ejecutar con exito la consulta ($sql) en la BD: " . mysql_error();
					echo "<br> Con cuero :" . $sql3;
					exit;
				}
				else
				echo '<script language="javascript">alert("Su servicio se pago con exito");</script>';	
				 
				echo "<script>location.href='ClienteServicio.php'</script>";
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
</html>
