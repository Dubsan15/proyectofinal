<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "192.168.1.9";
$usuario = "duban"; // Cambiar según el usuario de MariaDB
$contraseña = "123456"; // Cambiar si tienes contraseña para MariaDB
$base_de_datos = "ARTICULO";

$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>