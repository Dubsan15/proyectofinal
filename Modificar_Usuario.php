<?php 
include 'conexion.php';

// Inicializar variables para el mensaje y su tipo
$mensaje = "";
$tipo_alerta = "";

// Verificar si el formulario fue enviado con método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que los campos existan y no estén vacíos antes de procesarlos
    if (isset($_POST['id'], $_POST['nombre'], $_POST['correo']) && !empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['correo'])) {
        // Obtener los datos del formulario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        // Preparar la consulta de actualización
        $sql = "UPDATE usuario SET nombre='$nombre', correo='$correo' WHERE id='$id'";

        // Ejecutar la consulta y verificar el resultado
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "Usuario modificado correctamente";
            $tipo_alerta = "success";
        } else {
            $mensaje = "Error al modificar el usuario: " . $conexion->error;
            $tipo_alerta = "danger";
        }
    } else {
        // Mensaje de error si faltan datos
        $mensaje = "Por favor, completa todos los campos.";
        $tipo_alerta = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Modificar Usuario</h1>

    <!-- Mostrar el mensaje de alerta solo si existe -->
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?= $tipo_alerta ?>" role="alert">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <form action="modificar_usuario.php" method="POST">
        <div class="mb-3">
            <label for="id" class="form-label">ID del Usuario</label>
            <input type="number" class="form-control" id="id" name="id" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nuevo Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Nuevo Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <button type="submit" class="btn btn-warning">Modificar</button>
        <!-- Botón para volver a la página anterior -->
        <a href="javascript:history.back()" class="btn btn-secondary">Volver a la Página Anterior</a>
    </form>
</div>
</body>
</html>