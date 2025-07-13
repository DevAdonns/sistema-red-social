<?php include_once("template/cabecera.php");?>
<?php  
include_once("admin/connection/conexion.php");
// Verificar si el usuario está autenticado
if(isset($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
    // Obtener datos del usuario
    $sql_usuario = "SELECT * FROM `tbl-amigos` WHERE nombre='$nombre_usuario'";
    $res_usuario = mysqli_query($conn, $sql_usuario);
    if ($row_usuario = mysqli_fetch_assoc($res_usuario)) {
        echo '<h4>Mis datos:</h4>';
        echo '<ul>';
        echo '<li>ID: ' . $row_usuario['id'] . '</li>';
        echo '<li>Nombre: ' . $row_usuario['nombre'] . '</li>';
        echo '<li>Edad: ' . $row_usuario['edad'] . '</li>';
        echo '<li>Avatar: <img src="img/' . $row_usuario['avatar'] . '" style="width:50px;height:50px;"></li>';
        echo '</ul>';
        // Buscar amigos
        $id_usuario = $row_usuario['id'];
        $amigos_ids = [];
        $sql_amistades = "SELECT id_usuario1, id_usuario2 FROM `tbl-amistades` WHERE id_usuario1='$id_usuario' OR id_usuario2='$id_usuario'";
        $res_amistades = mysqli_query($conn, $sql_amistades);
        while ($row_amistad = mysqli_fetch_assoc($res_amistades)) {
            if ($row_amistad['id_usuario1'] == $id_usuario) {
                $amigos_ids[] = $row_amistad['id_usuario2'];
            } else {
                $amigos_ids[] = $row_amistad['id_usuario1'];
            }
        }
        echo '<h4>Mis amigos:</h4>';
        if (!empty($amigos_ids)) {
            $ids = implode(',', array_map('intval', $amigos_ids));
            $sql_amigos = "SELECT * FROM `tbl-amigos` WHERE id IN ($ids)";
            $res_amigos = mysqli_query($conn, $sql_amigos);
            echo '<ul>';
            while ($row_amigo = mysqli_fetch_assoc($res_amigos)) {
                echo '<li>' . $row_amigo['nombre'] . ' (Edad: ' . $row_amigo['edad'] . ') <img src="img/' . $row_amigo['avatar'] . '" style="width:30px;height:30px;"></li>';
            }
            echo '</ul>';
        } else {
            echo 'No tienes amigos aún.';
        }
    } else {
        echo 'Usuario no encontrado.';
    }
    // Formulario para añadir amigo
    echo '<hr><h4>Añadir amigo</h4>';
    echo '<form method="post"><input type="text" name="nombre_amigo" placeholder="Nombre del amigo" required> <button type="submit" class="btn btn-primary">Añadir amigo</button></form>';
    // Procesar añadir amigo
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_amigo'])) {
        $nombre_amigo = $_POST['nombre_amigo'];
        // Buscar si el amigo existe
        $sql_amigo = "SELECT id FROM `tbl-amigos` WHERE nombre='$nombre_amigo'";
        $res_amigo = mysqli_query($conn, $sql_amigo);
        if ($row_amigo = mysqli_fetch_assoc($res_amigo)) {
            $id_amigo = $row_amigo['id'];
            // Verificar si ya son amigos
            $sql_check = "SELECT * FROM `tbl-amistades` WHERE (id_usuario1='$id_usuario' AND id_usuario2='$id_amigo') OR (id_usuario1='$id_amigo' AND id_usuario2='$id_usuario')";
            $res_check = mysqli_query($conn, $sql_check);
            if (mysqli_num_rows($res_check) == 0 && $id_usuario != $id_amigo) {
                // Crear amistad
                $sql_amistad = "INSERT INTO `tbl-amistades` (id_usuario1, id_usuario2) VALUES ('$id_usuario', '$id_amigo')";
                if (mysqli_query($conn, $sql_amistad)) {
                    echo "<script>alert('¡Amigo añadido correctamente!');window.location.href='mostraramigos.php';</script>";
                } else {
                    echo "<script>alert('Error al añadir el amigo');</script>";
                }
            } else {
                echo "<script>alert('Ya es tu amigo o intentas añadirte a ti mismo');</script>";
            }
        } else {
            echo "<script>alert('No existe un usuario con ese nombre');</script>";
        }
    }
    // --- FORMULARIO DE CREACIÓN DE EVENTOS ---
    echo '<hr><h4 class="mt-4">Crear evento</h4>';
    echo '<form method="post" class="card p-3 mb-4 bg-light shadow">';
    echo '<div class="mb-2"><label class="form-label">Nombre del evento:</label> <input type="text" class="form-control" name="nombre_evento" required></div>';
    echo '<div class="mb-2"><label class="form-label">Fecha:</label> <input type="date" class="form-control" name="fecha_evento" required></div>';
    echo '<div class="mb-2"><label class="form-label">Descripción:</label> <textarea class="form-control" name="descripcion_evento" required></textarea></div>';
    echo '<div class="mb-2"><label class="form-label">Gente invitada:</label><br>';
    // Lista de amigos para invitar
    if (!empty($amigos_ids)) {
        foreach ($amigos_ids as $amigo_id) {
            $sql_amigo = "SELECT nombre, avatar FROM `tbl-amigos` WHERE id='$amigo_id'";
            $res_amigo = mysqli_query($conn, $sql_amigo);
            if ($row_amigo = mysqli_fetch_assoc($res_amigo)) {
                echo '<label class="me-2"><input type="checkbox" name="invitados[]" value="' . $amigo_id . '"> <img src="img/' . $row_amigo['avatar'] . '" style="width:25px;height:25px;border-radius:50%;margin-right:5px;">' . htmlspecialchars($row_amigo['nombre']) . '</label>';
            }
        }
    } else {
        echo '<span class="text-danger">No tienes amigos para invitar.</span>';
    }
    echo '</div>';
    echo '<button type="submit" class="btn btn-success">Crear evento</button>';
    echo '</form>';
    // --- PROCESAR CREACIÓN DE EVENTO ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_evento'])) {
        $nombre_evento = $_POST['nombre_evento'];
        $fecha_evento = $_POST['fecha_evento'];
        $descripcion_evento = $_POST['descripcion_evento'];
        $invitados = isset($_POST['invitados']) ? $_POST['invitados'] : [];
        // Insertar evento
        $sql_evento = "INSERT INTO tbl_eventos (nombre, fecha, descripcion, creador_id) VALUES ('$nombre_evento', '$fecha_evento', '$descripcion_evento', '$id_usuario')";
        if (mysqli_query($conn, $sql_evento)) {
            $evento_id = mysqli_insert_id($conn);
            // Insertar invitados
            foreach ($invitados as $invitado_id) {
                $sql_invitado = "INSERT INTO tbl_invitados_evento (evento_id, invitado_id) VALUES ('$evento_id', '$invitado_id')";
                mysqli_query($conn, $sql_invitado);
            }
            // El creador también está invitado
            $sql_invitado = "INSERT INTO tbl_invitados_evento (evento_id, invitado_id) VALUES ('$evento_id', '$id_usuario')";
            mysqli_query($conn, $sql_invitado);
            echo "<script>alert('¡Evento creado correctamente!');window.location.href='mostraramigos.php';</script>";
        } else {
            echo "<script>alert('Error al crear el evento');</script>";
        }
    }
    // --- MOSTRAR EVENTOS DONDE EL USUARIO ESTÁ INVITADO ---
    echo '<hr><h4 class="mt-4">Eventos donde estoy invitado</h4>';
    $sql_eventos = "SELECT e.*, GROUP_CONCAT(a.nombre SEPARATOR ', ') AS invitados_nombres FROM tbl_eventos e JOIN tbl_invitados_evento ie ON e.id = ie.evento_id JOIN `tbl-amigos` a ON ie.invitado_id = a.id WHERE ie.invitado_id = '$id_usuario' GROUP BY e.id";
    $res_eventos = mysqli_query($conn, $sql_eventos);
    if (mysqli_num_rows($res_eventos) > 0) {
        echo '<div class="row">';
        while ($row_evento = mysqli_fetch_assoc($res_eventos)) {
            echo '<div class="col-md-6 mb-3">';
            echo '<div class="card shadow">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row_evento['nombre']) . '</h5>';
            echo '<p class="card-text"><strong>Fecha:</strong> ' . $row_evento['fecha'] . '</p>';
            echo '<p class="card-text"><strong>Descripción:</strong> ' . htmlspecialchars($row_evento['descripcion']) . '</p>';
            echo '<a href="?ver_evento=' . $row_evento['id'] . '" class="btn btn-info btn-sm">Ver detalles</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning">No tienes eventos.</div>';
    }
    // --- MOSTRAR DETALLES DE EVENTO ---
    if (isset($_GET['ver_evento'])) {
        $evento_id = intval($_GET['ver_evento']);
        $sql_evento = "SELECT * FROM tbl_eventos WHERE id='$evento_id'";
        $res_evento = mysqli_query($conn, $sql_evento);
        if ($row_evento = mysqli_fetch_assoc($res_evento)) {
            echo '<hr><div class="card mt-4 shadow"><div class="card-body">';
            echo '<h4 class="card-title">Detalles del evento</h4>';
            echo '<p><strong>Nombre:</strong> ' . htmlspecialchars($row_evento['nombre']) . '</p>';
            echo '<p><strong>Fecha:</strong> ' . $row_evento['fecha'] . '</p>';
            echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($row_evento['descripcion']) . '</p>';
            // Invitados
            $sql_invitados = "SELECT a.nombre, a.avatar FROM tbl_invitados_evento ie JOIN `tbl-amigos` a ON ie.invitado_id = a.id WHERE ie.evento_id='$evento_id'";
            $res_invitados = mysqli_query($conn, $sql_invitados);
            echo '<strong>Invitados:</strong> <ul class="list-inline">';
            while ($row_invitado = mysqli_fetch_assoc($res_invitados)) {
                echo '<li class="list-inline-item"><img src="img/' . $row_invitado['avatar'] . '" style="width:25px;height:25px;border-radius:50%;margin-right:5px;">' . htmlspecialchars($row_invitado['nombre']) . '</li>';
            }
            echo '</ul>';
            echo '</div></div>';
        }
    }
} else {
    echo '<p>Debes iniciar sesión para ver tus datos y amigos.</p>';
}
$sql="SELECT * FROM `tbl-amigos`";
$resultado = mysqli_query($conn, $sql);
?>
<?php foreach($resultado as $row){ ?>

<div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="img/<?php echo $row['avatar']; ?>" style="width:auto;height:200px;" alt="<?php echo $row['nombre']; ?>" />
        <div class="card-body">
            <h4 class="card-title">Nombre <?php echo $row['nombre']; ?></h4>
            <h4 class="card-title">Edad: <?php echo $row['edad']; ?></h4>
            <h4 class="card-title">Amigos: <?php echo $row['amigos']; ?></h4>
            
            <a name="" id=""  class="btn btn-primary"  href="#" role="button" >Ver Mas</a>
        </div>
    </div>
    <br>
</div>

<?php } ?>
</body>
</html>
<?php include_once("template/pie.php");?>