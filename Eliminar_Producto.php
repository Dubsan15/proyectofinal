<?php
// Conexión a la base de datos
include 'conexion.php';
 // Archivo donde está configurada la conexión

// Inicializar variables para mensaje y tipo de alerta
$mensaje = "";
$tipo_alerta = "";

// Verificar si se ha enviado una solicitud POST y si 'producto_id' está definida
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Verificar que se haya seleccionado un producto
    if (empty($producto_id)) {
        $mensaje = "Por favor, selecciona un producto para eliminar.";
        $tipo_alerta = "danger"; // Alerta de error
    } else {
        // Preparar la consulta para eliminar el producto
        $stmt = $conexion->prepare("DELETE FROM articulo WHERE ID = ?");
        
        if ($stmt) {  // Verificar si la consulta fue preparada correctamente
            $stmt->bind_param("i", $producto_id); // "i" es para el tipo de dato integer

            // Ejecutar la consulta
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensaje = "Producto eliminado exitosamente.";
                    $tipo_alerta = "success"; // Alerta de éxito
                } else {
                    $mensaje = "No se encontró el producto.";
                    $tipo_alerta = "danger"; // Alerta de error
                }
            } else {
                $mensaje = "Error al eliminar el producto: " . $stmt->error;
                $tipo_alerta = "danger"; // Alerta de error
            }

            $stmt->close(); // Cerrar la declaración
        } else {
            $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
            $tipo_alerta = "danger"; // Alerta de error
        }
    }
}

// Consultar todos los productos para mostrarlos en una lista desplegable
$consulta_productos = "SELECT id, nombre_producto FROM Productos";
$resultado = $conexion->query($consulta_productos);

// Cerrar la conexión después de todas las operaciones
$conexion->close();
?>

<!-- HTML para el formulario de eliminación de productos -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Producto</h2>

        <!-- Mostrar mensaje de alerta si existe -->
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipo_alerta; ?>"><?= $mensaje; ?></div>
        <?php endif; ?>

        <form action="eliminar_Producto.php" method="POST">
            <div class="form-group">
                <label for="producto_id">Selecciona un producto para eliminar:</label>
                <select class="form-control" id="producto_id" name="producto_id" required>
                    <option value="">-- Selecciona un producto --</option>
                    <?php
                    // Mostrar los productos en la lista desplegable
                    if ($resultado->num_rows > 0) {
                        while ($producto = $resultado->fetch_assoc()) {
                            echo "<option value='" . $producto['id'] . "'>" . $producto['nombre_producto'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay productos disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Eliminar Producto</button>
            <a href="index.php" class="btn btn-secondary mt-3">Volver a la Página Principal</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>