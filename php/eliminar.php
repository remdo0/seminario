<?php
session_start();

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión.");
}

if (!isset($_GET['id'])) {
    die("Reporte no especificado.");
}

$id_reporte = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

// Solo elimina si el reporte pertenece al usuario
$stmt = $conn->prepare("DELETE FROM reportes WHERE id_reporte = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_reporte, $id_usuario);

if ($stmt->execute()) {

    header("Location: ../menu.php");
    exit();

} else {

    echo "Error al eliminar.";

}

$stmt->close();
$conn->close();
?>