<!DOCUMENT html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../UI/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../UI/css/style.css">
		<script type="text/javascript" src ="../UI/js/javascript.js"></script>
		<link rel="stylesheet" type="text/css" href="../UI/css/stylerec.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<title>Nombre del banco</title>
		<meta charset = "UTF-8">
		<meta name"viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimun-scale=1.0">
	</head>
	<body onload = "run()">
	
		<header >

		<div class="contenedor">
		<a   href="../"><img width = "150" src = "pictures/NombreLOGO.png"></a>
			<a href="#" class = "button" id = "login-button">Login</a>
			<span >
			
				<div id = "login"  >
					<div class="triangulo_sup"></div>
					<form >
						<label>Username</label>
						<input type = "text" name = "username" placeholder = "Username">
						<label>Password</label>
						<input type = "password" name = "password" placeholder = "password">
						<label>¿olvido su contraseña?</label>
						<input class="submit" type = "submit" name = "button-log" value="login" >
					</form>
				</div>
			</span>
		</div>
		</header>
		<div class = "contenedor con ">
		<section >

			<div id = "recuperar">
				<h1>¿Se te ha olvidado la contraseña?</h1>
				<h3>Ingresa tu ####### para poder reestablecerla.</h3>
				<form>
					<input id = "rec" class = "text"type = "text" placeholder = "####" name = "recupera">
					<input class = "submit"  type="submit" value="Siguiente">
				</form>
			</div>
			
		</section>
		</div>
		<footer >
			<div class="contenedor"> hola </div>
		</footer>
	
	</body>
</html>
