<?php
session_start();


$conn = new mysqli("localhost", "root", "12345678", "registros");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION['id_usuario'])) {
    header("Location: inicios.html");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener los reportes del usuario
$stmt = $conn->prepare("SELECT * FROM reportes WHERE id_usuario = ? ORDER BY fecha_r DESC");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$reportes = $stmt->get_result();

$total_reportes = $reportes->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="estilos/estilo4.css" >
          <style>.nav-botones {
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: 100%;
}

.btn-nav {
  width: 100%;
  padding: 12px 0;
  border: none;
  border-radius: 50px;
  background: #e8a87c;
  color: white;
  font-size: 15px;
  font-weight: 400;
  cursor: pointer;
  transition: opacity 0.2s;
}

.btn-nav:hover {
  opacity: 0.88;
}</style>
</head>
<body>

   <img src="imagenes/banner.jpg" class="banner"alt="banner">

  <div class="pagina">

    <div class="columna-izquierda">

      <div class="tarjeta-bienvenida">
        <div class="bienvenida-izq">
<h2 class="saludo">
    ¡Hola! 🐾
</h2>
          <p class="sub-saludo">Tu compromiso ayuda a crear comunidades más seguras para nuestras mascotas.</p>
        </div>
        <div class="bienvenida-stats">
          <div class="stat">
            <span class="stat-icono">📋</span>
            <div>
              <p class="stat-label">Reportes publicados</p>
              <p class="stat-numero"><?php echo $total_reportes; ?></p>
              <p class="stat-sub">Gracias por tu ayuda</p>
            </div>
          </div>
          <div class="stat">
            <span class="stat-icono">🛡️</span>
            <div>
              <p class="stat-desc">Cada reporte que compartes puede hacer la diferencia. 🐾</p>
            </div>
          </div>
        </div>
      </div>

    <div class="seccion-reportes">

    <h3 class="titulo-reportes">Mis Reportes 🐾</h3>
    <p class="sub-reportes">
        Aquí puedes ver y gestionar los reportes que has compartido.
    </p>

    <div class="lista-reportes">

    <?php

    if($reportes->num_rows > 0){

        while($reporte = $reportes->fetch_assoc()){

            echo "<div class='reporte'>";

            if(!empty($reporte['foto'])){
                echo "<img src='data:image/jpeg;base64," .
                base64_encode($reporte['foto']) .
                "' width='120'>";
            }

            echo "<div class='reporte-info'>";
            echo "<p><strong>Dirección:</strong> ".htmlspecialchars($reporte['direccion'])."</p>";
            echo "<p><strong>Descripción:</strong> ".htmlspecialchars($reporte['descripcion'])."</p>";
            echo "<p><strong>Fecha:</strong> ".$reporte['fecha_r']."</p>";
            echo "</div>";

            echo "</div>";

        }

    }else{

        echo "<p>Aún no has publicado reportes.</p>";

    }

    ?>

    </div>

</div>

</div> <!-- columna-izquierda -->


<div class="columna-derecha">

        <div class="logo-circulo">
            <img src="imagenes/logo.png" width="120" height="120" alt="Logo">
        </div>

        <div class="nav-botones">
              <a href="php/logout.php">
                <button class="btn-nav">Cerrar sesión</button>
            </a>
        <a href="menu.php"><button class="btn-nav">Volver al menú</button></a>
    </div>

    </div>
</body>
</html>