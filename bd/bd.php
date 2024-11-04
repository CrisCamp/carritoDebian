<?php
    $servidor = "192.168.1.2";
    $baseDeDatos="tienda";
    $usuario = "admin";
    $contrasenia = "1234";
    try{
        $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
        // echo "Conexión realizada....";
    }catch(Exception $error){
        echo $error->getMessage();
        echo "<script>alert('No se pudo realizar la conexion a la bdd(servidor)');</script>";
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
    }
?>
