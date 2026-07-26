<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link rel="stylesheet" href="estilos/estilo5.css" >
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

<img src="imagenes/banner.jpg" class="banner" alt="banner">

<div class="pagina">

    <div class="columna-izquierda">

        <h1 class="titulo">Subir nuevo reporte</h1>
        <p class="subtitulo">
            Ayúdanos a encontrarles un hogar. Completa la información del animal que encontraste.
        </p>

        <form action="php/guardarR.php"
              method="POST"
              enctype="multipart/form-data">

            <div class="formulario-card">

                <!-- Dirección -->
                <div class="seccion">

                    <div class="seccion-header">
                        <div>
                            <p class="seccion-titulo">Dirección</p>
                            <p class="seccion-desc">
                                Ingresa el lugar exacto donde fue encontrado el animal.
                            </p>
                        </div>
                    </div>

                    <input
                        type="text"
                        class="input-texto"
                        name="direccion"
                        placeholder="Ej. Parque Central, Calle 10 con Av. 5"
                        required>

                </div>

                <hr class="divisor">

                <!-- Descripción -->
                <div class="seccion">

                    <div class="seccion-header">
                        <div>
                            <p class="seccion-titulo">Descripción del animal</p>
                            <p class="seccion-desc">
                                Cuéntanos cómo es el animal, su comportamiento o cualquier detalle importante.
                            </p>
                        </div>
                    </div>

                    <textarea
                        class="input-area"
                        name="descripcion"
                        placeholder="Ej. Es un perro mediano, color café claro, muy amigable..."
                        required></textarea>

                </div>

                <hr class="divisor">

                <!-- Foto -->
                <div class="seccion">

                    <div class="seccion-header">
                        <div>
                            <p class="seccion-titulo">Subir foto</p>
                            <p class="seccion-desc">
                                Agrega una foto clara del animal para que más personas puedan ayudar.
                            </p>
                        </div>
                    </div>

                    <label class="zona-carga" for="inputFoto">

                        <input
                            type="file"
                            id="inputFoto"
                            name="foto"
                            accept=".jpg,.jpeg,.png"
                            hidden
                            required>

                        <p class="carga-texto">Haz clic para seleccionar una foto</p>
                        <p class="carga-sub">o arrastra la imagen aquí</p>
                        <p class="carga-formatos">
                            Formatos permitidos: JPG, PNG. Máx. 5MB
                        </p>

                    </label>

                    <img id="vistaPrevia"
                         src=""
                         alt="Vista previa"
                         style="display:none; max-width:300px; margin-top:15px; border-radius:10px;">

                </div>

            </div>

            <button type="submit" class="btn-subir">
                Subir reporte
            </button>

        </form>

    </div>

    <!-- Columna derecha -->

    <div class="columna-derecha">

        <div class="logo-circulo">
            <img src="imagenes/logo.png" width="120" height="120" alt="Logo">
        </div>
           <div class="nav-botones">
        <a href="menu.php"><button class="btn-nav">Volver al menú</button></a>
    </div>

    </div>

</div>

<script>
const inputFoto = document.getElementById("inputFoto");
const vistaPrevia = document.getElementById("vistaPrevia");

inputFoto.addEventListener("change", function () {

    const archivo = this.files[0];

    if (archivo) {
        const lector = new FileReader();

        lector.onload = function(e) {
            vistaPrevia.src = e.target.result;
            vistaPrevia.style.display = "block";
        }

        lector.readAsDataURL(archivo);
    }

});
</script>

</body>
</html>