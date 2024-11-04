<?php
    session_start();

    //llamdo de bdd, funcion subirWebdav($parametro) y  variable $ruta_archivos (donde se guardan los archivos del servidor)
    include('bd/bd.php');
    include('funciones.php');
    include('variables.php');
    
    //declaracion de variables ( session y credenciales webdav)
    $ID = $_SESSION['ID'];
    $user = $_SESSION['usuario'];
    $correo = $_SESSION['correo'];

    $sentencia=$conexion->prepare("SELECT * FROM tbl_reportes WHERE usuario_ID = :ID;");
    $sentencia->bindParam(":ID",$ID);
    $sentencia->execute();
    $lista_reportes=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $lista_json = json_encode($lista_reportes, JSON_UNESCAPED_UNICODE);
    $nombre_archivo = $correo.'_'.$user.'.json'; //nombre archivo
    $file_name = $ruta_archivos.$nombre_archivo; //ruta completa archivo

    if(file_put_contents($file_name, $lista_json) ==! false){
        echo 'Correcto';

	//se envia el archivo a la ruta de archivos en webdav
	subirWebdav($file_name, $rutaUsers);

	//$url_redireccion = 'https://' . $userwebdav . ':' . $pass . '@webdav2.cris.com/users?enviar=' . $nombre_archivo;
	$url_redireccion = 'https://webdav2.cris.com/pedidos?enviar=' . $nombre_archivo;
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=' . $url_redireccion . '">';
    }else{
	echo 'error';
    }
    //$lista_codificada = urlencode($lista_json);
    //$url_redireccion = 'https://' . $userwebdav . ':' . $pass . '@webdav2.cris.com/users?enviar=' . $lista_codificada;
    //echo $url_redireccion;
   // echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=' . $url_redireccion . '">';
?>
