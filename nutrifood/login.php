<?php
$error = "";
$loginCorrecto = false;

// Leemos las cuentas guardadas en el archivo JSON del prototipo.
$rutaUsuarios = __DIR__ . "/usuarios.json";
$usuariosRegistrados = file_exists($rutaUsuarios)
    ? json_decode(file_get_contents($rutaUsuarios), true)
    : [];
if (!is_array($usuariosRegistrados)) {
    $usuariosRegistrados = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";

    if ($usuario === "" || $contrasena === "") {
        $error = "Introduce tu usuario y contraseña.";
    } elseif (isset($usuariosRegistrados[$usuario]) &&
        password_verify($contrasena, $usuariosRegistrados[$usuario]["contrasena"])) {
        $loginCorrecto = true;
    } else {
        $error = "El usuario o la contraseña no son correctos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | NutriFood</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body class="login-body">
<main class="login-layout">
    <section class="login-panel">
        <div class="login-contenedor">
            <a href="index.php" class="login-logo"><img src="images/logo.png" alt="Logo de NutriFood"></a>

            <?php if ($loginCorrecto): ?>
                <h1>Inicio de sesión</h1>
                <p class="mensaje-correcto">Has iniciado sesión correctamente.</p>
                <p class="enlace-principal"><a href="index.php?acceso=correcto">Ir a la página principal</a></p>
            <?php else: ?>
                <h1>Iniciar sesión</h1>
                <?php if ($error !== ""): ?>
                    <p class="mensaje-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <form class="login-form" action="login.php" method="POST">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" autocomplete="username" required>
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" autocomplete="current-password" required>
                    <button type="submit">Iniciar sesión</button>
                </form>

                <div class="separador"><span>o</span></div>
                <button class="login-social" type="button" disabled><span class="google-icon">G</span>Continuar con Google</button>
                <button class="login-social" type="button" disabled><span class="apple-icon">●</span>Continuar con Apple</button>
                <p class="registro-enlace">¿Eres nuevo? <a href="registro.php">¡Regístrate!</a></p>
                <p class="boton-principal"><a href="index.php">Volver a la página principal</a></p>
            <?php endif; ?>
        </div>
    </section>

    <aside class="login-ilustracion">
        <img src="images/imagen_decorativa.png" alt="Ilustración de alimentos">
    </aside>
</main>
</body>
</html>
