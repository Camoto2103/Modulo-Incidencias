<?php
session_start();

if (isset($_SESSION["cedula"])) {
    $cedula = $_SESSION["cedula"];
    $formDisplay = "none";
    $secondFormDisplay = "block";
} else {
    $formDisplay = "block";
    $secondFormDisplay = "none";
}

unset($_SESSION["cedula"]);

echo '<script>var formDisplay = "' . $formDisplay . '";</script>';
echo '<script>var secondFormDisplay = "' . $secondFormDisplay . '";</script>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="imgs">
            <img src="../public/img/Logo-Tigo.png" alt="" class="logo">
            <img src="../public/img/Imagen-interna.png" alt="Ayuda a la mano" class=img-principal>
        </div>

        <div id="first-form" style="display: <?php echo $formDisplay; ?>;">
            <form action="../Controllers/validate_cedula.php" method="post" class="form-cedula">
                <div class="buscar_cedula">
                    <div class="input-juntos">
                        <input type="text" name="cedula" id="cedula" placeholder="Cédula" class="input-cedula">
                        <button class="search_lupa" id="validar-cedula">
                            <img src="../public/img/Icono-Lupa-Azul.png" alt="" class="lupa">
                        </button>
                    </div>
                </div>
                <div class="inputs">
                    <input type="" id="" class="input">
                    <input type="" placeholder="Correo" class="input" disabled>
                    <select class="select-multimedia" disabled>
                        <option value="" disabled selected>Seleccione una multimedia</option>
                    </select>
                    <input type="text" placeholder="URL" class="input" disabled>
                    <textarea class="descripcion" cols="30" rows="10" placeholder="Descripción con Fecha-Hora y Usuario y cedula del afectado" disabled></textarea>
                    <div class="box">
                        <div class="file-select" id="src-file1">
                            <input ref={fileInputRef} // Asignar la referencia al input de tipo file type="file" name="adjunto" aria-label="Archivo" / disabled>
                        </div>
                        <input type="submit" value="Compartir" class="button" disabled>
                    </div>
                </div>
            </form>
            <div class="parraf">
                <p>
                    Esta información es generada para las personas vinculadas a Tigo y el personal de proveedores de
                    Colombia Móvil S.A. ESP y/o UNE EPM Telecomunicaciones
                    S.A., para el adecuado desarrollo de las actividades en virtud del objeto del contrato, sin que
                    dicha
                    situación genere un vínculo laboral.
                </p>
            </div>
        </div>


        <div id="second-form" style="display: <?php echo $secondFormDisplay; ?>;">
            <form action="../Controllers/insert_Form.php" method="POST" class="form-container" id="formulario" enctype="multipart/form-data">
                <div class="inputs">
                    <input type="text" name="cedula" class="input" value="<?php echo $cedula; ?>" readonly>
                    <input type="email" name="correo" id="email" placeholder="Correo" class="input">
                    <select name="multimedia" id="multimedia" class="select-multimedia">
                        <option value="" disabled selected>Seleccione una multimedia</option>
                        <option value="AMS GESTION">AMS GESTION</option>
                        <option value="TRAINERS">TRAINERS</option>
                        <option value="FAVORITOS HOGAR">FAVORITOS HOGAR</option>
                        <option value="CANALES">CANALES</option>
                    </select>
                    <input type="text" name="url" id="url" placeholder="URL" class="input">
                    <textarea name="descripcion" id="descripcion" class="descripcion" cols="30" rows="10" placeholder="Descripción con Fecha-Hora y Usuario y cedula del afectado">
                    </textarea>
                    <div class="box">
                        <div class="file-select" id="src-file1">
                            <input ref={fileInputRef} type="file" id="adjunto" name="adjunto" aria-label="Archivo" accept=".jpg, .png, .mp4, .mov" />
                        </div>
                        <input type="submit" value="Compartir" class="button">
                    </div>
                </div>
            </form>
            <div class="parraf">
                <p>
                    Esta información es generada para las personas vinculadas a Tigo y el personal de proveedores de
                    Colombia Móvil S.A. ESP y/o UNE EPM Telecomunicaciones
                    S.A., para el adecuado desarrollo de las actividades en virtud del objeto del contrato, sin que
                    dicha
                    situación genere un vínculo laboral.
                </p>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/inputs.js"></script>
</body>

</html>