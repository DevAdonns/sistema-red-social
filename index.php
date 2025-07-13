<?php
include_once 'admin/connection/conexion.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $_usuario = $_POST['usuario'];
    $_clave = $_POST['clave'];

    $sql = "SELECT * FROM `tbl-amigos` WHERE `nombre` = '$_usuario' AND `password` = '$_clave'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        session_start();
        $_SESSION['nombre_usuario'] = $_usuario;
        header("location:mostraramigos.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Usuario o contraseña incorrectos</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Usuario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/person.svg" type="image/x-icon">
</head>
<body>
<br>
<br>
</br>
</br>
<div class="container">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Login Usuario</h4>
                <form action="index.php" method="post">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" class="form-control" id="usuario" required>
                    <label for="clave">Contraseña</label>
                    <input type="password" name="clave" class="form-control" id="clave" required>
                    <input type="submit" value="Iniciar Sesión" class="btn btn-primary mt-3">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>