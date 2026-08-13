<?php
// ========================================================
// CATÁLOGO DE POLERAS (POLERAS.PHP)
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

// Consultar Poleras
$sql = "SELECT * FROM productos WHERE Tipo = 'Polera'";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>


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
                echo "<p style='text-align:center;'>No hay poleras disponibles por el momento.</p>";
            }
            ?>
        </div>
    </section>

    <section style="text-align: center; margin: 40px 0;">
        <h2 style="font-size: 24px; color: #555;">Descubre nuestras poleras, Cold Wave T-shirt</h2>
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