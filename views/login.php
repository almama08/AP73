<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<h1>Iniciar sesión</h1>

    <?php if(isset($error)): ?>
        <p style='color: red;'>Error: <?= $error ?></p>
    <?php endif; ?>

	<form method="POST">
		<p>Email:</p>
		<input type="email" name="email" required><br>

		<p>Contraseña:</p>
		<input type="password" name="password" required minlength="4"><br><br>

		<button type="submit">Acceder</button>
	</form>

	<p>¿No tienes cuenta? <a href="index.php?accion=registroUsuario">Crear cuenta</a></p>
	<a href="index.php">Volver al inicio</a>
</body>
</html>