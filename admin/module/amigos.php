<?php include_once("../template/cabecera_productos.php"); ?>

<?php

$id_usuario="";
$nombre="";
$imagen="";
$accion = "";
$edad= "";
$password=""; 
$amigos="";
$avatar="";
if($_POST){

    $accion = $_POST['accion'];

    switch($accion){
        case 'crear_amistad':
            // Crear amistad entre dos usuarios
            include_once("../connection/conexion.php");
            $id_usuario1 = $_POST['usuario1'];
            $id_usuario2 = $_POST['usuario2'];
            if($id_usuario1 != $id_usuario2) {
                // Evitar duplicados (amistad en ambos sentidos)
                $sql_check = "SELECT * FROM `tbl-amistades` WHERE (id_usuario1='$id_usuario1' AND id_usuario2='$id_usuario2') OR (id_usuario1='$id_usuario2' AND id_usuario2='$id_usuario1')";
                $res_check = mysqli_query($conn, $sql_check);
                if(mysqli_num_rows($res_check) == 0) {
                    $sql_amistad = "INSERT INTO `tbl-amistades` (id_usuario1, id_usuario2) VALUES ('$id_usuario1', '$id_usuario2')";
                    if(mysqli_query($conn, $sql_amistad)) {
                        echo "<script>alert('¡Amistad creada correctamente!');</script>";
                    } else {
                        echo "<script>alert('Error al crear la amistad');</script>";
                    }
                } else {
                    echo "<script>alert('La amistad ya existe');</script>";
                }
            } else {
                echo "<script>alert('No puedes crear amistad contigo mismo');</script>";
            }
            break;
        case 'agregar':
            function agregar_amigo($nombre, $edad, $password, $avatar, $amigos){

                
            
                include_once("../connection/conexion.php");
                $sql="INSERT INTO `tbl-amigos` (`nombre`, `edad`, `password`, `avatar`, `amigos`) VALUES ('".$nombre."', '".$edad."', '".$password."', '".$avatar."', '".$amigos."')";
                $resultado = mysqli_query($conn, $sql);
                if(isset($resultado)){
                    echo "<script>alert('Amigo Registrado Correctamente');</script>";
                    echo "<script>window.location.href='amigos.php';</script>";
                }else{
                    echo "<script>alert('Error al registrar el amigo');</script>";
                }
               
            }
            agregar_amigo($_POST['txtNOMBRE'], $_POST['txtedad'], $_POST['txtpassword'], $_POST['avatar'], $_POST['amigos']);
            
            break;
            
        case 'modificar':
            include_once("../connection/conexion.php");
            $id_usuario=$_POST['txtID'];
            $nombre=$_POST['txtNOMBRE'];
            $edad=$_POST['txtedad'];
            $password=$_POST['txtpassword'];
            $avatar=$_POST["avatar"];
            $amigos=$_POST['amigos'];
            $sql="UPDATE `tbl-amigos` SET `nombre`='".$nombre."', `edad`='".$edad."', `password`='".$password."', `avatar`='".$avatar."', `amigos`='".$amigos."' WHERE `id`='".$id_usuario."'";
            $resultado = mysqli_query($conn, $sql);

            if(isset($resultado)){
                
                echo "<script>alert('Amigo Modificado Correctamente');</script>";
                echo "<script>window.location.href='amigos.php';</script>";
            }else{
                echo "<script>alert('Error al modificar el amigo');</script>";


            }
            
            break;

        case 'cancelar': 
            header("location:amigos.php");
            
            break;

        case 'seleccionar':
            include_once("../connection/conexion.php");
            $id_usuario=$_POST['userID'];
            // $id_usuario=$_POST['ID']; // Cambiado a userID para que coincida con el input del formulario
            $sql="SELECT * FROM `tbl-amigos` WHERE id='".$id_usuario."'";
            $resultado = mysqli_query($conn, $sql);
            if(mysqli_num_rows($resultado)>0){
                $row = mysqli_fetch_assoc($resultado);
                $id_usuario=$row['id'];
                $nombre=$row['nombre'];
                $edad=$row['edad'];
                $password=$row['password'];
                $amigos=$row["amigos"]; 
            } 
            
            break; 

        case 'eliminar':
            include_once("../connection/conexion.php");
            $id=$_POST['userID'];
            $sql="DELETE FROM `tbl-amigos` WHERE id='".$id."'";
            $resultado = mysqli_query($conn, $sql);
            if($resultado){
                echo "<script>alert('Amigo Eliminado Correctamente');</script>";
                echo "<script>window.location.href='amigos.php';</script>";
            }else{
                echo "<script>alert('Error al eliminar el amigo');</script>";
            }
        
        
            break;

        default:
            break;

    }

}

?>
<div class="col-md-5">
    <div class="card mt-3">
        <div class="card-header">Crear amistad entre dos personas</div>
        <div class="card-body">
            <form action="amigos.php" method="post">
                <div class="mb-3">
                    <label for="usuario1" class="form-label">Usuario 1:</label>
                    <select name="usuario1" class="form-control" required>
                        <option value="">Selecciona un usuario</option>
                        <?php
                        include_once("../connection/conexion.php");
                        $sql_usuarios = "SELECT id, nombre FROM `tbl-amigos`";
                        $res_usuarios = mysqli_query($conn, $sql_usuarios);
                        while($row = mysqli_fetch_assoc($res_usuarios)) {
                            echo '<option value="'.$row['id'].'">'.$row['nombre'].' (ID: '.$row['id'].')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="usuario2" class="form-label">Usuario 2:</label>
                    <select name="usuario2" class="form-control" required>
                        <option value="">Selecciona un usuario</option>
                        <?php
                        include_once("../connection/conexion.php");
                        $sql_usuarios2 = "SELECT id, nombre FROM `tbl-amigos`";
                        $res_usuarios2 = mysqli_query($conn, $sql_usuarios2);
                        while($row = mysqli_fetch_assoc($res_usuarios2)) {
                            echo '<option value="'.$row['id'].'">'.$row['nombre'].' (ID: '.$row['id'].')</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="accion" value="crear_amistad">Crear Amistad</button>
            </form>
        </div>
    </div>
</div>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">Datos</div>
        <div class="card-body">
            
    <form action="amigos.php" method="post" enctype="multipart/form-data" >

        <div class="mb-3">
            <label for="id" class="form-label">ID:</label>
            <input type="text" class="form-control" required readonly value="<?php echo $id_usuario;?> " name="txtID" id="id"  placeholder="ID"  />
        </div> 
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" value="<?php echo $nombre;?>" name="txtNOMBRE"  required/>
        </div> 
        <div class="mb-3">
            <label for="nombre" class="form-label">edad:</label>
            <input type="text" class="form-control"  value="<?php echo $edad;?> " name="txtedad"  required />
        </div> 
         <div class="mb-3">
            <label for="nombre" class="form-label">password:</label>
            <input type="text" class="form-control"  value="<?php echo $password;?>" name="txtpassword" required  />
        </div> 
        <img src="http://localhost/prueba/img/avatar1.webp" style="width:100px;height:100px;"> 1
        <img src="http://localhost/prueba/img/avatar2.avif" style="width:100px;height:100px;"> 2
        <img src="http://localhost/prueba/img/avatar3.webp" style="width:100px;height:100px;"> 3
        <div class="mb-3">
            <label for="imagen" class="form-label">avatar:</label>
            <select name="avatar">
            <option value="Avatar1.webp">Avatar 1</option> 
            <option value="avatar2.avif">Avatar 2</option>
            <option value="avatar3.webp">Avatar 3</option>
        </select>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">amigos:</label>
            <?php
            // Mostrar amistades del usuario seleccionado en un select múltiple
            include_once("../connection/conexion.php");
            $amigos_ids = [];
            if (!empty($id_usuario)) {
                // Buscar amistades donde el usuario es usuario1 o usuario2
                $sql_amistades = "SELECT id_usuario1, id_usuario2 FROM `tbl-amistades` WHERE id_usuario1='$id_usuario' OR id_usuario2='$id_usuario'";
                $res_amistades = mysqli_query($conn, $sql_amistades);
                while ($row_amistad = mysqli_fetch_assoc($res_amistades)) {
                    if ($row_amistad['id_usuario1'] == $id_usuario) {
                        $amigos_ids[] = $row_amistad['id_usuario2'];
                    } else {
                        $amigos_ids[] = $row_amistad['id_usuario1'];
                    }
                }
            }
            ?>
            <select class="form-control" name="amigos" id="amigos" multiple readonly>
                <?php
                if (!empty($amigos_ids)) {
                    // Obtener nombres de los amigos
                    $ids = implode(',', array_map('intval', $amigos_ids));
                    $sql_amigos = "SELECT id, nombre FROM `tbl-amigos` WHERE id IN ($ids)";
                    $res_amigos = mysqli_query($conn, $sql_amigos);
                    while ($row_amigo = mysqli_fetch_assoc($res_amigos)) {
                        echo '<option selected>' . htmlspecialchars($row_amigo['nombre']) . ' (ID: ' . $row_amigo['id'] . ')</option>';
                    }
                } else {
                    echo '<option>No tiene amistades</option>';
                }
                ?>
            </select>
        </div> 
        
        
        <div class="btn-group" role="group" aria-label="Button group name" >
            <button type="sudmit" class="btn btn-success" <?php echo ($accion=="seleccionar") ?"disabled" :"" ; ?> name="accion" value="agregar" > Agregar </button>

            <button type="sudmit" class="btn btn-warning"  <?php echo ($accion!="seleccionar") ?"disabled" :"" ; ?> name="accion" value="modificar" >  Modificar  </button>
            
            <button  type="sudmit" class="btn btn-info"  <?php echo ($accion!="seleccionar") ?"disabled" :"" ; ?> name="accion" value="cancelar" > Cancelar</button>
        
        </div>
    </form>
        </div>
    </div>
</div>
<br> 
<div class="col-md-7 center">
    <br>
    <div
        class="table-responsive"
    >
        <table
            class="table table-primary center"
        >
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">edad</th>
                    <th scope="col">password</th>
                    <th scope="col">avatar</th>
                    <th scope="col">amigos</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <?php
            include_once("../connection/conexion.php");
            $sql="SELECT * FROM `tbl-amigos`";
            $resultado = mysqli_query($conn, $sql);
            
            foreach($resultado as $row){
                echo    "<tbody>";
                echo        "<tr>";
                echo            "<td>".$row['id']."</td>";
                echo            "<td>".$row['nombre']."</td>";
                echo            '<td>'.$row['edad'].'</td>';
                echo            '<td>'.$row['password'].'</td>';
                echo            '<td><img src="http://localhost/prueba/img/'.$row["avatar"].'" style="width:100px;height:100px;"></td>';
                echo            '<td>'.$row['amigos'].'</td>';
                echo            '<td>
                                <form method="post">
                                    <input type="hidden" name="userID" value="'.$row['id'].'">
                                    <button type="submit" name="accion" value="seleccionar" class="btn btn-info">Seleccionar </button>
                                    <br>
                                    <br>
                                    <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                                </td>';
                echo        "</tr>";
                echo    "</tbody>";
            }
            ?>
        </table>
    </div>
   
</div>

<?php include_once("../template/pie.php"); ?>