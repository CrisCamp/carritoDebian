<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    include('variables.php'); //se hace el llamado a las variables de entorno

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = 2;                      //esta linea me permite ver el proceso de envio
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $smtp;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $email_personal;                     //SMTP username
        $mail->Password   = $email_password;                               //SMTP password
        $mail->SMTPSecure = $cifrado;            //Enable implicit TLS encryption
        $mail->Port       = $port;

        //*************************correo para enviar archivo de pedido a los usuarios*************************
        if (isset($_GET['ENVIAR'])){
            include('funciones.php'); //se llama al archivo para usar las variables de session además de algunas funciones
            $mail->setFrom($email_personal, 'Agradecemos su preferencia');
            $mail->AddAddress($_SESSION['correo']);
            $inMailFileName = ''.$_SESSION['correo'].'@tienda.pdf';
            $filePath = $ruta_archivos.generarNombre();
            if ($mail->AddAttachment($filePath, $inMailFileName)) {
		subirWebdav($filePath,$rutaFiles); //subir archivo a webdav
                insertarFactura(); //al asegurarse de que "el archivo" se haya encontrado la factura(el archivo) se debe insertar en la bdd
            } else {
                echo "Hubo un error al cargar archivo adjunto.";
            }
            $mail->isHTML(true);
            $mail->Subject = 'Pedido reservado con exito';
            $mail->Body = 'Le enviamos su factura de compra con fecha '.Date("Y-m-d",time()).'';
            $mail->send();
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=webdav.php">'; 
        }

        //******************************correo para usuarios recien registrados*********************************
        if (isset($_POST['registrar']))
	    {
            $username = $_POST['new_username'];
            $mail->setFrom($email_personal, '¡Bienvenido a la tienda de Cris!');
            $mail->AddAddress($_POST['correo']);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmacion creacion de cuenta';
            $mail->Body = 'Le damos la bienvenida a la tienda de Cris ('.$username.'), su mejor elección en artículos random.';
            $mail->send();
        }
        
    } catch (Exception $e) {
        echo 'Mensaje ' . $mail->ErrorInfo;
        //esta redireccion es importante porque impide que el usuario vuelva a pedir otra factura
        //debido a que el llamado en la funcion insertarFactura() crea un nuevo valor en la tabla de facturas
        //generarNombre() obtiene el ultimo valor de un archivo creado y por lo tanto no encuentra el archivo

        //para el correo de registro no hay que preocuparse si falla, ya que al redireccionar a principal 
        //(que en teoria es la pagina que ingresas despues de logerte), dicha pagina tiene una validacion no
        //permite ingresar a los usuarios no logeados redireccionando a index 
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=principal.php">'; 
    }
?>
