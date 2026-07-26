<?php
$host = "localhost";
$user = "root";
$pass = "12345678";
$database = "registros";

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>