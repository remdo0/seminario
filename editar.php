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
    die("Reporte no encontrado.");
}

$id_reporte = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

$stmt = $conn->prepare("SELECT * FROM reportes WHERE id_reporte = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_reporte, $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("No tienes permiso para editar este reporte.");
}

$reporte = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar reporte</title>
</head>
<body>

<h2>Editar reporte</h2>

<form action="php/actualizar.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id_reporte" value="<?php echo $reporte['id_reporte']; ?>">

    <label>Dirección</label><br>
    <input type="text"
           name="direccion"
           value="<?php echo htmlspecialchars($reporte['direccion']); ?>"
           required><br><br>

    <label>Descripción</label><br>

    <textarea
        name="descripcion"
        required><?php echo htmlspecialchars($reporte['descripcion']); ?></textarea>

    <br><br>

    <label>Nueva foto (opcional)</label><br>
    <input type="file" name="foto">

    <br><br>

    <button type="submit">Guardar cambios</button>

</form>

</body>
</html>