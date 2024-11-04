<?php 
    include("../../bd/bd.php");
    if (isset($_GET['txtID'])){
        // recepcionar el txtID que se obtiene de index.php en una variable con el mismo nombre
        $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";
        // para eliminar los datos de la tabla segun su id
        $sentencia=$conexion->prepare("DELETE FROM tbl_productos WHERE id=:id;");
        //donde encuentres txtID pon la varible $txtID en la sentencia de arriba
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
    }
    //seleccionar registros
    // esta parte se encarga de extraer los datos de la bdd para luego ser mostradas en la tabla
    $sentencia=$conexion->prepare("SELECT * FROM tbl_productos;");
    $sentencia->execute();
    $lista_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    include("../bootstrap.php"); ?>

<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="../index.php">
            <img src="../../img/Ceti.webp" alt="logo" style="width:40px;">
        </a>
        <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav mr-auto">              
                <li class="nav-item">
                    <a class="nav-link" href="../../cerrar.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registros</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_productos as $registros) { ?>
                    <tr class="">
                        <td><?php echo $registros["ID"]?></td>
                        <td><?php echo $registros["nombre"]?></td>
                        <td>$<?php echo $registros["precio"]?></td>
                        <td><img width="100" src="<?php echo $registros["imagen"]?>"/></td>
                        <td>
                        <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registros['ID']; ?>" role="button">Editar</a>
                            |
                        <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $registros['ID']; ?>" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>                
            </table>
        </div>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>