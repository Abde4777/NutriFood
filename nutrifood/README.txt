NUTRIFOOD - PROTOTIPO PHP

Archivos principales:
- index.php: página principal y filtros de alimentos.
- alimento.php: detalle de cada alimento.
- login.php: inicio de sesión.
- registro.php: registro de usuarios.
- datos.php: categorías y datos provisionales de alimentos.
- usuarios.json: cuentas del prototipo (no usa MySQL).
- style.css: estilos de la página principal y detalles.
- login.css: estilos de login y registro.

NOTAS:
- El prototipo no utiliza sesiones PHP. Tras iniciar sesión o registrarse, el enlace a la página principal muestra el icono de usuario 
  solo en esa visita, sin mantener la sesión iniciada ni necesitar borrar cookies. 
- Si al iniciar sesión, el usuario quiere volver al login, debe acceder através de la url modificando 'index.php' por 'login.php'.
- Las cuentas se guardan en usuarios.json y las contraseñas se almacenan mediante password_hash.
- Los botones de Google y Apple son decorativos.
- La paginación es visual y todavía no cambia de página.
