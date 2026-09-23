<?php
// ========================================================
// ELIMINAR PRODUCTO - COLDROP
// ========================================================

include_once '../conexion.php';


// ========================================================
// VERIFICAR QUE LLEGÓ EL CÓDIGO
// ========================================================

if (!isset($_GET['Codigo']) || trim($_GET['Codigo']) === '') {

    $tipo = 'error';
    $titulo = 'Error';
    $mensaje = 'No se especificó el código del producto.';

} else {

    $codigo = $_GET['Codigo'];


    // ====================================================
    // PREPARAR CONSULTA
    // ====================================================

    $sql = "DELETE FROM productos WHERE Codigo = ?";

    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        $tipo = 'error';
        $titulo = 'Error';
        $mensaje = 'No se pudo preparar la eliminación del producto.';

    } else {

        // =================================================
        // EJECUTAR ELIMINACIÓN
        // =================================================

        $stmt->bind_param("s", $codigo);

        $stmt->execute();


        // =================================================
        // COMPROBAR SI SE ELIMINÓ
        // =================================================

        if ($stmt->affected_rows > 0) {

            $tipo = 'success';
            $titulo = '¡Producto eliminado!';
            $mensaje = 'El producto fue eliminado correctamente.';

        } else {

            $tipo = 'error';
            $titulo = 'Producto no encontrado';
            $mensaje = 'El producto no existe o ya fue eliminado.';
        }


        $stmt->close();
    }
}


// ========================================================
// CERRAR CONEXIÓN
// ========================================================

if (isset($conn)) {
    $conn->close();
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Eliminar Producto - ColdDrop</title>


    <!-- ==================================================
         SWEETALERT2
         ================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body>


<script>

document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({

        icon: '<?php echo $tipo; ?>',

        title: '<?php echo $titulo; ?>',

        text: '<?php echo $mensaje; ?>',

        confirmButtonText: 'Aceptar',

        confirmButtonColor:
            '<?php echo ($tipo === "success") ? "#28a745" : "#d33"; ?>',

        allowOutsideClick: false,

        allowEscapeKey: false

    }).then((result) => {

        // ==================================================
        // VOLVER A LA LISTA DE PRODUCTOS
        // ==================================================

        if (result.isConfirmed) {

            window.location.href = 'leerproductos.php';

        }

    });

});

</script>


</body>

</html>
