<html>
    <head>
        <title>Lista de vehículos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
<body>
    <?='<h1>Lista de vehículos disponibles</h1>'?>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        Bienvenido, <?= $_SESSION['usuario_email'] ?>
        <a href='index.php?accion=logout'>Cerrar sesión</a><br>
        <a href="index.php?accion=alta">Añadir Nuevo Vehículo</a><br>
    <?php else: ?>
        <a href="index.php?accion=registroUsuario">Registrarse</a><br>
        <a href="index.php?accion=login">Iniciar sesión</a><br>
    <?php endif; ?>

    
    
    <div class="container-fluid">
        <?='<table class="table table-striped">';?>
        <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Matrícula</th>
                    <th>Precio/Día</th>
                    <th>Alquiler (7 días)</th>

                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <th>Opciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
        <?php foreach($lista as $vehiculo):?>
            <tr>
                <td><?=$vehiculo->getMarca()?></td>
                <td><?=$vehiculo->getModelo()?></td>
                <td><?=$vehiculo->getMatricula()?></td>
                <td><?=$vehiculo->getPrecioDia()?></td>
                <td>
                    <?=$vehiculo->calcularAlquiler(7)?>€
                </td>
                <?php if(isset($_SESSION['usuario_id'])): ?>
                <td>
                    <a href='index.php?accion=baja&matricula=<?=$vehiculo->getMatricula()?>'>
                        Eliminar
                    </a>
                </td>
                <td>
                    <a href="index.php?accion=editar&matricula=<?= $vehiculo->getMatricula() ?>">
                        Editar
                    </a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach;?>
        </table>
    </div>
</body>
</html>