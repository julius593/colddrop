<?php
// ========================================================
// PÁGINA NOSOTROS - QUIÉNES SOMOS (NOSOTROS.PHP)
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - ColdDrop</title>
    
    <!-- Hoja de estilos externa para la página Nosotros -->
    <link rel="stylesheet" href="../css/nosotros.css">
</head>
<body>
    <!-- Incluimos la cabecera superior -->
    <?php include 'header.php'; ?>

    <section class="hero">
        <p class="hero-eyebrow">Quiénes somos</p>
        <h1 id="nombre">ColdDrop</h1>
        <h1>HECHO EN<br /><span>LA CALLE.</span></h1>
    </section>

    <section class="mision">
        <div class="mision-label">
            <p>Nuestra misión</p>
        </div>
        <div class="mision-content">
            <h2>MÁS QUE ROPA</h2>
            <p>
                ColdDrop nació para vestir a quienes viven sin pedir permiso. No hacemos ropa para aparentar —
                hacemos prendas que aguantan el ritmo de la ciudad, que se ven bien en el parche y que
                dicen algo sobre quien las usa. Nuestra misión es simple: calidad real, a precio justo,
                con identidad propia.
            </p>
        </div>
    </section>

    <section class="equipo">
        <div class="equipo-intro">
            <h2>LO QUE NOS MUEVE</h2>
            <p>
                Somos un equipo pequeño con ideas grandes. Diseñamos cada pieza pensando en quien la va a usar,
                y producimos localmente para asegurarnos de que cada detalle esté bien.
            </p>
        </div>

        <div class="valores">
            <div class="valor">
                <span class="valor-num">01</span>
                <h3>Autenticidad</h3>
                <p>Nada de tendencias prestadas. Cada diseño sale de nuestra propia visión, sin copiar lo que está de moda afuera.</p>
            </div>
            <div class="valor">
                <span class="valor-num">02</span>
                <h3>Calidad</h3>
                <p>Usamos materiales que duran. No nos interesa que compres cada mes — nos interesa que lo que compres te dure años.</p>
            </div>
            <div class="valor">
                <span class="valor-num">03</span>
                <h3>Comunidad</h3>
                <p>La gente que usa ColdDrop es parte de algo. No somos solo una marca — somos una forma de moverse por el mundo.</p>
            </div>
        </div>
    </section>

    <section class="cierre">
        <h2>VEN A VER LO QUE TENEMOS</h2>
        <p>La nueva colección ya está disponible. Piezas limitadas, sin reposición.</p>
        <a href="hoodeis.php" class="btn">Ver colección</a>
    </section>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>  
</body>
</html>