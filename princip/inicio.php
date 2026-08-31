<!-- ========================================================
     PÁGINA PRINCIPAL / DE INICIO (INICIO.PHP)
     ======================================================== -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ColdDrop - Inicio</title>
    <!-- Hoja de estilo exclusiva para el diseño de la portada principal -->
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Incluimos la barra superior de navegación -->
  <?php include 'header.php'; ?>

  <!-- Sección 1: Banner Principal / Portada -->
  <section id="uno">
    <div id="textouno">
      <h1>Cold Clothes</h1>
      <p>Descubre nuestra colección de ropa fresca y cómoda para mantener tu estilo en cualquier clima.</p>
    </div>
  </section>

  <!-- Sección 2: Galería de Muestra / Destacados -->
<section id="dos">
  <h1 style="text-align: center; margin-top: 40px;">Nuestra Colección</h1>
  <div id="imagenesmuestra">
    <div class="imagen-wrap">
      <img class="imagenmuestra" src="https://i.pinimg.com/1200x/3d/f9/f1/3df9f135aaa24d4181ae321478a42f42.jpg" alt="Colección 1" loading="lazy">
    </div>
    <div class="imagen-wrap">
      <img class="imagenmuestra" src="https://i.pinimg.com/736x/6c/16/3a/6c163abeb93331246e23e58026ddddc9.jpg" alt="Colección 2" loading="lazy">
    </div>
  </div>
</section>

  <!-- Sección 3: Historia y Valores de ColdDrop -->
  <section id="tres">
    <div id="izquierda">
      <span id="badge">Nuestra historia</span>
      <h2>Diseñamos la <strong>moda</strong> de los jóvenes bolivianos</h2>
      <p>ColdDrop es una empresa creada para representar la moda juvenil en Bolivia, destacamos por nuestra calidad y diseño único.</p>
      <p>Creemos que sentirse Cold es sentirse bien.</p>
      <a href="poleras.php" class="btn">Compra ahora -&gt;</a>
    </div>

    <div id="imagen">
      <img id="imagenhistoria" src="https://i.pinimg.com/736x/f5/fe/92/f5fe925b356e623568d41be94b209c88.jpg" alt="Imagen Historia">
      <div id="cita">
        <p>" Cada prenda cuenta una historia, cada diseño rompe esquemas "</p>
      </div>
    </div>
  </section>

  <!-- Incluimos el pie de página de la web -->
  <?php include 'footer.php'; ?>
</body>
</html>