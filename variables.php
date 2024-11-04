<?php
    $ruta_archivos = '/home/downloads/'; //aqui se pone la ruta donde se guardaran los archivos del servidor
    $smtp = 'smtp-mail.outlook.com'; //servidor SMTP (recomiendo que sea de outlook el cual es: smtp-mail.outlook.com)
    $email_personal = 'emanuelcc02@hotmail.com'; //aqui se pone un correo personal del dominio
    $email_password = 'toonix'; //contraseña de dicho correo
    $cifrado = 'STARTTLS'; //cifrado que usa el servicio (si utilizas outlook el cifrado es: STARTTLS).
    $port = 587; //puerto que utiliza especificamente (si utilizas outlook el puerto es: 587)
 
    //webdav
    $userwebdav = 'cristopher';
    $pass = 1234;
    $rutaFiles = "files/";
    $rutaUsers = "users/";


    // NOTA: Es necesario investigar acerca el tema del servicio SMTP que ofrecen los diferentes proveedores como gmail, outlook etc. 
    // cada una tiene sus requerimientos especificos

    //Referencias:
        // https://www.youtube.com/watch?v=gfuuohGgD9I&t=275s
        // https://www.youtube.com/watch?v=ol0EAYvwyH4&t=1137s
?>
