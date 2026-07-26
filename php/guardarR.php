<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar que haya iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];

$direccion = $_POST['direccion'];
$descripcion = $_POST['descripcion'];
$fecha = date("Y-m-d");

// Leer la imagen
$foto = null;

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
    $foto = file_get_contents($_FILES["foto"]["tmp_name"]);
}

// Preparar consulta
$stmt = $conn->prepare("
INSERT INTO reportes
(id_usuario, direccion, fecha_r, descripcion, foto)
VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}

// Variable para el BLOB
$null = NULL;

$stmt->bind_param(
    "isssb",
    $id_usuario,
    $direccion,
    $fecha,
    $descripcion,
    $null
);

// Enviar la imagen al quinto parámetro (índice 4)
$stmt->send_long_data(4, $foto);

if ($stmt->execute()) {

    header("Location: ../menu.php");
    exit();

} else {

    echo "Error al guardar: " . $stmt->error;

}

$stmt->close();
$conn->close();
?>