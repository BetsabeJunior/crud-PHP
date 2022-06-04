<?php
require_once 'conexion_bd.php';
$id=base64_decode($_GET['id']);
$sql = "DELETE FROM `productos` WHERE id=$id";
$query = $conexion->query($sql);

if ($query) {
    echo '
    <script>
    alert("Eliminado Exitosamente");
    window.location = "index.php";
    </script>
';
} else {
    echo '
    <script>
    alert("No Se Elimino Correctamente");
    window.location = "index.php";
    </script>
';
}

/* header("location:index.php"); */
?>
