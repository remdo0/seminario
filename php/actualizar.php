<?php
session_start();

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];

$id_reporte = $_POST['id_reporte'];
$direccion = $_POST['direccion'];
$descripcion = $_POST['descripcion'];

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

    $foto = file_get_contents($_FILES["foto"]["tmp_name"]);

    $stmt = $conn->prepare("
    UPDATE reportes
    SET direccion = ?, descripcion = ?, foto = ?
    WHERE id_reporte = ? AND id_usuario = ?
    ");

    $null = NULL;

    $stmt->bind_param(
        "ssbii",
        $direccion,
        $descripcion,
        $null,
        $id_reporte,
        $id_usuario
    );

    $stmt->send_long_data(2, $foto);

} else {

    $stmt = $conn->prepare("
    UPDATE reportes
    SET direccion = ?, descripcion = ?
    WHERE id_reporte = ? AND id_usuario = ?
    ");

    $stmt->bind_param(
        "ssii",
        $direccion,
        $descripcion,
        $id_reporte,
        $id_usuario
    );
}

if ($stmt->execute()) {

    header("Location: ../menu.php");
    exit();

} else {

    echo "Error: " . $stmt->error;

}

$stmt->close();
$conn->close();
?>