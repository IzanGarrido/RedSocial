<?php
session_start();
require_once 'functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No hay sesión activa']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$contactId = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;

if (!$contactId) {
    echo json_encode(['error' => 'ID de contacto requerido']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];
    
    // Obtener mensajes entre los dos usuarios
    $sql = "SELECT m.ID_MENSAJE, m.CONTENIDO, m.FECHA_MENSAJE, m.IDUSUARIO_ORIGEN,
                   u.USUARIO, u.URL_FOTO
            FROM MENSAJES m
            JOIN USUARIO u ON m.IDUSUARIO_ORIGEN = u.IDUSUARIO
            WHERE (m.IDUSUARIO_ORIGEN = ? AND m.IDUSUARIO_DESTINO = ?)
               OR (m.IDUSUARIO_ORIGEN = ? AND m.IDUSUARIO_DESTINO = ?)
            ORDER BY m.FECHA_MENSAJE ASC
            LIMIT 100";
    
    $mensajes = DB::getAll($sql, [$userId, $contactId, $contactId, $userId]);
    
    // Marcar mensajes del contacto como leídos
    DB::executeQuery(
        "UPDATE MENSAJES SET LEIDO = TRUE WHERE IDUSUARIO_ORIGEN = ? AND IDUSUARIO_DESTINO = ? AND LEIDO = FALSE", 
        [$contactId, $userId]
    );
    
    // Formatear mensajes para el frontend
    $mensajesFormateados = array_map(function($mensaje) use ($userId) {
        return [
            'id' => $mensaje['ID_MENSAJE'],
            'contenido' => htmlspecialchars($mensaje['CONTENIDO']),
            'fecha' => date('H:i', strtotime($mensaje['FECHA_MENSAJE'])),
            'es_propio' => $mensaje['IDUSUARIO_ORIGEN'] == $userId,
            'usuario_origen' => $mensaje['USUARIO'],
            'foto_origen' => $mensaje['URL_FOTO'] ?: '../assets/img/default_profile.png'
        ];
    }, $mensajes);
    
    echo json_encode(['success' => true, 'mensajes' => $mensajesFormateados]);
} catch (Exception $e) {
    error_log("Error en chat_get_messages.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error al obtener mensajes']);
}