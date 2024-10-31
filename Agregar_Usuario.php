<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Agregar Nuevo Usuario</h1>
    
    <?php
    // Inicializar mensaje de estado
    $mensaje = '';

    // Comprobar si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recoger y sanitizar datos
        $nombre = htmlspecialchars(trim($_POST['Nombre']));
        $correo = htmlspecialchars(trim($_POST['Correo']));

        // Preparar la consulta de inserción
        $stmt = $conexion->prepare("INSERT INTO usuario (Nombre, Correo) VALUES (?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ss", $nombre, $correo); // "ss" significa que ambos parámetros son strings

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $mensaje = "<div class='alert alert-success' role='alert'>Usuario agregado correctamente</div>";
            } else {
                $mensaje = "<div class='alert alert-danger' role='alert'>Error al agregar el usuario: " . $stmt->error . "</div>";
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            $mensaje = "<div class='alert alert-danger' role='alert'>Error en la preparación de la consulta: " . $conexion->error . "</div>";
        }
    }
    ?>

    <!-- Mostrar mensaje de estado -->
    <?php if ($mensaje): ?>
        <?php echo $mensaje; ?>
    <?php endif; ?>

    <!-- Formulario de agregar usuario -->
    <form action="Agregar_usuario.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
    </form>

    <!-- Botón para volver a la página principal -->
    <a href="index.php" class="btn btn-secondary mt-3">Volver a la página principal</a>
</div>

<?php
// Cerrar la conexión
$conexion->close();
?>
</body>
</html>