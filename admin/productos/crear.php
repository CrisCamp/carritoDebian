<?php 
include("../../bd/bd.php");

if($_POST){
    $nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";
    $precio = (isset($_POST['precio']))?$_POST['precio']:"";
    $imagen = (isset($_POST['imagen']))?$_POST['imagen']:"";

    // Definir 
    $sentencia=$conexion->prepare("INSERT INTO tbl_productos 
    (ID, nombre, precio, imagen) VALUES 
    (NULL, :nombre, :precio, :imagen);");

    //donde encuentres nombre pon la varible $nombre en la sentencia de arriba
    $sentencia->bindParam(":nombre",$nombre);
    //donde encuentres precio pon la varible $precio en la sentencia de arriba
    $sentencia->bindParam(":precio",$precio);
    //donde encuentres imagen pon la varible $imagen en la sentencia de arriba
    $sentencia->bindParam(":imagen",$imagen);

    //Ejecutar
    $sentencia->execute();
    $mensaje="Registro agregado con éxito.";
    header("Location:index.php?mensaje=".$mensaje);
}

include("../bootstrap.php"); ?>
<div class="card">
    <div class="card-header">
        Productos
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text"
                class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
            </div>

            <div class="mb-3">
              <label for="precio" class="form-label">Precio:</label>
              <input type="text"
                class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="Precio">
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <input type="text"
                class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>