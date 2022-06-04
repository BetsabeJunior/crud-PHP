<?php
require_once 'conexion_bd.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `productos` where id=$id";
    $query = $conexion->query($sql);
    $campo = $query->fetch_object();
    $nombre = $campo->nombre;
    $precio = $campo->precio;
    $activo = $campo->activo;
}

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "Guardar") {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $activo = 0;
        if (isset($_POST['activo']))
            $activo = 1;

        $datos = "INSERT INTO `productos`(`id`, `nombre`, `precio`, `activo`) 
        VALUES (DEFAULT, '$nombre', '$precio', '$activo')";
        $query = $conexion->query($datos);
        if ($query) {
            echo '
            <script>
            alert("Guardado Exitosamente");
            window.location = "index.php";
            </script>
        ';
        } else {
            echo '
            <script>
            alert("No Se Guardó Correctamente");
            window.location = "index.php";
            </script>
        ';
        }
        /*  header("location:index.php"); */
    } else if ($_POST['accion'] == "Editar") {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $activo = 0;
        if (isset($_POST['activo']))
            $activo = 1;

        $datos = "UPDATE `productos` SET `nombre`='$nombre',
        `precio`='$precio',`activo`='$activo' WHERE id=$id";
        $query = $conexion->query($datos);
        if ($query) {
            echo '
            <script>
            alert("Actualizado Exitosamente");
            window.location = "index.php";
            </script>
        ';
        } else {
            echo '
            <script>
            alert("No Se Actualizó Correctamente");
            window.location = "index.php";
            </script>
        ';
        }
        /* header("location:index.php"); */
    }
}

$sql = 'SELECT * FROM `productos`';
$query = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Lista De Productos</title>
</head>

<body>

    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registro de produco</h4>
                <form class="needs-validation" novalidate action="" method="post">
                    <input type="hidden" name="id" value="<?php echo @$id; ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" class="form-control" name="nombre" required value="<?php echo @$nombre; ?>">
                            <div class="valid-feedback">Correcto</div>
                            <div class="invalid-feedback">Campo requerido</div>
                        </div>
                        <div class="col-mb-5">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" required value="<?php echo @$precio; ?>">
                            <div class="valid-feedback">Correcto</div>
                            <div class="invalid-feedback">Campo requerido</div>
                        </div>
                    </div>
                    <div class="row py-4">
                        <div class="col-md-2">
                            <label for="activo" class="form-label">¿Activo?</label>
                            <input type="checkbox" class="form-check-input" <?php echo (@$activo == 1 ? "checked" : ""); ?> name="activo">
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <?php
                            if (isset($_GET['id'])) {
                            ?>
                                <input type="submit" class="btn btn-warning" name="accion" value="Editar">
                            <?php
                            } else {
                            ?>
                                <input type="submit" class="btn btn-info" name="accion" value="Guardar">
                            <?php
                            }
                            ?>
                            <input type="reset" class="btn btn-light border border-dark" value="Limpiar campo">

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Activo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($filas = $query->fetch_object()) {
                ?>
                    <tr>
                        <td scope="row">
                            <?php echo $filas->id; ?>
                        </td>
                        <td>
                            <?php echo $filas->nombre; ?>
                        </td>
                        <td>
                            $ <?php echo number_format($filas->precio, 0, ",", "."); ?>
                        </td>
                        <td scope="row">
                            <?php echo ($filas->activo == 1 ? "Activo" : "Inactivo"); ?>
                        </td>
                        <td>
                            <a href="?id=<?php echo $filas->id; ?>" class="btn btn-primary">Editar</a>
                            <a href="eliminar.php?id=<?php echo base64_encode($filas->id); ?>" class="btn btn-danger">Eliminar</a>
                            <button class="btn btn-warning">Cambiar estado</button>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="hl.js"></script>
</body>

</html>