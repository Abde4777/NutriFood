<?php
require_once "datos.php";

$slug = $_GET["slug"] ?? "";
$alimentoSeleccionado = null;

// Buscamos el alimento cuyo identificador coincide con la URL.
foreach ($alimentos as $alimento) {
    if ($alimento["slug"] === $slug) {
        $alimentoSeleccionado = $alimento;
        break;
    }
}

if ($alimentoSeleccionado === null) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $alimentoSeleccionado !== null ? htmlspecialchars($alimentoSeleccionado["nombre"], ENT_QUOTES, 'UTF-8') : "Alimento no encontrado" ?> | NutriFood</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
    <a class="logo-mini" href="index.php" aria-label="NutriFood, inicio">
        <img src="images/logo.png" alt="Logo de NutriFood">
    </a>
    <nav class="nav">
        <a href="index.php">Inicio</a>
        <a href="index.php#categorias">Categorías</a>
        <a href="index.php#alimentos">Alimentos</a>
    </nav>
    <a class="login-enlace" href="login.php">Iniciar sesión</a>
</header>

<main class="detalle-seccion">
<?php if ($alimentoSeleccionado !== null): ?>
    <div class="detalle-layout">
        <section class="detalle-producto">
            <h1 class="detalle-titulo"><?= htmlspecialchars($alimentoSeleccionado["nombre"], ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="detalle-imagen">
                <img src="images/Alimentos/<?= htmlspecialchars($alimentoSeleccionado["imagen"], ENT_QUOTES, 'UTF-8') ?>"
                     alt="<?= htmlspecialchars($alimentoSeleccionado["nombre"], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <p class="nivel detalle-nivel">Nivel nutricional: <strong><?= htmlspecialchars($alimentoSeleccionado["nivel"], ENT_QUOTES, 'UTF-8') ?></strong></p>
            <p class="volver-alimentos"><a href="index.php#alimentos">← Volver a los alimentos</a></p>
        </section>

        <div class="detalle-informacion">
            <section class="detalle-bloque">
                <h2>Descripción</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae justo nec neque tincidunt tincidunt. Sed euismod, sapien vitae consequat tincidunt, neque sapien consequat erat, sit amet feugiat lorem mauris vel erat.</p>
            </section>

            <section class="detalle-bloque">
                <h2>Ingredientes</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consequat, velit at tincidunt malesuada, neque erat tristique nisi, vitae interdum ipsum justo sit amet lectus.</p>
            </section>

            <section class="detalle-bloque">
                <h2>Valor nutricional</h2>
                <div class="tabla-contenedor">
                    <table class="tabla-nutricional">
                        <thead><tr><th>Componente</th><th>Por 100 g</th><th>Por ración</th></tr></thead>
                        <tbody>
                            <tr><td>Valor energético</td><td></td><td></td></tr>
                            <tr><td>Grasas</td><td></td><td></td></tr>
                            <tr><td>de las cuales saturadas</td><td></td><td></td></tr>
                            <tr><td>Hidratos de carbono</td><td></td><td></td></tr>
                            <tr><td>de los cuales azúcares</td><td></td><td></td></tr>
                            <tr><td>Fibra</td><td></td><td></td></tr>
                            <tr><td>Proteínas</td><td></td><td></td></tr>
                            <tr><td>Sal</td><td></td><td></td></tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
<?php else: ?>
    <h1>Alimento no encontrado</h1>
    <p>El alimento que buscas no existe.</p>
    <a href="index.php#alimentos">Volver a los alimentos</a>
<?php endif; ?>
</main>

<footer class="footer">
    <div class="footer-descripcion"><h2>NutriFood</h2><p>Información nutricional clara y accesible.</p></div>
    <div class="footer-enlaces">
        <a href="index.php#categorias">Categorías</a>
        <a href="index.php#alimentos">Alimentos</a>
    </div>
    <p class="copyright">© <?= date("Y") ?> NutriFood<br>Información nutricional orientativa</p>
</footer>
</body>
</html>
