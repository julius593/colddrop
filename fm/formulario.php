<?php
// ========================================================
// FORMULARIO MEDIOAMBIENTAL - COLDDROP
// ========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Formulario Medioambiental - ColdDrop</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="../css/formularios.css">

</head>

<body>

<?php include '../princip/header.php'; ?>


<div class="form-container" style="margin: 40px auto;">

    <form action="guardar_medioambiental.php"
          method="POST"
          id="formMedioambiental">

        <h2>FORMULARIO MEDIOAMBIENTAL</h2>


        <div class="form-grid">


            <!-- NOMBRE -->

            <div class="form-group">

                <label for="Nombre">
                    Nombre
                </label>

                <input
                    type="text"
                    name="Nombre"
                    id="Nombre"
                    placeholder="Ingresa tu nombre"
                    required
                >

            </div>


            <!-- APELLIDO -->

            <div class="form-group">

                <label for="Apellido">
                    Apellido
                </label>

                <input
                    type="text"
                    name="Apellido"
                    id="Apellido"
                    placeholder="Ingresa tu apellido"
                    required
                >

            </div>


            <!-- TIPO DE SUGERENCIA -->

            <div class="form-group">

                <label for="Tipo">
                    Tipo de aporte
                </label>

                <select name="Tipo"
                        id="Tipo"
                        required>

                    <option value="">
                        Selecciona una opción
                    </option>

                    <option value="Reciclaje">
                        Reciclaje
                    </option>

                    <option value="Reduccion de residuos">
                        Reducción de residuos
                    </option>

                    <option value="Reutilizacion">
                        Reutilización
                    </option>

                    <option value="Ahorro de recursos">
                        Ahorro de recursos
                    </option>

                    <option value="Otro">
                        Otro
                    </option>

                </select>

            </div>


            <!-- NIVEL DE IMPORTANCIA -->

            <div class="form-group">

                <label for="Importancia">
                    Importancia
                </label>

                <select name="Importancia"
                        id="Importancia"
                        required>

                    <option value="">
                        Selecciona
                    </option>

                    <option value="Baja">
                        Baja
                    </option>

                    <option value="Media">
                        Media
                    </option>

                    <option value="Alta">
                        Alta
                    </option>

                </select>

            </div>


            <!-- COMENTARIO -->

            <div class="form-group full-width">

                <label for="Comentario">
                    Comentario o sugerencia
                </label>

                <textarea
                    name="Comentario"
                    id="Comentario"
                    rows="6"
                    placeholder="Escribe tu propuesta o sugerencia..."
                    required
                ></textarea>

            </div>


            <!-- PROPUESTA -->

            <div class="form-group full-width">

                <label for="Propuesta">
                    Propuesta de mejora
                </label>

                <textarea
                    name="Propuesta"
                    id="Propuesta"
                    rows="5"
                    placeholder="¿Qué propones para mejorar?"
                ></textarea>

            </div>


            <!-- BOTÓN -->

            <div class="form-group full-width">

                <input
                    type="submit"
                    value="Enviar Formulario"
                >

            </div>

        </div>

    </form>


    <a href="../princip/inicio.php"
       class="links">

        ← Volver al Inicio

    </a>

</div>


<?php include '../princip/footer.php'; ?>

</body>

</html>