<?php 
    include("../../bd/bd.php");
    // Al presionar el boton editar en index.php se hace esta evaluación
    if (isset($_GET['txtID'])){
        // recepcionar el txtID que se obtiene de index.php en una variable con el mismo nombre 
        $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";
        $sentencia=$conexion->prepare("SELECT * FROM tbl_productos WHERE id=:id;");
        //donde encuentres txtID pon la varible $txtID en la sentencia de arriba
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);

        // $txtID = $registro['ID']; ya no es necesario hacer esto porque el metodo get ya nos da el valor
        $nombre = $registro['nombre'];
        $precio = $registro['precio'];
        $imagen = $registro['imagen'];
    }

    if($_POST){
        $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
        $nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";        
        $precio = (isset($_POST['precio']))?$_POST['precio']:"";
        $imagen = (isset($_POST['imagen']))?$_POST['imagen']:"";
    
        //la variable conexion se toma del documento bd.php
        $sentencia=$conexion->prepare("UPDATE tbl_productos SET
        nombre = :nombre, precio = :precio, imagen = :imagen WHERE ID =:id;");
        $sentencia->bindParam(":id",$txtID);
        //donde encuentres nombre pon la varible $nombre en la sentencia de arriba
        $sentencia->bindParam(":nombre",$nombre);
        //donde encuentres precio pon la varible $precio en la sentencia de arriba
        $sentencia->bindParam(":precio",$precio);
        //donde encuentres imagen pon la zzvarible $imagen en la sentencia de arriba
        $sentencia->bindParam(":imagen",$imagen);
        $sentencia->execute();

        $mensaje="Registro modificado con éxito.";
        header("Location:index.php?mensaje=".$mensaje);
    }    

    include("../bootstrap.php"); 
?>

<div class="card">
    <div class="card-header">
        Entradas
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="txtID" class="form-label">ID</label>
              <input readonly value= "<?php echo $txtID;?>" type="text"
                class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" value="<?php echo $nombre?>"
                class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Titulo">
            </div>

            <div class="mb-3">
              <label for="precio" class="form-label">Precio:</label>
              <input type="text" value="<?php echo $precio?>"
                class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="Descripcion">
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <img width="100" src="../../img/<?php echo $imagen;?>"/>
              <input type="text"
                class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>