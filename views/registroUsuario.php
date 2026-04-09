<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dar de alta un usuario</title>
</head>
<body>
	<h1>Crear cuenta de usuario</h1>

	<form method="POST">
		<p>Email:</p>
		<input type="email" name="email" required><br>

		<p>Contraseña:</p>
		<input type="password" name="password" required minlength="4"><br><br>

		<button type="submit">Crear cuenta</button>
	</form>

	<p>¿Ya tienes cuenta? <a href="index.php?accion=login">Iniciar sesión</a></p>
	<a href="index.php">Volver al inicio</a>
</body>
</html>