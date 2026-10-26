<?php
$error = "";
$registroCorrecto = false;
$rutaUsuarios = __DIR__ . "/usuarios.json";

// Cargamos las cuentas existentes para comprobar si el usuario ya existe.
$usuariosRegistrados = file_exists($rutaUsuarios)
    ? json_decode(file_get_contents($rutaUsuarios), true)
    : [];
if (!is_array($usuariosRegistrados)) {
    $usuariosRegistrados = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";
    $repetirContrasena = $_POST["repetir_contrasena"] ?? "";

    if ($usuario === "" || $correo === "" || $contrasena === "" || $repetirContrasena === "") {
        $error = "Debes rellenar todos los campos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Introduce un correo electrónico válido.";
    } elseif ($contrasena !== $repetirContrasena) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($contrasena) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif (isset($usuariosRegistrados[$usuario])) {
        $error = "Este nombre de usuario ya está registrado.";
    } else {
        $usuariosRegistrados[$usuario] = [
            "correo" => $correo,
            "contrasena" => password_hash($contrasena, PASSWORD_DEFAULT)
        ];

        // Guardamos las cuentas fuera de la sesión, para poder iniciar sesión después.
        $guardado = file_put_contents(
            $rutaUsuarios,
            json_encode($usuariosRegistrados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );

        if ($guardado === false) {
            $error = "No se ha podido guardar el registro. Comprueba los permisos de la carpeta.";
        } else {
            $registroCorrecto = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | NutriFood</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body class="login-body">
<main class="login-layout">
    <section class="login-panel">
        <div class="login-contenedor">
            <a href="index.php" class="login-logo"><img src="images/logo.png" alt="Logo de NutriFood"></a>

            <?php if ($registroCorrecto): ?>
                <h1>Registro</h1>
                <p class="mensaje-correcto">Te has registrado correctamente.</p>
                <p class="enlace-principal"><a href="index.php?acceso=correcto">Ir a la página principal</a></p>
            <?php else: ?>
                <h1>Crear cuenta</h1>
                <?php if ($error !== ""): ?>
                    <p class="mensaje-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <form class="login-form" action="registro.php" method="POST">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" autocomplete="username" required>
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" autocomplete="email" required>
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" autocomplete="new-password" minlength="8" required>
                    <label for="repetir_contrasena">Repetir contraseña</label>
                    <input type="password" id="repetir_contrasena" name="repetir_contrasena" autocomplete="new-password" minlength="8" required>
                    <button type="submit">Registrarse</button>
                </form>
                <p class="registro-enlace">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
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
