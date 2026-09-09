<?php
// ========================================================
// CATÁLOGO DE SHORTS (SHORTS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Obtener ID de pedido activo
$id_PEDIDOS = '';
$sqlUltimo = "SELECT idPEDIDOS FROM pedidos ORDER BY idPEDIDOS DESC LIMIT 1";
$resUltimo = $conexion->query($sqlUltimo);
if ($resUltimo && $resUltimo->num_rows > 0) {
    $filaUltimo = $resUltimo->fetch_assoc();
    $id_PEDIDOS = $filaUltimo['idPEDIDOS'];
} else {
    $vendedor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Cliente Directo';
    $fecha = date('Y-m-d');
    $conexion->query("INSERT INTO pedidos (Nombre, Fecha, Estado, NombreVendedor) VALUES ('Cliente General', '$fecha', 'En Proceso', '$vendedor')");
    $id_PEDIDOS = $conexion->insert_id;
}

// Consultar Shorts
$sql = "SELECT * FROM productos WHERE Tipo = 'Short'";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorts - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="../css/catalogo.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section>
        <h1 id="nombrecollect">Nuestros Shorts</h1>
        
        <div id="imagenes">
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $img = !empty($fila['Imagen']) ? $fila['Imagen'] : 'default.jpg';
                    $stock = (int)$fila['Stock'];
                    $codigo = htmlspecialchars($fila['Codigo']);
                    $costo = htmlspecialchars($fila['Costo']);
                    ?>
                    <div class="card">
                        <img class="imagen" src="../imagenes/<?php echo htmlspecialchars($img); ?>" alt="Short">
                        <div class="texto">
                            <p style="font-size: 18px; font-weight: bold; margin-bottom: 5px;"><?php echo htmlspecialchars($fila['Nombre']); ?></p>
                            <p style="font-size: 15px; margin:0;"><?php echo htmlspecialchars($fila['Talla']) . " - $" . number_format($costo, 2); ?></p>
                            
                            <div>
                                <span class="stock-tag" style="background:<?php echo ($stock > 0 ? '#28a745' : '#dc3545'); ?>; color:#fff;">
                                    Stock: <?php echo $stock; ?> unid.
                                </span>
                            </div>

                            <?php if ($stock > 0): ?>
                                <button class="btn-card-cart" onclick="agregarCard('<?php echo $codigo; ?>', '<?php echo $id_PEDIDOS; ?>', '<?php echo $costo; ?>');">
                                    <i class="fa-solid fa-cart-plus"></i> Añadir al Carrito
                                </button>
                            <?php else: ?>
                                <button class="btn-card-cart" disabled>Agotado</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='text-align:center;'>No hay shorts disponibles por el momento.</p>";
            }
            ?>
        </div>
    </section>

    <section style="text-align: center; margin: 40px 0;">
        <h2 style="font-size: 24px; color: #555;">Frescura y estilo - Cold Wave</h2>
    </section>

    <script>
    function agregarCard(codigo, idPedido, costo) {
        const formData = new FormData();
        formData.append('Codigo', codigo);
        formData.append('id_PEDIDOS', idPedido);
        formData.append('Costo', costo);
        formData.append('cantidad', 1);

        fetch('agregar_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('¡Producto añadido al carrito exitosamente!');
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error al añadir al carrito');
        });
    }
    </script>

    <?php include 'footer.php'; ?>    
</body>
</html>