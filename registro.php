<?php
session_start();
require_once "conexion.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmar = $_POST["confirmar_password"] ?? "";

    if (empty($nombre) || empty($apellido) || empty($correo) || empty($password) || empty($confirmar)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirmar) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el correo ya existe
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $check->execute(['correo' => $correo]);

        if ($check->rowCount() > 0) {
            $error = "El correo ya se encuentra registrado.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, password) VALUES (:nombre, :apellido, :correo, :password)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'password' => $passwordHash
            ])) {
                header("Location: index.php?registrado=1");
                exit;
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Proyecto Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="contenedor-card">
        <h1>Crear Cuenta</h1>

        <?php if (!empty($error)): ?>
            <div class="alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="formRegistro" action="registro.php" method="POST">
            <div class="grupo-input">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <span class="ayuda-texto">El nombre es obligatorio</span>
            </div>

            <div class="grupo-input">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                <span class="ayuda-texto">El apellido es obligatorio</span>
            </div>

            <div class="grupo-input">
                <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
                <span class="ayuda-texto">Email @gmail.com obligatorio</span>
            </div>

            <div class="grupo-input">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <span class="ayuda-texto">Min 8 chars, mayúscula, minúscula, número y símbolo</span>
            </div>

            <div class="grupo-input">
                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Repetir contraseña" required>
            </div>

            <span id="errorRegistro" class="error-js"></span>

            <button type="submit" class="btn-primario">Crear Cuenta</button>
        </form>

        <div class="enlaces">
            <a href="index.php">¿Ya tenés cuenta? Iniciar sesión</a>
        </div>
    </div>
    <script src="validaciones.js"></script>
</body>
</html>