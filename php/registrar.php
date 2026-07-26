<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("sss", $usuario, $correo, $contrasena);

if ($stmt->execute()) {
    header("Location: ../menu.php");
    exit();
} else {
    echo "Error al registrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>