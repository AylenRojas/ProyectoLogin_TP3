<?php
$host = "127.0.0.1";
$port = 3306;
$usuario = "root";
$password = ""; // En XAMPP la contraseña por defecto está vacía
$base_datos = "proyecto_login_tp3";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$base_datos;charset=utf8mb4", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>