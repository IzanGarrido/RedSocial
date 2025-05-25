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

$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

if (!$contact || empty($mensaje)) {
    echo json_encode(['error' => 'Datos incompletos' . $contact . ' ' . $mensaje]);
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    // Verificar que el usuario destino existe
    $contactRow = DB::getOne("SELECT IDUSUARIO FROM USUARIO WHERE USUARIO = ?", [$contact]);

    if (!$contactRow || !isset($contactRow['IDUSUARIO'])) {
        echo json_encode(['error' => 'Usuario no encontrado']);
        exit;
    }
    $contactId = $contactRow['IDUSUARIO'];

    // Insertar el mensaje
    $sql = "INSERT INTO MENSAJES (IDUSUARIO_ORIGEN, IDUSUARIO_DESTINO, CONTENIDO) VALUES (?, ?, ?)";
    $params = [$userId, $contactId, $mensaje];
    $mensajeId = DB::insert($sql, $params);

    if ($mensajeId) {
        // Crear notificación para el destinatario si no es el mismo usuario
        if ($contactId != $userId) {
            addNotification($contactId, $userId, 'sistema');
        }

        echo json_encode([
            'success' => true,
            'mensaje_id' => $mensajeId,
            'fecha' => date('H:i')
        ]);
    } else {
        echo json_encode(['error' => 'Error al enviar el mensaje']);
    }
} catch (Exception $e) {
    error_log("Error en chat_send_message.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error del servidor']);
}
