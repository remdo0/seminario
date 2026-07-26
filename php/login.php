<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = ?");

if (!$stmt) {
    die("Error en prepare(): " . $conn->error);
}

$stmt->bind_param("s", $usuario);
$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    if ($contrasena == $fila['contrasena']) {

    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['nombre'] = $fila['nombre'];

    header("Location: ../menu.php");
    exit();

    } else {

        echo "Contraseña incorrecta";

    }

} else {

    echo "El usuario no existe";

}


$stmt->close();
$conn->close();

?>