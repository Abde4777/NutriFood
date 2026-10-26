<?php
require_once "datos.php";

$busqueda = trim($_GET["buscar"] ?? "");
$categoriaElegida = trim($_GET["categoria"] ?? "");

// Filtramos por nombre, descripción y categoría.
$alimentosFiltrados = array_filter($alimentos, function ($alimento) use ($busqueda, $categoriaElegida) {
    $coincideNombre = $busqueda === "" ||
        stripos($alimento["nombre"], $busqueda) !== false ||
        stripos($alimento["descripcion"], $busqueda) !== false;
    $coincideCategoria = $categoriaElegida === "" ||
        $alimento["categoria"] === $categoriaElegida;
    return $coincideNombre && $coincideCategoria;
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriFood | Alimentación</title>
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
        <a class="activo" href="index.php">Inicio</a>
        <a href="#categorias">Categorías</a>
        <a href="#alimentos">Alimentos</a>
    </nav>
    <?php if (($_GET["acceso"] ?? "") === "correcto"): ?>
        <a class="usuario-enlace" href="#" aria-label="Usuario conectado">
            <img src="images/logo_usuario.png" alt="Usuario">
        </a>
    <?php else: ?>
        <a class="login-enlace" href="login.php">Iniciar sesión</a>
    <?php endif; ?>
</header>

<main>
    <section class="hero">
        <div class="hero-texto">
            <h1>NutriFood</h1>
            <p>Descubre la información nutricional de tus alimentos</p>
            <form class="buscador" action="index.php" method="GET">
                <label class="solo-lectores" for="buscar">Buscar alimentos</label>
                <input type="search" id="buscar" name="buscar" placeholder="Busca un alimento..."
                       value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>
        <div class="hero-ilustracion">
            <img src="images/imagen_decorativa.png" alt="Ilustración decorativa de alimentos">
        </div>
    </section>

    <section class="seccion" id="categorias">
        <h2>Categorías</h2>
        <div class="categorias-grid">
            <?php foreach ($categorias as $categoria): ?>
                <a class="categoria-card"
                   href="index.php?categoria=<?= urlencode($categoria["nombre"]) ?>#alimentos">
                    <span class="categoria-nombre"><?= htmlspecialchars($categoria["nombre"], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="categoria-icono"><?= $categoria["icono"] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="seccion alimentos-seccion" id="alimentos">
        <div class="titulo-alimentos">
            <h2>Alimentos</h2>
            <?php if ($categoriaElegida !== "" || $busqueda !== ""): ?>
                <a href="index.php">Mostrar todos</a>
            <?php endif; ?>
        </div>

        <?php if (count($alimentosFiltrados) > 0): ?>
            <div class="alimentos-grid">
                <?php foreach ($alimentosFiltrados as $alimento): ?>
                    <article class="alimento-card">
                        <a class="alimento-imagen" href="alimento.php?slug=<?= urlencode($alimento["slug"]) ?>">
                            <img src="images/Alimentos/<?= htmlspecialchars($alimento["imagen"], ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($alimento["nombre"], ENT_QUOTES, 'UTF-8') ?>">
                        </a>
                        <h3><?= htmlspecialchars($alimento["nombre"], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="descripcion-corta"><?= htmlspecialchars($alimento["descripcion"], ENT_QUOTES, 'UTF-8') ?></p>
                        <span class="etiqueta"><?= htmlspecialchars($alimento["categoria"], ENT_QUOTES, 'UTF-8') ?></span>
                        <p class="nivel">Nivel nutricional: <strong><?= htmlspecialchars($alimento["nivel"], ENT_QUOTES, 'UTF-8') ?></strong></p>
                        <a class="detalle-enlace" href="alimento.php?slug=<?= urlencode($alimento["slug"]) ?>">Ver detalles</a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="sin-resultados">No se han encontrado alimentos de esta categoría.</p>
        <?php endif; ?>

        <!-- Índice visual provisional; todavía no cambia de página. -->
        <nav class="paginacion" aria-label="Paginación">
            <a href="#alimentos" aria-label="Página anterior">&lt;</a>
            <a href="#alimentos" class="pagina-activa">1</a>
            <a href="#alimentos">2</a>
            <a href="#alimentos">3</a>
            <a href="#alimentos" aria-label="Página siguiente">&gt;</a>
        </nav>
    </section>
</main>

<footer class="footer">
    <div class="footer-descripcion">
        <h2>NutriFood</h2>
        <p>Descubre la información nutricional de tus alimentos de forma clara y accesible.</p>
    </div>
    <div class="footer-enlaces">
        <a href="#categorias">Categorías</a>
        <a href="#alimentos">Alimentos</a>
    </div>
    <p class="copyright">© <?= date("Y") ?> NutriFood<br>Información nutricional orientativa</p>
</footer>
</body>
</html>
