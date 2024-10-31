<?php
// Conexión a la base de datos
include 'conexion.php';
 // Archivo donde está configurada la conexión

// Inicializar variables para mensaje y tipo de alerta
$mensaje = "";
$tipo_alerta = "";

// Verificar si se ha enviado una solicitud POST para eliminar un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];

    // Verificar que se haya seleccionado un usuario
    if (empty($usuario_id)) {
        $mensaje = "Por favor, selecciona un usuario para eliminar.";
        $tipo_alerta = "danger"; // Alerta de error
    } else {
        // Preparar la consulta para eliminar el usuario
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE ID = ?");
        
        if ($stmt) {  // Verificar si la consulta fue preparada correctamente
            $stmt->bind_param("i", $usuario_id); // "i" es para el tipo de dato integer

            // Ejecutar la consulta
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensaje = "Usuario eliminado exitosamente.";
                    $tipo_alerta = "success"; // Alerta de éxito
                } else {
                    $mensaje = "No se encontró el usuario.";
                    $tipo_alerta = "danger"; // Alerta de error
                }
            } else {
                $mensaje = "Error al eliminar el usuario: " . $stmt->error;
                $tipo_alerta = "danger"; // Alerta de error
            }

            $stmt->close(); // Cerrar la declaración
        } else {
            $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
            $tipo_alerta = "danger"; // Alerta de error
        }
    }
}

// Consultar todos los usuarios para mostrarlos en una lista
$consulta_usuarios = "SELECT id, nombre FROM Usuarios";
$resultado = $conexion->query($consulta_usuarios);

// Cerrar la conexión después de todas las operaciones
$conexion->close();
?>

<!-- HTML para el formulario de eliminación de usuarios -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Usuario</h2>

        <!-- Mostrar mensaje de alerta si existe -->
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipo_alerta; ?>"><?= $mensaje; ?></div>
        <?php endif; ?>

        <form action="Eliminar_Usuario.php" method="POST">
            <div class="form-group">
                <label for="usuario_id">Selecciona un usuario para eliminar:</label>
                <select class="form-control" id="usuario_id" name="usuario_id" required>
                    <option value="">-- Selecciona un usuario --</option>
                    <?php
                    // Mostrar los usuarios en la lista desplegable
                    if ($resultado->num_rows > 0) {
                        while ($usuario = $resultado->fetch_assoc()) {
                            echo "<option value='" . $usuario['id'] . "'>" . $usuario['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay usuarios disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Eliminar Usuario</button>
            <a href="index.php" class="btn btn-secondary mt-3">Volver a la Página Principal</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>