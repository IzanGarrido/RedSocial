<?php
session_start();

require_once 'functions.php';

// Verify if there is an active session
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
    exit;
}

// Obtain the user ID from the session
$userId = $_SESSION['user_id'];

// Query to read notifications
try {
    $sql = "UPDATE NOTIFICACIONES SET LEIDA = 1 WHERE IDUSUARIO_DESTINO = ?";
    $params = [$userId];
    DB::executeQuery($sql, $params);
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (Exception $th) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
    exit;
}