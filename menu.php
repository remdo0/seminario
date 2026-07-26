<?php
session_start();

$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM reportes ORDER BY fecha_r DESC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="estilos/estilo3.css" />
</head>
<body>

<img src="imagenes/banner.jpg" class="banner" alt="banner">

<div class="pagina">

    <div class="columna-izquierda">
        <h1 class="titulo">Reportes de Abandono</h1>

        <div class="lista-reportes">

        <?php

        if($resultado->num_rows > 0){

            while($reporte = $resultado->fetch_assoc()){

                echo "<div class='reporte'>";

                echo "<p><strong>Dirección:</strong> ".htmlspecialchars($reporte['direccion'])."</p>";

                echo "<p><strong>Fecha:</strong> ".$reporte['fecha_r']."</p>";

                echo "<p><strong>Descripción:</strong> ".nl2br(htmlspecialchars($reporte['descripcion']))."</p>";

                // Mostrar imagen guardada como BLOB
                if(!empty($reporte['foto'])){
                    echo "<img src='data:image/jpeg;base64," .
                    base64_encode($reporte['foto']) .
                    "' width='200'>";
                }

                // Solo el dueño del reporte puede modificar o eliminar
                if (isset($_SESSION['id_usuario']) &&
    $_SESSION['id_usuario'] == $reporte['id_usuario']) {

    echo "<br><br>";

    echo "<a href='editar.php?id=".$reporte['id_reporte']."'>
            <button>Modificar</button>
          </a>";

    echo "<a href='php/eliminar.php?id=".$reporte['id_reporte']."'
            onclick=\"return confirm('¿Eliminar este reporte?');\">
            <button>Eliminar</button>
          </a>";
}

                echo "</div><br>";

            }

        }else{

            echo "<p>No hay reportes registrados.</p>";

        }

        ?>

        </div>
    </div>

    <div class="columna-derecha">

        <div class="logo-circulo">
            <img src="imagenes/logo.png" width="120" height="120">
        </div>

        <div class="nav-botones">
            <a href="perfil.php"><button class="btn-nav">Perfil</button></a>
            <a href="subirr.php"><button class="btn-nav">Subir reporte</button></a>
            <a href="refugio.html"><button class="btn-nav">Refugio</button></a>
        </div>
     
    </div>

</div>

</body>
</html>