<?php
    session_start();

    if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 0){
        header("Location:./principal.php");
    }else if(isset($_SESSION['usuario']) && $_SESSION['tipo'] == 1){
        header("Location:./admin/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
  <header>
  </header>
  <main>
    <div class="container">
      <div class="row">
            <div class="col-3">
            </div>
            <div class="col-6">
                <br><br><!--saltos de linea para dar estatica -->
                <!-- alerta fuera del card -->
                <?php if(isset($mensaje)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><?php echo $mensaje?></strong>
                        </div>
                        <script>
                        var alertList = document.querySelectorAll('.alert');
                        alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert)
                        })
                    </script>
                <?php } ?>
                <!-- inicio del card -->
                <div class="card">
                    <div id="login-form"  id="login-container">
                        <div class="card-header">
                            Iniciar Sesión
                        </div>
                        <div class="card-body">
    <!-- ***************************************Formulario Inicio de sesion************************************ -->
                            <form id="login" action="funciones.php" method="post">
                                <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                    <input class="form-control" type="text" name="usuario" placeholder="Nombre de usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input class="form-control" type="password" name="password" placeholder="Contraseña" required>
                                </div>                                                
                                <input class="btn btn-primary" type="submit" name="ingresar" value="Entrar">
                            </form>
                            <p>No tienes una cuenta? <a href="#" onclick="showRegisterForm()">Regístrate</a></p>
                        </div>
                    </div>
                    <div id="register-form" style="display: none;">
                        <div class="card-header">
                            Registrarse
                        </div>
                        <div class="card-body">
    <!-- ***********************Formulario Registro de usuario tipo 1 (usuario 'cliente')********************* -->
                            <form id="register" action="funciones.php" method="post">
                                <div class="mb-3">
                                    <label for="new_username" class="form-label">Nombre de usuario</label>
                                    <input class="form-control" type="text" name="new_username" placeholder="Nuevo nombre de usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo</label>
                                    <input class="form-control" type="email" name="correo" placeholder="Correo electronico" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Contraseña</label>
                                    <input class="form-control" type="password" name="new_password" placeholder="Nueva contraseña" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                    <input class="form-control" type="password" name="confirm_password" placeholder="Confirmar contraseña" required>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Registrar" name="registrar">
                            </form>
                            <p>Ya tienes una cuenta? <a href="#" onclick="showLoginForm()">Iniciar Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <script src="index.js"></script>
</body>
</html>