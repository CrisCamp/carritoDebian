<?php
session_start(); //iniciar variables de sesion

// *****************************Funciones*****************************
// Dentro de las funciones es necesario agregar los includes o requires, debido a que, no se reconocen fuera
function obtenerUltimoID(){
    try {
        include('bd/bd.php');
        $sentencia = $conexion->prepare("SELECT MAX(ID) AS ultimo_id FROM tbl_reportes");
        $sentencia->execute();
        
        // Verificar si se obtuvieron resultados
        if ($sentencia->rowCount() > 0) {
            $lista_reportes = $sentencia->fetch(PDO::FETCH_ASSOC);
            // Acceder al valor del último ID
            if($lista_reportes['ultimo_id'] != null){
                return $lista_reportes['ultimo_id'];
            }else{
                return 0;
            }
        } else {
            echo "No se encontraron resultados.";
        }
    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        echo "Error: " . $e->getMessage();
    }
}

function generarNombre(){
    return 'Factura'.obtenerUltimoID().'_'.$_SESSION['usuario'].'_'.Date("Y-m-d",time()).'.pdf';
}

function insertarFactura(){
    include('bd/bd.php');
    // ***************************Insertar Factura en BDD**************************
    $usuario_ID = $_SESSION['ID'];
    $reporte = generarNombre();

    $sentencia=$conexion->prepare("INSERT INTO tbl_reportes
    (ID, usuario_ID, reporte) VALUES
    (NULL, :usuario_ID, :reporte);");

    //donde encuentres usuario_ID pon la varible $usuario_ID en la sentencia de arriba
    $sentencia->bindParam(":usuario_ID",$usuario_ID);
    //donde encuentres reporte pon la varible $reporte en la sentencia de arriba
    $sentencia->bindParam(":reporte",$reporte);

    //Ejecutar
    $sentencia->execute();
    $mensaje="Registro agregado con éxito.";
    // *****************************************************************************
}

//Esta funcion se encarga de subir los archivos desde el servidor http al servidor webdav
//Se llama en los archivos weddav.php y mails.php
function subirWebdav($filePath, $ruta){
    // Definir las variables
    include('variables.php');
    $nombreArchivo = $filePath;
    $espacio = '';
    $webdav = 'http://10.0.0.14/'.$ruta;

    $credenciales = $userwebdav.':'.$pass;

    // Construir el comando curl
    $comando = "curl --upload-file $nombreArchivo -u $credenciales $webdav";

    // Ejecutar el comando y capturar la salida
    $output = [];
    $return_var = 0;
    exec($comando, $output, $return_var);

    // Verificar si la ejecución del comando fue exitosa
    if ($return_var === 0) {
        // La operación fue exitosa
        echo 'El archivo fue subido correctamente.';
    } else {
        // Ocurrió un error
        echo 'Error al subir el archivo.';
    }
}


//*********************Registrar un nuevo usuario tipo 0***************************/
//Los usuarios tipo 0 son los que puedes realizar compras los tipo 1 son los admins

if(isset($_POST['registrar'])){
    include('bd/bd.php'); // archivo de conexion
    $usuario = (isset($_POST['new_username']))?$_POST['new_username']:"";
    $password = (isset($_POST['new_password']))?$_POST['new_password']:"";
    $correo = (isset($_POST['correo']))?$_POST['correo']:"";
    $confirmPassword = (isset($_POST['confirm_password']))?$_POST['confirm_password']:"";
    $tipo = 0;

    //***********************validar que el usuario no se repita en la bbd**************************/
    $sentencia=$conexion->prepare("SELECT *, count(*) as n_usuario 
    FROM tbl_usuarios WHERE usuario = :usuario");

    //donde encuentres usuario pon la varible $usuario en la sentencia de arriba
    $sentencia->bindParam(":usuario",$usuario);
    
    //Ejecutar
    $sentencia->execute();
    $coincidencia=$sentencia->fetch(PDO::FETCH_LAZY);

    if ($coincidencia['n_usuario'] == 0){
    //*********************************************************************************************/
        if($password == $confirmPassword){
            $sentencia=$conexion->prepare("INSERT INTO tbl_usuarios
            (ID, usuario, password, correo, tipo) VALUES 
            (NULL, :usuario, :password, :correo, :tipo);");
    
            //donde encuentres usuario pon la varible $usuario en la sentencia de arriba
            $sentencia->bindParam(":usuario",$usuario);
            //donde encuentres password pon la varible $password en la sentencia de arriba
            $sentencia->bindParam(":password",$password);
            //donde encuentres correo pon la varible $correo en la sentencia de arriba
            $sentencia->bindParam(":correo", $correo);
            //donde encuentres tipo pon la varible $tipo en la sentencia de arriba
            $sentencia->bindParam(":tipo",$tipo);
        
            //Ejecutar
            $sentencia->execute();
    
            //**********************************************************/
            require "mails.php"; 
            //Se hace llamado al archivo mails que a su vez tambien podra validar el metodo POST 
            //del archivo index.php, esto servira para enviar el correo al usuario de su registro
            //*********************************************************/
            
            $lista_usuarios=$sentencia->fetch(PDO::FETCH_LAZY);
            echo "<script>alert('Usuario registrado correctamente');</script>";
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">'; 
        }else{
            echo "<script>alert('Contraseña no coincide, intente otra vez');</script>";
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">'; 
        }
    }else{
        echo "<script>alert('Intente con otro nombre para su usuario');</script>";
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
    }
}

//**********************Inicio de sesion de usuario**************************//

if(isset($_POST['ingresar'])){
    include('bd/bd.php'); // archivo de conexion
    $usuario = (isset($_POST['usuario']))?$_POST['usuario']:"";
    $password = (isset($_POST['password']))?$_POST['password']:"";
    $sentencia=$conexion->prepare("SELECT *, count(*) as n_usuario 
    FROM tbl_usuarios WHERE usuario = :usuario AND password = :password");
    //donde encuentres usuario pon la varible $usuario en la sentencia de arriba
    $sentencia->bindParam(":usuario",$usuario);
    //donde encuentres password pon la varible $password en la sentencia de arriba
    $sentencia->bindParam(":password",$password);
    //Ejecutar
    $sentencia->execute();
    $lista_usuarios=$sentencia->fetch(PDO::FETCH_LAZY);
    if($lista_usuarios['n_usuario']>0){
        // print_r("el usuario y contraseña existe");
        if($lista_usuarios['tipo'] == 0){
            header("Location:./principal.php");
        }else if($lista_usuarios['tipo'] == 1){
            header("Location:./admin/index.php");
        }else{
            $mensaje = "Error: El usuario no puede existir";
        }
        //********************* */ Declaracion de variables de session*******************
        $_SESSION['usuario'] = $lista_usuarios['usuario'];
        $_SESSION['ID'] = $lista_usuarios['ID'];
        $_SESSION['tipo'] = $lista_usuarios['tipo'];
        $_SESSION['correo'] = $lista_usuarios['correo'];     
        //*******************************************************************************      
    }else{
        $mensaje = "Error el usuario no existe";
    }
}

if (isset($_GET['REPORTE'])){
    include('bd/bd.php');
    include('variables.php');
    $reporte = (isset($_GET['REPORTE']))?$_GET['REPORTE']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_reportes WHERE reporte=:reporte;");
    //donde encuentres txtID pon la varible $txtID en la sentencia de arriba
    $sentencia->bindParam(":reporte",$reporte);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $pdf = $registro['reporte'];

    $ruta = $ruta_archivos.$pdf;

    if(file_exists($ruta)){
        header("Content-disposition: attachment; filename=$pdf");
        header("Content-type: application/pdf");
        readfile($ruta);
    }else{
        echo "<script>alert('El archivo no existe en el servidor');</script>";
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=pedidos.php">';
    }
}//NO SE DEBE COLOCAR UN ELSE EN EL GET YA QUE EL ARCHIVO FACTURA.PHP ENVIA UN GET QUE A SU VES RECIBE ESTE ARCHIVO ESTO PROVOCARA UN ERROR LOGICO
?>
