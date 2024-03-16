<?php
session_start();
if (isset($_SESSION['lastInsertId']) && isset($_SESSION['correo'])) {
    $lastInsertId = $_SESSION['lastInsertId'];
    $correo = $_SESSION['correo'];
}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Llamar el PHPMailer
require '../lib/PHPMailer/Exception.php';
require '../lib/PHPMailer/PHPMailer.php';
require '../lib/PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Establecer la codificación
    $mail->CharSet = 'UTF-8'; // Establece la codificación a UTF-8

    // Configuración del servidor
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'felipe10espinosa@gmail.com';
    $mail->Password   = 'jtva wudg iwah gzzy';                  //SMTP password (tu contraseña de Gmail - Contraseña de Aplicaciones)
    $mail->Port = 587;

    // Configuración de remitentes y contenido
    $mail->setFrom('felipe10espinosa@gmail.com', 'Felipe Espinosa Castano');
    $mail->addAddress($correo);
    $mail->isHTML(true);
    $mail->Subject = 'Generación de Ticket';

    // Ruta de la imagen que deseas incrustar (reemplaza 'ruta_de_la_imagen.png' con la ruta de tu imagen)
    $imagePath = '../public/img/Logo-Tigo.png';
    $imageName = 'Logo-Tigo.png'; // Nombre de la imagen adjunta

    // Adjuntar la imagen al correo (FUNCIONAL)
    // $mail->addStringAttachment(file_get_contents($imagePath), $imageName, 'base64', 'image/png'); 

    // En el contenido del correo, utiliza el CID de la imagen para incrustarla
    $bodyEmail = '
<!DOCTYPE html>
<html>

<head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

#container-body {
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #007bff;
}

h4 {
    color: #333;
}

p {
    line-height: 1.4;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}

.footer {
    display: flex;
    align-items: center; /* Centra verticalmente los elementos */
}

.footer img {
    max-width: 100px;
    height: auto;
    margin-right: 20px; /* Agrega un margen entre la imagen y el texto */
}
</style>
</head>

<body>
    <div id="container-body">
        <div>
            <h1>Hola, ¡Hemos recibido con éxito tu incidencia!</h1>
            <h4><b>Tu número de incidencia: #' . $lastInsertId . '</b></h4>
            <p>
                Nuestro equipo de desarrollo revisará y validarás tu caso lo más pronto posible.
                Te recomendamos que consultes el estado de tus incidencias en momentos posteriores
                para verificar si han sido resueltas con éxito. En caso contrario, no dudes en
                ponerte en contacto con nosotros al realizar una devolución, para que podamos
                brindarte la mejor atención posible.
            </p>
            Cordialmente,
            <div class="footer">
                <img src="../public/img/Logo-Tigo.png" alt="Logo Tigo">
                <ul>
                    <li>Felipe Espinosa Castaño</li>
                    <li>Diseñador de Contenidos</li>
                    <li>Aprendizaje Productivo</li>
                    <li>Email: felipe.espinosac@tigo.com.co</li>
                    <li>Celular: (57) 301 591 05 77</li>
                    <li>Ubicación: Medellin - Colombia</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
';

    $mail->Body = $bodyEmail;

    // Envía el correo sin mostrar salida en pantalla
    ob_start();
    $mail->send();
    ob_end_clean();

    // Restablece la lista de adjuntos (importante para futuros envíos)
    $mail->clearAttachments();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <div class="container">
        <div class="imgs-finish">
            <img src="../public/img/icono-de-revisado.png" alt="" class="img-finaly">
            <img src="../public/img/Logo-Tigo.png" alt="" class="logo">
            <div class="container-text">
                <h1 class="text-finaly">Hemos tomado con éxito tu caso</h1>
            </div>
        </div>

        <div class="finaly">
            <input type="" class="message" name="message" readonly value="#<?php echo $lastInsertId ?>">
        </div>


        <footer class="parragraf" id="parra-finaly">
            <p>
                Esta información es generada para las personas vinculadas a Tigo y el personal de proveedores de
                Colombia Móvil S.A. ESP y/o UNE EPM Telecomunicaciones
                S.A., para el adecuado desarrollo de las actividades en virtud del objeto del contrato, sin que
                dicha
                situación genere un vínculo laboral.
            </p>
        </footer>

    </div>
</body>

</html>