<?php
session_start();
require_once "conexion.php";

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!empty($correo) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = :correo");
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    } else {
        $error = "Complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Proyecto Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="contenedor-card">
        <h1>Iniciar sesión</h1>

        <?php if (!empty($error)): ?>
            <div class="alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['registrado'])): ?>
            <div class="alerta-exito">Cuenta creada con éxito. Iniciá sesión.</div>
        <?php endif; ?>

        <form id="formLogin" action="index.php" method="POST">
            <div class="grupo-input">
                <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
                <span class="ayuda-texto">Email @gmail.com obligatorio</span>
            </div>

            <div class="grupo-input">
                <input type="password" id="password" name="password" placeholder="Contraseña" minlength="8" required>
                <span class="ayuda-texto">La contraseña es obligatoria (mín 8)</span>
            </div>

            <span id="errorLogin" class="error-js"></span>

            <button type="submit" class="btn-primario">Ingresar</button>
        </form>

        <div class="enlaces">
            <a href="registro.php">¿No tenés cuenta? Crear una</a>
            <a href="#" onclick="alert('Funcionalidad de recuperación en desarrollo.'); return false;">¿Olvidaste la contraseña?</a>
        </div>
    </div>
    <script src="validaciones.js"></script>
</body>
</html>